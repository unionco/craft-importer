<?php

namespace unionco\import\models;

use craft\elements\Entry;
use unionco\import\services\EntryService;

class EntryResult
{
    public $success;
    public $log;
    public $original;
    public $entry;

    public function __construct(FileImportEntry $entry)
    {
        $this->original = $entry;
        $this->log = [];
        $this->success = false;
    }

    public function setEntry(Entry $entry)
    {
        $this->entry = $entry;
    }

    public function setSuccess(bool $success)
    {
        $this->success = $success;
    }

    public function logMsg($msg, $level = EntryService::INFO): void
    {
        $this->log[] = "[{$level}] {$msg}";
    }

    public function getLog(): string
    {
        $str = '';
        foreach ($this->log as $line) {
            $str = "{$line}" . PHP_EOL;
        }

        return $str;
    }
}
