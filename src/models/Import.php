<?php

namespace unionco\import\models;

use unionco\import\Import as ImportPlugin;
use craft\base\Model;
use unionco\import\interfaces\FileImport;
use unionco\import\interfaces\Runnable;
use unionco\import\models\UserInput;

class Import extends Model implements Runnable
{
    protected $entries;
    protected $sectionMapping;
    protected $userInput;
    protected $results;
    
    public function __construct(array $entries, array $sectionMapping, UserInput $userInput)
    {
        $this->entries = $entries;
        $this->sectionMapping = $sectionMapping;
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
            //    throw new \Exception('Import failed');
            }
            //echo "Finished entry {$index}" . PHP_EOL;
            $i++;
            $results[] = $result;
        }

        return $results;
    }

    private function merge()
    {
        $userEntries = $this->userInput->getEntries();
        $mergedEntries = [];

        if (count($this->entries) != count($userEntries)) {
            //throw new \Exception('Number of entries do not match');
        }

        foreach ($this->entries as $entry) {
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
                unset($entry);
                continue;
                throw new \Exception("IDs don't match for: {$entry->id}");
            }

            $entry->resolveDiff($userEntry);

            $merged[] = $entry;
        }

        return $merged;
    }
}
