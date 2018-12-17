<?php

namespace unionco\import\services;

use Craft;
use craft\base\Component;

class TagService extends Component
{
    public function saveTags(array $tags)
    {
        $tagService = Craft::$app->getTags();

        $tagArray = [];

        foreach ($tags as $key => $tag) {
            $tagGroup = $tagService->getTagGroupByHandle($tag->group);

            if (!$tagGroup) {
                continue;
            }

            $newTag = Tag::find()
                ->slug($tag->slug)
                ->groupId($tagGroup->id)
                ->one();

            if (!$newTag) {
                $newTag = new Tag();
                $newTag->groupId = $tagGroup->id;
                $newTag->title = $tag->name;
                $newTag->slug = $tag->slug;

                Craft::$app->getElements()->saveElement($newTag);
            }

            echo "TagService::saveTags {$newTag->id}\n";

            $tagArray[] = $newTag->id;
        }

        return $tagArray;
    }
}
