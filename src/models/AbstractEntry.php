<?php

namespace unionco\import\models;

use craft\base\models;

class AbstractEntry extends Model
{
        public $id;
    public $title;
    public $slug;
    public $section;
    public $type;
    public $author;
    public $sites;
    public $enabled;
    public $postDate;
    public $expiryDate;
}
