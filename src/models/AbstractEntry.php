<?php

namespace unionco\import\models;

use Serializable;

class AbstractEntry implements Serializable
{
    public $id;
    public $title;
    public $slug;
    public $section;
    public $type;
    public $author;
    public $sites;
    public $enabled;
    public $postDate;
    public $expiryDate;

    public function serialize(): string
    {
        $data = [
            'id' => $this->id,
            'title' => $this->id,
            'slug' => $this->slug,
            'section' => ($this->section instanceof \craft\models\Section) ? $this->section->id : $this->section,
            'type' => (is_numeric($this->type)) ? $this->type : $this->type->id,
            'author' => $this->author,
            'sites' => array_map(function ($site) {
                return ($site instanceof \craft\models\Site) ? $site->id : $site;
            }, $this->sites),
            'enabled' => $this->enabled,
            'postDate' => $this->postDate,
            'expiryDate' => $this->expiryDate,
        ];

        return serialize($data);
    }

    public function unserialize($serialized): void
    {
        $unserialized = unserialize($serialized);
        $this->id = $unserialized['id'];
        $this->title = $unserialized['title'];
        $this->slug = $unserialized['slug'];
        $this->section = $unserialized['section'];
        $this->type = $unserialized['type'];
        $this->author = $unserialized['author'];
        $this->sites = $unserialized['sites'];
        $this->enabled = $unserialized['enabled'];
        $this->postDate = $unserialized['postDate'];
        $this->expiryDate = $unserialized['expiryDate'];
    }
}
