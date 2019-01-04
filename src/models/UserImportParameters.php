<?php

namespace unionco\import\models;

use craft\base\Model;
use unionco\import\models\UserImportEntry;

class UserImportParameters extends Model
{
    public $entries;
    private $errors;

    public function __construct(array $formData)
    {
        $this->entries = [];

        // Sort user data into useable components
        $this->parseEntries($formData);
    }

    private function parseEntries(array $formData)
    {
        // Get all IDs in the 'section' part of the formdata
        $ids = array_keys($formData['section']);

        foreach ($ids as $id) {
            $section = $formData['section'][$id];
            $type = $formData['type'][$id];
            $author = $formData['author'][$id];
            $sites = $formData['sites'][$id];

            $entry = new UserImportEntry(compact('id', 'section', 'type', 'author', 'sites'));
            if ($entry->skipped()) {
                $this->errors[] = $entry->getSkipMessage();
                continue;
            }
            $this->entries[] = $entry;
        }
    }

    public function getEntries(): array
    {
        return $this->entries;
    }

    public function valid(): bool
    {
        return !$this->errors;
    }
}
