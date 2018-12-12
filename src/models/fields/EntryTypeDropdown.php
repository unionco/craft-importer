<?php

namespace unionco\import\models\fields;

use Craft;
use unionco\import\models\fields\Dropdown;

class EntryTypeDropdown extends Dropdown
{
    public function __construct($name, $value)
    {
        $this->type = 'type';
        $this->name = $name;
        $this->value = $value;
        
        $sections = Craft::$app->getSections()->getAllSections();
        $entryTypes = [];

        foreach ($sections as $section) {
            $entryTypes[$section->id] = Craft::$app->getSections()
                ->getEntryTypesBySectionId($section->id);
        }
        $this->options = $entryTypes;
    }
}

