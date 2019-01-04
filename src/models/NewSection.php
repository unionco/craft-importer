<?php

namespace unionco\import\models;

class NewSection
{
    public $handle;

    public function __construct($handle)
    {
        $this->handle = $handle;
    }

    public static function unique(array $sections)
    {
        $unique = [];
        foreach ($sections as $section) {
            if (!in_array($section, $unique)) {
                $unique[] = $section;
            }
        }

        return $unique;
    }
}
