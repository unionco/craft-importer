<?php

namespace unionco\import\models;

use Craft;

class SectionMap
{
    public $map;
    public $suggested;

    public function __construct()
    {
        $this->map = [];
        $this->suggested = [];
    }

    public function suggested(string $sectionHandle): int
    {
        if (key_exists($sectionHandle, $this->suggested)) {
            return $this->suggested[$sectionHandle];
        }

        return 0;
    }

    public static function findSuggestions(array $newSections, SectionMap &$sectionMap): void
    {
        foreach ($newSections as $section) {
            if (in_array($section->handle, $sectionMap->suggested)) {
                continue;
            }

            $max = [
                'percentage' => 0.0,
                'handle' => '',
                'value' => 0,
            ];

            foreach (Craft::$app->getSections()->getAllSections() as $siteSection) {
                $percentage = 0.0;
                similar_text($siteSection->handle, $section->handle, $percentage);

                if ($percentage > $max['percentage']) {
                    $max = [
                        'percentage' => $percentage,
                        'handle' => $section->handle,
                        'value' => $siteSection->id,
                    ];
                }
            }

            $sectionMap->suggested[$section->handle] = $max['value'];
        }
    }
}
