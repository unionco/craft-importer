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
        $entry->setId($id);
        $entry->setSection($section);
        $entry->setType($type);
        $entry->setAuthor($author);
        $entry->setSites($sites);
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setSection(int $section)
    {
        $this->section = intval($sectionStr);
    }

    public function setType(int $type)
    {
        $this->type = $type;
    }

    public function setAuthor(string $author)
    {
        $author = $author;
    }

    public function setSites(string $sitesStr)
    {
        $sites = explode(',', $sitesStr);
        $sites = array_map(function ($siteId) {
            return intval($siteId);
        }, $sites);

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
}
