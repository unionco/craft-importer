<?php

namespace uniono\import\models;

use craft\base\Model;

class EntryResult extends Model
{
    public $success;
    
    public function __construct(ImportEntry $entry)
    {
        
    }
}
