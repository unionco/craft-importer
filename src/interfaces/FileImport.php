<?php

namespace unionco\import\interfaces;

interface FileImport
{
    public function parseEntries();
    public function getEntries();
}
