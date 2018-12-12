<?php

namespace unionco\import\models\fields;

use Craft;
use unionco\import\models\fields\Dropdown;

class SectionDropdown extends Dropdown
{
    public $options;

    public function __construct($name, $value)
    {
        $this->type = 'section';
        $this->name = $name;
        $this->value = $value;
        $this->options = Craft::$app->getSections()->getAllSections();
    }
}

