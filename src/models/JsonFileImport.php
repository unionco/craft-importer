<?php

namespace unionco\import\models;

use unionco\import\models\FileImport;
use unionco\import\models\FileImportEntry;

class JsonFileImport extends FileImport
{
    protected function parseFile(): void
    {
        $content = json_decode(file_get_contents($this->file));

        // Parse through entries
        $entries = [];

        foreach ($content as $entry) {
            $entries[] = new FileImportEntry($entry);
        }

        $this->entries = $entries;

        // Parse through sections
        $sections = [];
        foreach ($this->entries as $entry) {
            $sections[] = $entry->section;
        }
        $this->sections = $sections;

    }
}
