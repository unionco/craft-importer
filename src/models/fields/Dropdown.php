<?php

namespace unionco\import\models\fields;

use unionco\import\models\fields\Field;

class Dropdown extends Field
{
    public $options;

    public function __construct($name, $value, $options)
    {
        $this->type = 'dropdown';
        $this->name = $name;
        $this->value = $value;
        $this->options = $options;
    }
}
