<?php

namespace unionco\import\interfaces;

interface Skippable
{
    const SECTION_DNE = 'The section does not exist.';
    const TYPE_DNE = 'The entry type does not exist.';

    public function skipped(): bool;
    public function getSkipMessage(): string;
}
