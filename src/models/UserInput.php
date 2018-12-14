<?php

namespace unionco\import\models;

use craft\base\Model;
use unionco\import\models\EntryMeta;

class UserInput extends Model
{
    public $entryMeta;
    private $errors;

    public function __construct($formData)
    {
        $this->entryMeta = [];

        // Sort user data into useable components
        $this->parseEntries($formData);
    }

    private function parseEntries($formData)
    {
        // Get all IDs in the 'section' part of the formdata
        $ids = array_keys($formData['section']);

        foreach ($ids as $id) {
            try {
                $entryMeta = new EntryMeta();
                $entryMeta->setId($id);

                $section = $formData['section'][$id];
                $entryMeta->setSection($section);

                $type = $formData['type'][$id];
                $entryMeta->setType($type);

                $author = $formData['author'][$id];
                $entryMeta->setAuthor($author);

                $sites = $formData['sites'][$id];
                $entryMeta->setSites($sites);
            } catch (\Exception $e) {
                $this->errors[] = $e;
            }

            $this->entryMeta[] = $entryMeta;
        }
    }

    public function getEntryMeta()
    {
        return $this->entryMeta;
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
