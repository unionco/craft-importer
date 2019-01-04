<?php

namespace unionco\import\models;

use Craft;
use Serializable;

class EntryImportPreview implements Serializable
{
    public $entry;
    
    public function __construct(FileImportEntry $entry, array $sectionMapping)
    {
        if ($entry->section instanceof \unionco\import\models\NewSection) {
            $handle = $entry->section->handle;

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