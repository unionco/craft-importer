<?php

namespace unionco\import\models;

use Craft;
use craft\models\Section;
use craft\base\Model;

class UserInputEntry extends Model
{
    const SECTION_DNE = 'The section does not exist.';
    const TYPE_DNE = 'The entry type does not exist.';

    public static $newSections = [];
    public static $newTypes = [];
    public static $newAuthors = [];

    public $id;
    // public $title;
    // public $slug;
    public $section;
    public $type;
    public $author;
    public $sites;

    public $skip;
    public $skipMessage;

    public function __construct($params = [])
    {
        $this->skip = false;
    }

    public function setId($id)
    {
        $this->id = intval($id);
    }

    public function setSection($sectionStr)
    {
        if (is_numeric($sectionStr)) {
            $this->section = intval($sectionStr);
            return;
        } elseif (strpos($sectionStr, 'new-') !== false) {
            $this->skip = true;
            $this->skipMessage = self::SECTION_DNE;
            return;

            // TODO
            // This is a new section that must be created
            // First, check if we have just added it
            if (in_array($sectionStr, array_keys(static::$newSections))) {
                $this->section = static::$newSections[$sectionStr];
                return;
            }

            // It is not in the new sections array, so we need to create it
            $handle = preg_replace('/new\-/', '', $sectionStr);
            $split = preg_replace('/([a-z])([A-Z])/', '$1 $2', $handle);
            $name = ucwords($split);
            
            //$sectionId = Section::find()->orderBy('id desc')->one()->id + 1;

            $section = new Section();
            //$section->id = $sectionId;
            $section->name = $name;
            $section->handle = $handle;
            $section->type = Section::TYPE_CHANNEL;
            
            $result = Craft::$app->getSections()->saveSection($section);
            if ($result) {
                //static::$newSections[$sectionStr] = $sectionId;
            }
        }
        $this->section = 0;
    }

    public function setType($typeStr)
    {
        if (is_numeric($typeStr)) {
            $this->type = intval($typeStr);
            return;
        } elseif (strpos($typeStr, 'new-') !== false) {
            $this->skip = true;
            $this->skipMessage = self::TYPE_DNE;
            return;
        }
        $this->type = 0;
    }

    public function setAuthor($authorStr)
    {

        $author = $authorStr;
    }

    public function setSites($sitesStr)
    {
        if (is_array($sitesStr)) {
            $sitesStr = $sitesStr[0];
        }
        $sites = explode(',', $sitesStr);
        $sites = array_map(function ($siteId) {
            return intval($siteId);
        }, $sites);
        
        // Check that these are avalid site ids
        $validSiteIds = Craft::$app->sites->getAllSiteIds();
        foreach ($sites as $siteId) {
            if (!in_array($siteId, $validSiteIds)) {
                throw new \Exception('Invalid site ID');
            }
        }

        $this->sites = $sites;
    }

    public function isValid()
    {
        return false;
    }
}