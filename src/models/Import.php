<?php

namespace unionco\import\models;

use craft\base\Model;
use unionco\import\Import as ImportPlugin;
use unionco\import\interfaces\Runnable;
use unionco\import\models\UserInput;

class Import extends Model implements Runnable
{
    /**
     * array of ImportEntry models
     */
    protected $entries;
    protected $userInput;
    protected $results;

    public function __construct(array $entries, UserInput $userInput)
    {
        $this->entries = $entries;
        $this->userInput = $userInput;
    }

    public function run()
    {
        $service = ImportPlugin::$plugin->entries;

        $entries = $this->merge();
        $results = [];

        foreach ($entries as $entry) {
            $results[] = $service->updateOrCreate($entry);
        }

        return $results;
    }

    /**
     * Combine existing ImportEntry objects (from file import) with user changes (UserImport/UserImportEntry)
     */
    private function merge(): array
    {
        $userEntries = $this->userInput->getEntries();
        $merged = [];

        foreach ($this->entries as $entry) {
            // Find its corresponding user input entry
            $userEntry = null;
            foreach ($userEntries as $userEntryCandidate) {
                if ($userEntryCandidate->id == $entry->id) {
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
