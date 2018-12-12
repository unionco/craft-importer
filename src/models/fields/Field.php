<?php

namespace unionco\import\models\fields;

use craft\base\Model;

class Field extends Model
{
    public $type;
    public $name;
    public $value;

    public function getType()
    {
        return $this->type;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }
}