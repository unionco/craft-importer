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
    const INFO = "info";
    const ERROR = "error";
    const CONTEXT_GLOBAL = "global";
    const CONTEXT_ELEMENT = "element";
    const CONTEXT_MATRIX = "matrix";

    public $currentEntry;
    private $siteId;

    private function log($msg, $context = self::CONTEXT_GLOBAL, $level = self::INFO, $siteId = null, $entry = null)
    {
        if (!$siteId) {
            $siteId = $this->siteId;
        }
        if (!$entry) {
            $entry = $this->currentEntry->original;
        }

        $this->currentEntry->logMsg("[{$context}] [siteId: {$siteId}] [entryId: {$entry->id}] $msg", $level);
    }

    public function updateOrCreate(ImportEntry $importEntry): EntryResult
    {
        $this->currentEntry = new EntryResult($importEntry);
        
        foreach ($importEntry->sites as $siteId) {
            if ($siteId instanceof \craft\models\Site) {
                $siteId = $siteId->id;
            }
            $this->siteId = $siteId;

            $entryQuery = Entry::find();
            if (isset($importEntry->section->id)) {
                $entryQuery = $entryQuery->sectionId($importEntry->section->id);
            }
            
            $entry = $entryQuery
                ->siteId(intval($siteId))
                ->slug($importEntry->slug)
                ->status(null)
                ->one();

            if ($entry) {
                // $this->currentEntry->logMsg("Found existing entry: {$entry->id}");
                $this->log("Found existing entry: {$entry->id}");
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

                $this->populateElementFields($entry, $importEntry, true);

                try {
                    Craft::$app->getElements()->saveElement($entry, false);
                } catch (\Exception $e) {
                    $this->currentEntry->setSuccess(false);
                    $this->log($e->getMessage(), self::CONTEXT_GLOBAL, self::ERROR);
                    return $this->currentEntry;
                    //$this->currentEntry->logMsg($e->getMessage(), EntryResult::ERROR);
                }
            }
        }
        $this->currentEntry->setSuccess(true);
        $this->currentEntry->setEntry($entry);
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
                $this->log("Property {$field->handle} doesn't exist on entry", self::CONTEXT_ELEMENT);
            } else {
                $this->log("Saving entry field: {$fieldType} -> {$field->handle}", self::CONTEXT_ELEMENT);
                switch ($fieldType) {
                    case 'Assets':
                        if ($relationships) {
                            $folderId = $field->resolveDynamicPathToFolderId();
                            $fieldId = $field->id;
                            $assets = $params->fields->{$field->handle}->value;
                            $this->log("Populating {$fieldType} field {$field->handle} with: " . count($assets) . " assets", self::CONTEXT_ELEMENT);
                            $entry->{$field->handle} = array_map(function ($url) use ($folderId, $fieldId, $assetService) {
                                return $assetService->save($folderId, $fieldId, $url);
                            }, $assets);
                        }
                        break;
                    case 'Matrix':
                        $this->log("Populating {$fieldType} field {$field->handle}", self::CONTEXT_ELEMENT);

                        $matrix = $this->populateMatrixFields($params->fields->{$field->handle}, $field, $entry, $relationships);
                        $entry->{$field->handle} = $matrix ?? null;
                        break;
                    case 'Entries':
                        if ($relationships) {
                            $entry->{$field->handle} = array_map(function ($e) {
                                $this->log("Attempt to save related entry: {$e->id}", self::CONTEXT_ELEMENT);
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
                                $this->log("Attempt to save related category: {$e->id}", self::CONTEXT_ELEMENT);
                                $catService = new CategoryService();
                                $catService->site = $this->site;
                                $catService->oldSite = $this->oldSite;

                                $category = $catService->getCategory($e);
                                return $catService->updateOrCreate($category);
                            }, $params->fields->{$field->handle} ?? []);
                            $this->log("Categories to save: " . count($cats), self::CONTEXT_ELEMENT);
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
                    case 'RichText':
                    case 'PlainText':
                    case 'Dropdown':
                    case 'BrandColorsFieldType':
                    case 'ParentChannelFieldType':
                    case 'Date':
                        $value = $params->fields->{$field->handle}->value;
                        $this->log("Populating {$fieldType} field {$field->handle} with: {$value}", self::CONTEXT_ELEMENT);
                        $entry->{$field->handle} = $value;
                        break;
                    case 'IMapFieldType':
                        $entry->{$field->handle} = $params->fields->{$field->handle};
                        break;
                    case 'Lightswitch':
                        $value = (bool) $params->fields->{$field->handle}->value;
                        $this->log("Populating {$fieldType} field {$field->handle} with: {$value}", self::CONTEXT_ELEMENT);
                        $entry->{$field->handle} = $value;
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
                $this->log("Matrix Block Found: {$newSiteBlockType->handle}", self::CONTEXT_MATRIX);

                $fields = $newSiteBlockType->getFields();
                
                $oldValue = MatrixBlock::find()
                    ->id($newSiteBlockType->id)
                    ->owner($entry)
                    ->one();
                
                $newBlocks[$oldValue->id ?? ("new" . ($key + 1))]['type'] = $props;
                $newBlocks[$oldValue->id ?? ("new" . ($key + 1))]['enabled'] = true;

                foreach ($fields as $blockField) {
                    $fieldType = (new \ReflectionClass($blockField))->getShortName();

                    if (!isset($block->$props->{$blockField->handle})) {
                        $this->log("Property {$field->handle} doesn't exist on entry: {$entry->title}", self::CONTEXT_MATRIX);
                    } else {
                        switch ($fieldType) {
                            case 'Assets':
                                if ($relationships) {
                                    $folderId = $blockField->resolveDynamicPathToFolderId();
                                    $fieldId = $blockField->id;
                                    $values = $block->image->images->value ?? [];
                                    $this->log("Populating {$fieldType} field {$blockField->handle} with: " . count($values) . " assets", self::CONTEXT_MATRIX);
                                    $value = array_map(function ($url) use ($folderId, $fieldId, $assetService) {
                                        return $assetService->save($folderId, $fieldId, $url);
                                    }, $values);
                                    $newBlocks[$oldValue->id ?? ("new" . ($key + 1))]['fields'][$blockField->handle] = $value;
                                    //}, $block->$props->{$blockField->handle});
                                }
                                break;
                            case 'Entries':
                                if ($relationships) {
                                    $topLevelKey = $oldValue->id ?? ("new" . ($key + 1));
                                    $values = array_map(function ($e) {
                                        $this->log("Attempt to relate entry: {$e->slug}", self::CONTEXT_MATRIX);
                                        if ($e->type == 'EntryStub') {
                                            $match = Entry::find()
                                                ->slug($e->slug)
                                                ->one();
                                            if ($match) {
                                                $this->log("Found matching entry: {$match->id}", self::CONTEXT_MATRIX);
                                                return $match->id;
                                            } else {
                                                $this->log("Could not find related entry", self::CONTEXT_MATRIX);
                                                return null;
                                            }
                                        }
                                        
                                    }, $block->$props->{$blockField->handle});

                                    $newBlocks[$topLevelKey]['fields'][$blockField->handle] = $values;
                                } else {
                                    $this->log("Skipping entries because relationships are disabled", self::CONTEXT_MATRIX);
                                }
                                break;
                            case 'Categories':
                                if ($relationships) {
                                    $cats = array_map(function ($e) {
                                        $this->log("Attempting to save related category: {$e->id}", self::CONTEXT_MATRIX);
                                        $catService = new CategoryService();
                                        $catService->site = $this->site;
                                        $catService->oldSite = $this->oldSite;

                                        $category = $catService->getCategory($e);
                                        return $catService->updateOrCreate($category);
                                    }, $block->$props->{$blockField->handle} ?? []);

                                    $this->log("Categories to save: " . count($cats), self::CONTEXT_MATRIX);
                                    $newBlocks[$oldValue->id ?? ("new" . ($key + 1))]['fields'][$blockField->handle] = $cats ?? [];
                                } else {
                                    $this->log("Skipping categories because relationships are disabled", self::CONTEXT_MATRIX);
                                }
                                break;
                            case 'Tags':
                                $newBlocks[$oldValue->id ?? ("new" . ($key + 1))]['fields'][$blockField->handle] = $tagService->saveTags($block->$props->{$blockField->handle});
                                break;
                            case 'Table':
                                $value = json_encode($block->$props->{$blockField->handle});
                                $this->log("Populating {$fieldType} field {$blockField->handle} with: {$value}", self::CONTEXT_MATRIX);
                                $newBlocks[$oldValue->id ?? ("new" . ($key + 1))]['fields'][$blockField->handle] = $value;
                                break;
                            case 'Lightswitch';
                                $value = (bool) $block->$props->{$blockField->handle};
                                $this->log("Populating {$fieldType} field {$blockField->handle} with: {$value}", self::CONTEXT_MATRIX);
                                $newBlocks[$oldValue->id ?? ("new" . ($key + 1))]['fields'][$blockField->handle] = $value;
                                break;
                            case 'Field':
                            case 'RichText':
                            case 'PlainText':
                            case 'Dropdown':
                            case 'BrandColorsFieldType':
                            case 'ParentChannelFieldType':
                                $keyVal = $oldValue->id ?? ("new" . ($key + 1));
                                $value = $block->$props->{$blockField->handle}->value;
                                $this->log("Populating {$fieldType} field {$blockField->handle} with: {$value}; key: [{$keyVal}]['fields'][{$blockField->handle}]", self::CONTEXT_MATRIX);
                                $newBlocks[$keyVal]['fields'][$blockField->handle] = $value;
                                break;
                            default:
                                $newBlocks[$oldValue->id ?? ("new" . ($key + 1))]['fields'][$blockField->handle] = $block->$props->{$blockField->handle};
                        }
                    }
                }
            } else {
                $this->log("Matrix block not found: {$props}", self::CONTEXT_MATRIX);
            }
        }

        return $newBlocks;
    }
}
