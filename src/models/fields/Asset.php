<?php

namespace unionco\import\models\fields;

use unionco\import\models\fields\Field;

class Asset extends Field
{
    public function __construct($name, $value = '')
    {
        $this->type = 'Asset';
        $this->name = $name;
        $this->value = $value;
    }

    public function getValue()
    {
        $output = '';
        foreach ($this->value as $row) {
            if (strlen($output)) {
                $output .= ",";
            }
            $output .= $row;
        }

        return $output;
    }
}