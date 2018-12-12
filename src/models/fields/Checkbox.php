<?php

namespace unionco\import\models\fields;

use unionco\import\models\fields\Field;

class Checkbox extends Field
{
    public function __construct($name, $value = '')
    {
        $this->type = 'checkbox';
        $this->name = $name;
        $this->value = $value;
    }
}