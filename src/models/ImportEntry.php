<?php

namespace unionco\import\models;

use Craft;
use ReflectionClass;
use craft\elements\User;
use unionco\import\models\AbstractEntry;
use unionco\import\models\UserInputEntry;

class ImportEntry extends AbstractEntry
{
    public $fields;

    public function __construct($data)
    {
        $this->id = intval($data->id);
        $this->title = $data->title;
        $this->slug = $data->slug;
        $this->section = static::matchSection($data->section);
        $this->type = static::matchEntryType($data->type);
        $this->author = $data->author;
        $this->sites = Craft::$app->sites->getAllSites();
        $this->enabled = $data->enabled;
        $this->postDate = $data->postDate; //->format('Y-m-d');
        $this->expiryDate = $data->expiryDate; //->format('Y-m-d');
        $this->setFields($data);
    }

    public function setFields($data)
    {
        unset($data->id);
        unset($data->title);
        unset($data->slug);
        unset($data->enabled);
        unset($data->section);
        unset($data->type);
        unset($data->author);
        unset($data->postDate);
        unset($data->expiryDate);
        $this->fields = $data;
    }

    public static function matchSection($sectionHandle)
    {
        if ($section = Craft::$app->getSections()->getSectionByHandle($sectionHandle)) {
            return $section;
        }
        return false;
    }

    public static function matchEntryType($entryTypeHandle)
    {
        if ($entryTypes = Craft::$app->getSections()->getEntryTypesByHandle($entryTypeHandle)) {
            return $entryTypes[0];
        }

        return false;
    }

    public function getSections()
    {
        return array_map(function ($section) {
            return [
                'name' => $section->name,
                'value' => $section->id,
                'label' => $section->name,
            ];
        }, Craft::$app->getSections()->getAllSections());
    }

    public function getEntryTypes()
    {
        if ($this->section) {
            return array_map(function ($entryType) {
                return [
                    'name' => $entryType->name,
                    'value' => $entryType->id,
                    'label' => $entryType->name,
                ];
            }, Craft::$app->getSections()->getEntryTypesBySectionId($this->section->id));
        }
        return [];
    }

    public function getAuthors()
    {
        return array_map(function ($author) {
            return [
                'name' => $author->email,
                'value' => $author->id,
                'label' => $author->email,
            ];
        }, User::find()->all());
    }
    public function getSites()
    {
        return array_map(function ($site) {
            return [
                'name' => $site->name,
                'value' => $site->id,
                'label' => $site->name,
            ];
        }, Craft::$app->sites->getAllSites());
    }

    public function resolveDiff(AbstractEntry $input) : void
    {
        if ($input->section !== intval($this->section->id)) {
            $this->section = Craft::$app->getSections()->getSectionById($input->section);
        }

        if ($input->type !== intval($this->type->id)) {
            $this->type = Craft::$app->getSections()->getEntryTypeById($input->type);
        }

        // author
        $this->sites = $input->sites;
    }
}
