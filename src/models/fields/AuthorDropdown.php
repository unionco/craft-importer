<?php

namespace unionco\import\models\fields;

use craft\elements\User;
use unionco\import\models\fields\Dropdown;

class AuthorDropdown extends Dropdown
{
    public function __construct($name, $value)
    {
        $this->type = 'author';
        $this->name = $name;
        $this->value = $value;
        $this->options = User::find()->all();
    }
}

