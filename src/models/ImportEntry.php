<?php

namespace unionco\import\models;

use ReflectionClass;
use craft\base\Model;
use unionco\import\models\fields\AuthorDropdown;
use unionco\import\models\fields\Checkbox;
use unionco\import\models\fields\EntryTypeDropdown;
use unionco\import\models\fields\PlainText;
use unionco\import\models\fields\SectionDropdown;

class ImportEntry extends Model
{
    public $id;
    public $title;
    public $slug;
    public $enabled;
    public $section;
    public $type;
    public $postDate;
    public $expiryDate;
    public $author;
    public $fields;

    public static $defaultFields = [
        'id',
        'title',
        'slug',
        'enabled',
        'section',
        'type',
        'postDate',
        'expiryDate',
        'author',
    ];

    public function __construct($data)
    {
        $this->id = new PlainText('id', $data->id);
        $this->title = new PlainText('title', $data->title);
        $this->slug = new PlainText('slug', $data->slug);
        $this->enabled = new Checkbox('enabled', $data->enabled);
        $this->section = new SectionDropdown('section', $data->section);
        $this->type = new EntryTypeDropdown('type', $data->type);
        $this->postDate = new PlainText('postDate', $data->postDate);
        $this->expiryDate = new PlainText('expiryDate', $data->expiryDate);
        $this->author = new AuthorDropdown('author', $data->author);
        $this->fields = static::parseFields($data);
    }

    public function displayFields()
    {
        $fields = [
            'ID' => $this->id,
            'Title' => $this->title,
            'Slug' => $this->slug,
            'Enabled' => $this->enabled,
            'Section' => $this->section,
            'Type' => $this->type,
            'Post Date' => $this->postDate,
            'Expiry Date' => $this->expiryDate,
            'Author' => $this->author,
        ];

        return $fields;
    }

    public function customFields()
    {
        return $this->fields;
    }

    public static function parseFields($data)
    {
        $result = [];

        $fields = json_decode(json_encode($data), true);
        foreach (static::$defaultFields as $defaultField) {
            unset($fields[$defaultField]);
        }

        foreach ($fields as $fieldName => $fieldValue) {
            $value = false;
            $type = false;

            try {
                $value = $fieldValue['value'];
                $type = $fieldValue['type'];
            } catch (\Exception $e) {
                $value = $fieldValue;
                $type = 'Matrix';
            }

            switch ($type) {
                case 'Asset':
                case 'PlainText':
                case 'RichText':
                    $reflectionClass = new ReflectionClass('\\unionco\\import\\models\\fields\\' . $type);
                    $result[$fieldName] = $reflectionClass->newInstance($fieldName, $value);
                    break;

                default:
                    $result[$fieldName] = new PlainText($fieldName, print_r($fieldValue, true));

            }
        }

        return $result;
    }
}
