<?php

namespace unionco\import\models;

use craft\base\Model;
use unionco\import\Import as ImportPlugin;
use unionco\import\interfaces\Runnable;
use unionco\import\models\userImportParams;

class ImportRunner extends Model implements Runnable
{
    /**
     * array of FileImportEntry models
     */
    protected $entries;
    protected $userImportParams;
    protected $results;

    public function __construct(array $entries, UserImportParameters $userImportParams)
    {
        $this->entries = $entries;
        $this->userImportParams = $userImportParams;
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
     * Combine existing FileImportEntry objects (from file import) with user changes (UserImport/UserImportEntry)
     */
    private function merge(): array
    {
        $userEntries = $this->userImportParams->getEntries();
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
