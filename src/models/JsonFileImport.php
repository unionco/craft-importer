<?php

namespace unionco\import\models;

use Craft;
use craft\base\Model;
use unionco\import\models\ImportEntry;
use unionco\import\interfaces\FileImport;

class JsonFileImport extends Model implements FileImport
{
    public $entries;
    public $file;

    public function __construct($filePath)
    {
        $this->file = $filePath;
        $this->parseEntries();
    }

    public function parseEntries() : void
    {
        $this->entries = [];
        $content = json_decode(file_get_contents($this->file));

        foreach ($content as $entry) {
            $this->entries[] = new ImportEntry($entry);
        }
    }

    public function getEntries() : array
    {
        return $this->entries;
    }
}