<?php

namespace unionco\import\models;

use craft\base\Model;

class EntryResult extends Model
{
    const INFO = 'info';
    const ERROR = 'error';
    
    public $success;
    public $log;
    public $original;

    public function __construct(ImportEntry $entry)
    {
        $this->original = $entry;
        $this->log = [];
        $this->success = false;
    }

    public function setSuccess(bool $success)
    {
        $this->success = $success;
    }

    public function logMsg($msg, $level = self::INFO) : void
    {
        $this->log[] = "[{$level}] {$msg}";
    }

    public function getLog() : string
    {
        $str = '';
        foreach ($this->log as $line) {
            $str = "{$line}" . PHP_EOL;
        }

        return $str;
    }
}
