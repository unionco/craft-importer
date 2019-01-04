<?php

namespace unionco\import\models;

use Craft;
use craft\models\Section;
use unionco\import\interfaces\Skippable;
use unionco\import\models\AbstractEntry;

class UserImportEntry extends AbstractEntry implements Skippable
{
    public static $newSections = [];
    public static $newTypes = [];
    public static $newAuthors = [];

    private $skip;
    private $skipMessage;

    public function __construct(array $params = [])
    {
        $this->skip = false;

        $id = $params['id'];
        $this->setId($id);

        $section = $params['section'];
        $this->setSection($section);

        $type = $params['type'];
        $this->setType($type);

        $author = $params['author'];
        $this->setAuthor($author);

        $sites = $params['sites'];
        $this->setSites($sites);
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setSection(int $section)
    {
        $this->section = $section;
    }

    public function setType(int $type)
    {
        $this->type = $type;
    }

    public function setAuthor(string $author)
    {
        $author = $author;
    }

    public function setSites(array $sites)
    {
        // Check that these are avalid site ids
        $validSiteIds = Craft::$app->sites->getAllSiteIds();
        foreach ($sites as $siteId) {
            if (!in_array($siteId, $validSiteIds)) {
                $this->skipped = true;
                $this->skipMessage = Import::INVALID_SITE_ID;
                $this->valid = false;
            }
        }

        $this->sites = $sites;
    }

    public function skipped(): bool
    {
        return $this->skip;
    }

    public function getSkipMessage(): string
    {
        return $this->skipMessage;
    }

    public function valid(): bool
    {
        return $this->skip
        && $this->id
        && is_numeric($this->id)
        && $this->section
        && is_numeric($this->section);
    }
}
