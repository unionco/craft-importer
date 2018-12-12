<?php

namespace unionco\import\models\fields;

use unionco\import\models\fields\Field;

class PlainText extends Field
{
    public function __construct($name, $value = '')
    {
        $this->type = 'text';
        $this->name = $name;
        $this->value = $value;
    }
}