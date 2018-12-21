<?php

namespace unionco\import\models;

use Craft;
use Serializable;
use craft\models\Section;
use unionco\import\models\FileImport;
use unionco\import\models\EntryImportPreview;

class EntryPreview implements Serializable
{
    protected $sectionPreview;
    protected $sectionMapping;
    protected $entries;
    
    public function __construct(SectionPreview $sectionPreview, array $sectionMapping)
    {
        $this->sectionPreview = $sectionPreview;
        $this->sectionMapping = $sectionMapping;
        $this->entries = [];
        $this->initEntries();
    }

    private function initEntries()
    {
        foreach ($this->sectionPreview->getFileImport()->getEntries() as $entry) {
            $this->entries[] = new EntryImportPreview($entry, $this->sectionMapping);
        }
    }

    public function getEntries()
    {
        return $this->entries;
    }

    public function serialize():string
    {
        return serialize($this->entries);
    }

    public function unserialize($serialized): void
    {
        $this->entries = unserialize($serialized);
        //    $unserialized = unserialize($serialized);
        // $this->sectionPreview = $unserialized['sectionPreview'];
        // $this->entries = $unserialized['entries'];
    }
}
