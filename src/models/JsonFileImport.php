<?php

namespace unionco\import\models;

use Craft;
use craft\base\Model;
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

    public function parseEntries()
    {
        $this->entries = json_decode(file_get_contents($this->file));
    }

    public function getEntries()
    {
        return $this->entries;
    }
}