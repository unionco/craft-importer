<?php
/**
 * Import plugin for Craft CMS 3.x
 *
 * Import data from a Craft 2 JSON export file
 *
 * @link      https://bitbucket.org/unionco
 * @copyright Copyright (c) 2018 UNION
 */

namespace unionco\import\services;

use Craft;
use craft\base\Component;
use craft\elements\Entry;
use DateTime;
use unionco\import\Import;
use unionco\import\models\ImportEntry;

/**
 * Entry Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    UNION
 * @package   Import
 * @since     0.0.1
 */
class EntryService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * This function can literally be anything you want, and you can have as many service
     * functions as you want
     *
     * From any other plugin file, call it like this:
     *
     *     Import::$plugin->entry->exampleService()
     *
     * @return mixed
     */
    public function exampleService()
    {
        $result = 'something';
        // Check our Plugin's settings for `someAttribute`
        if (Import::$plugin->getSettings()->someAttribute) {
        }

        return $result;
    }

    public function updateOrCreate(ImportEntry $importEntry)
    {
        foreach ($importEntry->sites as $siteId) {
            $entry = Entry::find()
                ->sectionId($importEntry->section->id)
                ->siteId($siteId)
                ->slug($importEntry->slug)
                ->status(null)
                ->one();

            if (!$entry) {
                $entry = new Entry();
                $entry->sectionId = $importEntry->section->id;
                $entry->typeId = $importEntry->type->id;
                $entry->title = $importEntry->title;
                $entry->slug = $importEntry->slug;
                $entry->enabled = $importEntry->enabled;
                $entry->enabledForSite = $importEntry->enabled;
                $entry->postDate = DateTime::createFromFormat('Y-m-d', $importEntry->postDate);
                $entry->expiryDate = isset($importEntry->expiryDate)
                ? DateTime::createFromFormat('Y-m-d', $importEntry->expiryDate)
                : null;
                $this->populateElementFields($entry, $importEntry, false);

                try {
                    Craft::$app->getElements()->saveElement($entry, false);
                } catch (\Exception $e) {
                    var_dump($e->getMessage());
                    die;
                }
            }
        }
    }

    // TODO update all of the methods below

    public function populateElementFields(&$entry, $params, $relationships = false)
    {
        $fieldLayout = $entry->getFieldLayout();
        $fields = $fieldLayout->getFields();

        // services handle
        $assetService = UnionModule::$instance->assets;
        $tagService = UnionModule::$instance->tags;

        foreach ($fields as $field) {
            $fieldType = (new \ReflectionClass($field))->getShortName();

            if (!isset($params->{$field->handle})) {
                echo "Property {$field->handle} doesn't exist on entry: {$entry->title} \n";
            } else {
                echo "      Saving Entry Field: {$fieldType} -> {$field->handle}\n";
                switch ($fieldType) {
                    case 'Assets':
                        // if ($relationships) {
                        $folderId = $field->resolveDynamicPathToFolderId();
                        $entry->{$field->handle} = array_map(function ($url) use ($folderId, $assetService) {
                            return $assetService->save($folderId, $url);
                        }, $params->{$field->handle});
                        // }
                        break;
                    case 'Matrix':
                        $matrix = $this->populateMatrixFields($params->{$field->handle}, $field, $entry, $relationships);
                        $entry->{$field->handle} = $matrix ?? null;
                        break;
                    case 'Entries':
                        if ($relationships) {
                            $entry->{$field->handle} = array_map(function ($e) {
                                echo "          Attempt to save related entry: {$e->id}\n";
                                $entryService = new EntryService();
                                $entryService->site = $this->site;
                                $entryService->oldSite = $this->oldSite;
                                $entryService->saveRelationships = false;

                                $entry = $entryService->getEntry($e);
                                return $entryService->updateOrCreate($entry);
                            }, $params->{$field->handle});
                        }
                        break;
                    case 'Categories':
                        if ($relationships) {
                            $cats = array_map(function ($e) {
                                echo "          Attempt to save related category: {$e->id}\n";
                                $catService = new CategoryService();
                                $catService->site = $this->site;
                                $catService->oldSite = $this->oldSite;

                                $category = $catService->getCategory($e);
                                return $catService->updateOrCreate($category);
                            }, $params->{$field->handle} ?? []);
                            echo "      Cats to save: " . count($cats) . "\n";
                            $entry->{$field->handle} = $cats ?? [];
                        }
                        break;
                    case 'Tags':
                        $entry->{$field->handle} = $tagService->saveTags($params->{$field->handle});
                        break;
                    case 'Table':
                        $entry->{$field->handle} = json_encode($params->{$field->handle});
                        break;
                    case 'Field':
                    case 'PlainText':
                    case 'Dropdown':
                    case 'BrandColorsFieldType':
                    case 'ParentChannelFieldType':
                    case 'Date':
                        $entry->{$field->handle} = $params->{$field->handle};
                        break;
                    case 'IMapFieldType':
                        $entry->{$field->handle} = $params->{$field->handle};
                        break;
                    case 'Lightswitch':
                        $entry->{$field->handle} = (bool) $params->{$field->handle};
                }
            }
        }
    }

    public function populateMatrixFields(array $blocks, $field, $entry, $relationships = false)
    {
        // services handle
        $assetService = UnionModule::$instance->assets;
        $tagService = UnionModule::$instance->tags;

        $blockTypes = $field->getBlockTypes();

        $findBlockTypeByHandle = function ($handle) use ($blockTypes) {
            $key = array_search($handle, array_column($blockTypes, 'handle'));

            if ($key !== false) {
                return $blockTypes[$key];
            }
            return false;
        };

        $newBlocks = [];

        foreach ($blocks as $key => $block) {
            $props = array_keys(get_object_vars($block))[0];
            $newSiteBlockType = $findBlockTypeByHandle($props);

            if ($newSiteBlockType) {
                echo "          Matrix Block Found: {$newSiteBlockType->handle}\n";

                $fields = $newSiteBlockType->getFields();

                $newBlocks[$oldValue ?? "new" . ($key + 1)]['type'] = $props;
                $newBlocks[$oldValue ?? "new" . ($key + 1)]['enabled'] = true;

                foreach ($fields as $blockField) {
                    $fieldType = (new \ReflectionClass($blockField))->getShortName();

                    $oldValue = MatrixBlock::find()
                        ->fieldId($newSiteBlockType->id)
                        ->owner($entry)
                        ->one();

                    echo "              Saving Matrix Field: {$fieldType} -> {$blockField->handle}\n";

                    if (!isset($block->$props->{$blockField->handle})) {
                        echo "              Property {$field->handle} doesn't exist on entry: {$entry->title} \n";
                    } else {
                        switch ($fieldType) {
                            case 'Assets':
                                // if ($relationships) {
                                $folderId = $blockField->resolveDynamicPathToFolderId();
                                $newBlocks[$oldValue ?? "new" . ($key + 1)]['fields'][$blockField->handle] = array_map(function ($url) use ($folderId, $assetService) {
                                    return $assetService->save($folderId, $url);
                                }, $block->$props->{$blockField->handle});
                                // }
                                break;
                            case 'Entries':
                                if ($relationships) {
                                    $newBlocks[$oldValue ?? "new" . ($key + 1)]['fields'][$blockField->handle] = array_map(function ($e) {
                                        echo "                  Attempt to save related entry: {$e->id}\n";
                                        $entryService = new EntryService();
                                        $entryService->site = $this->site;
                                        $entryService->oldSite = $this->oldSite;
                                        $entryService->saveRelationships = false;

                                        $entry = $entryService->getEntry($e);
                                        return $entryService->updateOrCreate($entry);
                                    }, $block->$props->{$blockField->handle});
                                }
                                break;
                            case 'Categories':
                                if ($relationships) {
                                    $cats = array_map(function ($e) {
                                        echo "                  Attempt to save related category: {$e->id}\n";
                                        $catService = new CategoryService();
                                        $catService->site = $this->site;
                                        $catService->oldSite = $this->oldSite;

                                        $category = $catService->getCategory($e);
                                        return $catService->updateOrCreate($category);
                                    }, $block->$props->{$blockField->handle} ?? []);

                                    echo "              Cats to save: " . count($cats) . "\n";
                                    $newBlocks[$oldValue ?? "new" . ($key + 1)]['fields'][$blockField->handle] = $cats ?? [];
                                }
                                break;
                            case 'Tags':
                                $newBlocks[$oldValue ?? "new" . ($key + 1)]['fields'][$blockField->handle] = $tagService->saveTags($block->$props->{$blockField->handle});
                                break;
                            case 'Table':
                                $newBlocks[$oldValue ?? "new" . ($key + 1)]['fields'][$blockField->handle] = json_encode($block->$props->{$blockField->handle});
                                break;
                            case 'Lightswitch';
                                $newBlocks[$oldValue ?? "new" . ($key + 1)]['fields'][$blockField->handle] = (bool) $block->$props->{$blockField->handle};
                                break;
                            case 'Field':
                            case 'PlainText':
                            case 'Dropdown':
                            case 'BrandColorsFieldType':
                            case 'ParentChannelFieldType':
                                $newBlocks[$oldValue ?? "new" . ($key + 1)]['fields'][$blockField->handle] = $block->$props->{$blockField->handle};
                                break;
                            default:
                                $newBlocks[$oldValue ?? "new" . ($key + 1)]['fields'][$blockField->handle] = $block->$props->{$blockField->handle};
                        }
                    }
                }
            } else {
                echo "          Matrix Block Not Found: {$props}\n";
            }
        }

        return $newBlocks;
    }
}
