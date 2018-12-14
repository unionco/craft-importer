<?php

namespace unionco\import\models;

use unionco\import\Import as ImportPlugin;
use craft\base\Model;
use unionco\import\interfaces\FileImport;
use unionco\import\interfaces\Runnable;
use unionco\import\models\UserInput;

class Import extends Model implements Runnable
{
    protected $fileImport;
    protected $userInput;

    public function __construct(FileImport $fileImport, UserInput $userInput)
    {
        $this->fileImport = $fileImport;
        $this->userInput = $userInput;
    }

    public function run()
    {
        $service = ImportPlugin::$plugin->entries;

        $entries = $this->merge();

        foreach ($entries as $entry) {

        }

        return 0;
    }

    private function merge()
    {
        $fileEntries = $this->fileImport->getEntries();
        $userEntries = $this->userInput->getEntryMeta();

        if (count($fileEntries) != count($userEntries)) {
            throw new \Exception('Number of entries do not match');
        }

        foreach ($fileEntries as $entry) {
            // Find its corresponding user input entry
            
        }

    }
}
