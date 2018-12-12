<?php

namespace unionco\import\models\fields;

use unionco\import\models\fields\Field;

class RichText extends Field
{
    public function __construct($name, $value = '')
    {
        $this->type = 'RichText';
        $this->name = $name;
        $this->value = $value;
    }
}