<?php

namespace unionco\import\models;

use Craft;
use craft\base\Model;
use unionco\import\interfaces\FileImport;
use unionco\import\models\EntryImportPreview;

class ImportPreview extends Model
{
    protected $fileImport;
    protected $entries;

    public function __construct(FileImport $fileImport)
    {
        $this->fileImport = $fileImport;
        $this->entries = [];
        $this->processFileImport();
    }

    private function processFileImport()
    {
        foreach ($this->fileImport->getEntries() as $entry) {
            $this->entries[] = new EntryImportPreview($entry);
        }
    }

    public function getEntries()
    {
        return $this->fileImport->entries;
    }
}
