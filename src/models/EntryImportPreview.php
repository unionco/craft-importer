<?php

namespace unionco\import\models;

use Craft;
use craft\base\Model;

class EntryImportPreview extends Model
{
    protected $entry;
    
    public function __construct(ImportEntry $entry)
    {
        $this->entry = $entry;
    }
}