<?php

namespace unionco\import\interfaces;

use unionco\import\interfaces\UserInput;

interface FileImport
{
    public function parseEntries() : void;
    public function getEntries() : array;
}
