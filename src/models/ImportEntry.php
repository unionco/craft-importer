<?php

namespace unionco\import\models;

use Craft;
use craft\base\Model;
use unionco\import\models\fields\PlainText;
use unionco\import\models\fields\Checkbox;

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

    public function __construct($data)
    {
        $this->id = new PlainText('id', $data->id);
        $this->title = new PlainText('title', $data->title);
        $this->slug = new PlainText('slug', $data->slug);
        $this->enabled = new Checkbox('enabled', $data->enabled);

    }

    public function displayFields()
    {
        return [
            $this->id,
            $this->title,
            $this->slug,
            $this->enabled,
        ];
    }
}
