<?php

namespace unionco\import\interfaces;

interface FileImport
{
    public function parseEntries() : void;
    public function getEntries() : array;
}
