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
use craft\elements\MatrixBlock;
use DateTime;
use unionco\import\Import;
use unionco\import\models\EntryResult;
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
    public $currentEntry;

    public function updateOrCreate(ImportEntry $importEntry): EntryResult
    {
        $this->currentEntry = new EntryResult($importEntry);

        foreach ($importEntry->sites as $siteId) {
            $entry = Entry::find()
                ->sectionId($importEntry->section->id)
                ->siteId($siteId)
                ->slug($importEntry->slug)
                ->status(null)
                ->one();
            if ($entry) {
                $this->currentEntry->logMsg("Found existing entry: {$entry->id}");
            } else {
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
                    $this->currentEntry->logMsg($e->getMessage(), EntryResult::ERROR);
                }
            }
        }
        $this->currentEntry->setSuccess(true);
        return $this->currentEntry;
    }

    public function populateElementFields(&$entry, $params, $relationships = false)
    {
        $fieldLayout = $entry->getFieldLayout();
        $fields = $fieldLayout->getFields();

        // services handle
        $assetService = Import::$plugin->assets;
        $tagService = Import::$plugin->tags;

        foreach ($fields as $field) {
            $fieldType = (new \ReflectionClass($field))->getShortName();

            if (!isset($params->fields->{$field->handle})) {
                $this->currentEntry->logMsg("Property {$field->handle} doesn't exist on entry: {$entry->title}");
            } else {
                $this->currentEntry->logMsg("Saving Entry Field: {$fieldType} -> {$field->handle}");
                switch ($fieldType) {
                    case 'Assets':
                        if ($relationships) {
                            $folderId = $field->resolveDynamicPathToFolderId();
                            $fieldId = $field->id;
                            $assets = $params->fields->{$field->handle}->value;
                            $this->currentEntry->logMsg("Element | Populating {$fieldType} field {$blockField->handle} with: " . count($assets) . " assets");
                            $entry->{$field->handle} = array_map(function ($url) use ($folderId, $fieldId, $assetService) {
                                return $assetService->save($folderId, $fieldId, $url);
                            }, $assets);
                        }
                        break;
                    case 'Matrix':
                        $this->currentEntry->logMsg("Element | Populating {$fieldType} field {$field->handle}");

                        $matrix = $this->populateMatrixFields($params->fields->{$field->handle}, $field, $entry, $relationships);
                        $entry->{$field->handle} = $matrix ?? null;
                        break;
                    case 'Entries':
                        if ($relationships) {
                            $entry->{$field->handle} = array_map(function ($e) {
                                $this->currentEntry->logMsg("Attempt to save related entry: {$e->id}");
                                $entryService = new EntryService();
                                $entryService->site = $this->site;
                                $entryService->oldSite = $this->oldSite;
                                $entryService->saveRelationships = false;

                                $entry = $entryService->getEntry($e);
                                return $entryService->updateOrCreate($entry);
                            }, $params->fields->{$field->handle});
                        }
                        break;
                    case 'Categories':
                        if ($relationships) {
                            $cats = array_map(function ($e) {
                                $this->currentEntry->logMsg("Attempt to save related category: {$e->id}");
                                $catService = new CategoryService();
                                $catService->site = $this->site;
                                $catService->oldSite = $this->oldSite;

                                $category = $catService->getCategory($e);
                                return $catService->updateOrCreate($category);
                            }, $params->fields->{$field->handle} ?? []);
                            $this->currentEntry->logMsg("Cats to save: " . count($cats));
                            $entry->{$field->handle} = $cats ?? [];
                        }
                        break;
                    case 'Tags':
                        $entry->{$field->handle} = $tagService->saveTags($params->fields->{$field->handle});
                        break;
                    case 'Table':
                        $entry->{$field->handle} = json_encode($params->fields->{$field->handle});
                        break;
                    case 'Field':
                    case 'PlainText':
                    case 'Dropdown':
                    case 'BrandColorsFieldType':
                    case 'ParentChannelFieldType':
                    case 'Date':
                        $value = $params->fields->{$field->handle}->value;
                        $entry->{$field->handle} = $value;
                        break;
                    case 'IMapFieldType':
                        $entry->{$field->handle} = $params->fields->{$field->handle};
                        break;
                    case 'Lightswitch':
                        $entry->{$field->handle} = (bool) $params->fields->{$field->handle}->value;
                }
            }
        }
    }

    public function populateMatrixFields(array $blocks, $field, $entry, $relationships = false)
    {
        // services handle
        $assetService = Import::$plugin->assets;
        $tagService = Import::$plugin->tags;

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
                $this->currentEntry->logMsg("Matrix Block Found: {$newSiteBlockType->handle}");

                $fields = $newSiteBlockType->getFields();

                $newBlocks[$oldValue->id ?? ("new" . ($key + 1))]['type'] = $props;
                $newBlocks[$oldValue->id ?? ("new" . ($key + 1))]['enabled'] = true;

                foreach ($fields as $blockField) {
                    $fieldType = (new \ReflectionClass($blockField))->getShortName();

                    $oldValue = MatrixBlock::find()
                        ->fieldId($newSiteBlockType->fieldId)
                        ->owner($entry)
                        ->one();

                    // $this->currentEntry->logMsg("Saving Matrix Field: {$fieldType} -> {$blockField->handle}");

                    if (!isset($block->$props->{$blockField->handle})) {
                        $this->currentEntry->logMsg("Property {$field->handle} doesn't exist on entry: {$entry->title}");
                    } else {
                        switch ($fieldType) {
                            case 'Assets':
                                if ($relationships) {
                                    $folderId = $blockField->resolveDynamicPathToFolderId();
                                    $fieldId = $blockField->id;
                                    $values = $block->image->images->value ?? [];
                                    $this->currentEntry->logMsg("Matrix | Populating {$fieldType} field {$blockField->handle} with: " . count($values) . " assets");
                                    $value = array_map(function ($url) use ($folderId, $fieldId, $assetService) {
                                        return $assetService->save($folderId, $fieldId, $url);
                                    }, $values);
                                    $newBlocks[$oldValue->id ?? ("new" . ($key + 1))]['fields'][$blockField->handle] = $value;
                                    //}, $block->$props->{$blockField->handle});
                                }
                                break;
                            case 'Entries':
                                if ($relationships) {
                                    $newBlocks[$oldValue->id ?? ("new" . ($key + 1))]['fields'][$blockField->handle] = array_map(function ($e) {
                                        $this->currentEntry->logMsg("Attempt to save related entry: {$e->id}");
                                        $entryService = new EntryService();
                                        $entryService->site = $this->site;
                                        $entryService->oldSite = $this->oldSite;
                                        $entryService->saveRelationships = false;

                                        $entry = $entryService->getEntry($e);
                                        $this->currentEntry->logMsg("Matrix | processing entry {$blockField->handle}");

                                        return $entryService->updateOrCreate($entry);
                                    }, $block->$props->{$blockField->handle});
                                } else {
                                    $this->currentEntry->logMsg("Matrix | skipping entries because relationships are disabled");
                                }
                                break;
                            case 'Categories':
                                if ($relationships) {
                                    $cats = array_map(function ($e) {
                                        $this->currentEntry->logMsg("Attempt to save related category: {$e->id}");
                                        $catService = new CategoryService();
                                        $catService->site = $this->site;
                                        $catService->oldSite = $this->oldSite;

                                        $category = $catService->getCategory($e);
                                        return $catService->updateOrCreate($category);
                                    }, $block->$props->{$blockField->handle} ?? []);

                                    $this->currentEntry->logMsg("Matrix | Categories to save: " . count($cats));
                                    $newBlocks[$oldValue->id ?? ("new" . ($key + 1))]['fields'][$blockField->handle] = $cats ?? [];
                                } else {
                                    $this->currentEntry->logMsg("Matrix | skipping categories because relationships are disabled");
                                }
                                break;
                            case 'Tags':
                                $newBlocks[$oldValue->id ?? ("new" . ($key + 1))]['fields'][$blockField->handle] = $tagService->saveTags($block->$props->{$blockField->handle});
                                break;
                            case 'Table':
                                $this->currentEntry->logMsg("Matrix | Populating {$fieldType} field {$blockField->handle} with value: {$value}");
                                $newBlocks[$oldValue->id ?? ("new" . ($key + 1))]['fields'][$blockField->handle] = json_encode($block->$props->{$blockField->handle});
                                break;
                            case 'Lightswitch';
                                $this->currentEntry->logMsg("Matrix | Populating {$fieldType} field {$blockField->handle} with value: {$value}");
                                $newBlocks[$oldValue->id ?? ("new" . ($key + 1))]['fields'][$blockField->handle] = (bool) $block->$props->{$blockField->handle};
                                break;
                            case 'Field':
                            case 'PlainText':
                            case 'Dropdown':
                            case 'BrandColorsFieldType':
                            case 'ParentChannelFieldType':
                                $value = $block->$props->{$blockField->handle}->value;
                                $this->currentEntry->logMsg("Matrix | Populating {$fieldType} field {$blockField->handle} with value: {$value}");
                                $newBlocks[$oldValue->id ?? ("new" . ($key + 1))]['fields'][$blockField->handle] = $value;
                                break;
                            default:
                                $newBlocks[$oldValue->id ?? ("new" . ($key + 1))]['fields'][$blockField->handle] = $block->$props->{$blockField->handle};
                        }
                    }
                }
            } else {
                $this->currentEntry->logMsg("Matrix Block Not Found: {$props}");
            }
        }

        return $newBlocks;
    }
}
