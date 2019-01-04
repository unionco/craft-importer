<?php

namespace unionco\import\services;

use Craft;
use craft\base\Component;

class SectionService extends Component
{
    /**
     * Return site sections in a select/dropdown-friendly format
     */
    public function getSectionOptions(array $defaultOption = []): array
    {
        $sectionOptions = array_map(function ($section) {
            return [
                'value' => $section->id,
                'label' => $section->name,
            ];
        }, Craft::$app->getSections()->getAllSections());

        if (count($defaultOption)) {
            $sectionOptions = array_merge([$defaultOption], $sectionOptions);
        }

        return $sectionOptions;
    }

    public function getEntryTypeOptions(int $sectionId): array
    {
        return array_map(function ($entryType) {
            return [
                'name' => $entryType->name,
                'value' => $entryType->id,
                'label' => $entryType->name,
            ];
        }, Craft::$app->getSections()->getEntryTypesBySectionId($sectionId));
    }
}
