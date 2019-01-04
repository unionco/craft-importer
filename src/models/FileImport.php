<?php

namespace unionco\import\models;

class FileImport
{
    protected $entries;
    public $file;
    protected $sections;

    public function __construct(string $filePath)
    {
        $this->file = $filePath;
        $this->entries = [];
        $this->sections = [];
        $this->parseFile();
    }

    protected function parseFile(): void
    {
        return;
    }

    public function getEntries(): array
    {
        return $this->entries;
    }

    public function getAllSections(): array
    {
        return array_unique($this->sections);
    }

    public function getExistingSections(): array
    {
        return array_unique(
            array_filter(
                $this->sections,
                function ($section) {
                    return ($section instanceof \craft\models\Section);
                }
            )
        );
    }

    public function getNewSections(): array
    {
        $sections = array_filter($this->sections, function ($section) {
            return ($section instanceof \unionco\import\models\NewSection);
        });
        $unique = NewSection::unique($sections);
                
        return $unique;
    }
}
