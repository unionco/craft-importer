<?php

namespace unionco\import\models;

use Craft;
use craft\base\Model;
use ReflectionClass;
use craft\elements\User;

class ImportEntry extends Model
{
    public $id;
    public $title;
    public $slug;
    public $section;
    public $type;
    public $author;
    public $sites;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->title = $data->title;
        $this->slug = $data->slug;
        $this->section = static::matchSection($data->section);
        $this->type = static::matchEntryType($data->type);
        $this->author = $data->author;
        $this->sites = Craft::$app->sites->getAllSites();
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
}
