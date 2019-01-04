<?php

namespace unionco\import\models;

use Serializable;
use unionco\import\models\FileImport;
class SectionPreview implements Serializable
{
    protected $fileImport;
    protected $existingSections;
    protected $newSections;

    public function __construct(FileImport $fileImport)
    {
        $this->fileImport = $fileImport;
        $this->processFileImport();
    }

    private function processFileImport()
    {
        $this->existingSections = $this->fileImport->getExistingSections();
        $this->newSections = $this->fileImport->getNewSections();
    }

    public function getFileImport(): FileImport
    {
        return $this->fileImport;
    }

    public function getEntries(): array
    {
        return $this->fileImport->entries;
    }

    public function getNewSections(): ?array
    {
        return $this->newSections;
    }

    public function getExistingSections(): ?array
    {
        return $this->existingSections;
    }

    public function serialize(): string
    {
        $data = [
            'file' => $this->fileImport->file,
            'existingSections' => array_map(function ($section) {
                if ($section instanceof \craft\models\Section) {
                    return $section->id;
                } else {
                    return $section;
                }
            }, $this->existingSections),
            'newSections' => $this->newSections,
        ];

        return serialize($data);
    }

    public function unserialize($serialized): void
    {
        $unserialized = unserialize($serialized);
        $this->fileImport = new JsonFileImport($unserialized['file']);
        $this->existingSections = $unserialized['existingSections'];
        $this->newSections = $unserialized['newSections'];
    }
}
