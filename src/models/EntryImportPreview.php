<?php

namespace unionco\import\models;

use Craft;
use Serializable;

class EntryImportPreview implements Serializable
{
    public $entry;
    
    public function __construct(ImportEntry $entry, array $sectionMapping)
    {
        if (is_array($entry->section) && key_exists('handle', $entry->section)) {
            $handle = $entry->section['handle'];

            if (key_exists($handle, $sectionMapping)) {
                $sectionId = $sectionMapping[$handle];
                $section = Craft::$app->getSections()->getSectionById($sectionId);
                if ($section) {
                    $entry->section = $section;
                }
            }
        }
        $this->entry = $entry;
    }

    public function serialize(): string
    {
        return serialize($this->entry);
    }

    public function unserialize($serialized): void
    {
        $this->entry = unserialize($serialized);
    }
}