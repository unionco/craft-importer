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
        // $this->options = array_map(function ($section) {
        //     return [
        //         'value' => $section->id,
        //         'label' => $section->name,
        //     ];
        // }, Craft::$app->getSections()->getAllSections());
        $this->options = Craft::$app->getSections()->getAllSections();
    }
}

