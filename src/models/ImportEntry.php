<?php

namespace unionco\import\models;

use Craft;
use craft\elements\User;
use Serializable;
use unionco\import\models\AbstractEntry;

class ImportEntry extends AbstractEntry implements Serializable
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
        $this->postDate = $data->postDate;
        $this->expiryDate = $data->expiryDate;
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

    public static function matchSection($sectionHandle): ?\craft\models\Section
    {
        if ($sectionHandle instanceof \stdClass) {
            $sectionHandle = $sectionHandle->handle;
        }

        $section = Craft::$app->getSections()->getSectionByHandle($sectionHandle);

        return $section;
    }

    public static function matchEntryType($entryTypeHandle): ?\craft\models\EntryType
    {
        if ($entryTypeHandle instanceof \stdClass) {
            $entryTypeHandle = $entryTypeHandle->handle;
        }
        $entryTypes = Craft::$app->getSections()->getEntryTypesByHandle($entryTypeHandle);
        
        return $entryTypes[0];
    }

    public function getAuthors(): array
    {
        return array_map(function ($author) {
            return [
                'name' => $author->email,
                'value' => $author->id,
                'label' => $author->email,
            ];
        }, User::find()->all());
    }

    public function getSites(): array
    {
        return array_map(function ($site) {
            return [
                'name' => $site->name,
                'value' => $site->id,
                'label' => $site->name,
            ];
        }, Craft::$app->sites->getAllSites());
    }

    public function resolveDiff(AbstractEntry $input)
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

    public function serialize(): string
    {
        $data = [
            'id' => $this->id,
            'title' => $this->id,
            'slug' => $this->slug,
            'section' => ($this->section instanceof \craft\models\Section) ? $this->section->id : $this->section,
            'type' => (is_numeric($this->type)) ? $this->type : $this->type->id,
            'author' => $this->author,
            'sites' => array_map(function ($site) {
                return ($site instanceof \craft\models\Site) ? $site->id : $site;
            }, $this->sites),
            'enabled' => $this->enabled,
            'postDate' => $this->postDate,
            'expiryDate' => $this->expiryDate,
            'fields' => $this->fields,
        ];

        return serialize($data);
    }

    public function unserialize($serialized): void
    {
        $unserialized = unserialize($serialized);
        $this->id = $unserialized['id'];
        $this->title = $unserialized['title'];
        $this->slug = $unserialized['slug'];
        $this->section = $unserialized['section'];
        $this->type = $unserialized['type'];
        $this->author = $unserialized['author'];
        $this->sites = $unserialized['sites'];
        $this->enabled = $unserialized['enabled'];
        $this->postDate = $unserialized['postDate'];
        $this->expiryDate = $unserialized['expiryDate'];
        $this->fields = $unserialized['fields'];
    }
}
