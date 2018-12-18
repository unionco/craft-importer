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
    protected $results;
    
    public function __construct(FileImport $fileImport, UserInput $userInput)
    {
        $this->fileImport = $fileImport;
        $this->userInput = $userInput;
    }

    public function run()
    {
        $service = ImportPlugin::$plugin->entries;

        $entries = $this->merge();
        $results = [];

        $count = count($entries);
        $i = 1;
        //echo "Starting import of {$count} entries" . PHP_EOL;
        foreach ($entries as $entry) {
            $result = $service->updateOrCreate($entry);
            if (!$result->success) {
                throw new \Exception('Import failed');
            }
            //echo "Finished entry {$index}" . PHP_EOL;
            $i++;
            $results[] = $result;
        }

        return $results;
    }

    private function merge()
    {
        $fileEntries = $this->fileImport->getEntries();
        $userEntries = $this->userInput->getEntries();
        $mergedEntries = [];

        if (count($fileEntries) != count($userEntries)) {
            throw new \Exception('Number of entries do not match');
        }

        foreach ($fileEntries as $entry) {
            // Find its corresponding user input entry
            $userEntry = null;
            foreach ($userEntries as $userEntryCandidate) {
                if ($userEntryCandidate->id == $entry->id) {
                    if ($userEntryCandidate->skipped()) {

                    }
                    $userEntry = $userEntryCandidate;
                    break;
                }
            }

            if (!$userEntry) {
                throw new \Exception("IDs don't match for: {$entry->ID}");
            }

            $entry->resolveDiff($userEntry);

            $merged[] = $entry;
        }

        return $merged;
    }
}
