<?php

namespace unionco\import\models;

use craft\base\Model;
use unionco\import\models\UserInputEntry;

class UserInput extends Model
{
    public $entries;
    private $errors;

    public function __construct($formData)
    {
        $this->entries = [];

        // Sort user data into useable components
        $this->parseEntries($formData);
    }

    private function parseEntries($formData)
    {
        // Get all IDs in the 'section' part of the formdata
        $ids = array_keys($formData['section']);

        foreach ($ids as $id) {
            try {
                $entry = new UserInputEntry();
                $entry->setId($id);

                $section = $formData['section'][$id];
                $entry->setSection($section);

                $type = $formData['type'][$id];
                $entry->setType($type);

                $author = $formData['author'][$id];
                $entry->setAuthor($author);

                $sites = $formData['sites'][$id];
                $entry->setSites($sites);
            } catch (\Exception $e) {
                $this->errors[] = $e;
            }

            $this->entries[] = $entry;
        }
    }

    public function getEntries()
    {
        return $this->entries;
    }

    public function valid()
    {
        return true;
    }
    // public function hasErrors()
    // {
    //     return $this->errors && count($this->errors);
    // }
}
