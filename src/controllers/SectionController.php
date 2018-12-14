<?php

namespace unionco\import\controllers;

use Craft;
use craft\models\Section;
use craft\helpers\UrlHelper;
use craft\controllers\SectionsController as CraftSectionController;
use craft\web\Response;

class SectionController extends CraftSectionController
{
    public function init()
    {
        $this->requireAdmin();
    }

    protected function context()
    {
        return Craft::$app->getRequest()->getParam('context');
    }

    public function actionGetModalBody(): Response
    {
        $sourceKeys = Craft::$app->getRequest()->getParam('sources');
        $elementType = 'craft\\models\\Section'; //$this->elementType();
        $context = $this->context();

        $showSiteMenu = Craft::$app->getRequest()->getParam('showSiteMenu', 'auto');

        if ($showSiteMenu !== 'auto') {
            $showSiteMenu = (bool) $showSiteMenu;
        }
        //$sources = Craft::$app->getSections()->getAllSections();
        // if (is_array($sourceKeys)) {
        //     $sources = [];

        //     foreach ($sourceKeys as $key) {
        //         $source = ElementHelper::findSource($elementType, $key, $context);

        //         if ($source !== null) {
        //             $sources[$key] = $source;
        //         }
        //     }
        // } else {
        //     $sources = Craft::$app->getElementIndexes()->getSources($elementType);
        // }

        // if (!empty($sources) && count($sources) === 1) {
        //     $firstSource = reset($sources);
        //     $showSidebar = !empty($firstSource['nested']);
        // } else {
        //     $showSidebar = !empty($sources);
        // }

        return $this->asJson([
            'html' => $this->getView()->renderTemplate('import/_/partials/section/modalbody', [
                'context' => $context,
                'elementType' => $elementType,
                'sources' => $sources,
                'showSidebar' => false,
                'showSiteMenu' => $showSiteMenu,
            ]),
        ]);
    }

    public function actionNewSectionModal(int $sectionId = null, Section $section = null): Response
    {
        $variables = [
            'sectionId' => $sectionId,
            'brandNewSection' => false,
        ];

        if ($sectionId !== null) {
            if ($section === null) {
                $section = Craft::$app->getSections()->getSectionById($sectionId);

                if (!$section) {
                    throw new NotFoundHttpException('Section not found');
                }
            }

            $variables['title'] = trim($section->name) ?: Craft::t('app', 'Edit Section');
        } else {
            if ($section === null) {
                $section = new Section();
                $variables['brandNewSection'] = true;
            }

            $variables['title'] = Craft::t('app', 'Create a new section');
        }

        $types = [
            Section::TYPE_SINGLE,
            Section::TYPE_CHANNEL,
            Section::TYPE_STRUCTURE,
        ];
        $typeOptions = [];

        // Get these strings to be caught by our translation util:
        // Craft::t('app', 'Channel') Craft::t('app', 'Structure') Craft::t('app', 'Single')

        foreach ($types as $type) {
            $typeOptions[$type] = Craft::t('app', ucfirst($type));
        }

        if (!$section->type) {
            $section->type = Section::TYPE_CHANNEL;
        }

        $variables['section'] = $section;
        $variables['typeOptions'] = $typeOptions;

        $variables['crumbs'] = [
            [
                'label' => Craft::t('app', 'Settings'),
                'url' => UrlHelper::url('settings'),
            ],
            [
                'label' => Craft::t('app', 'Sections'),
                'url' => UrlHelper::url('settings/sections'),
            ],
        ];

        return $this->asJson([
            'html' => $this->getView()->renderTemplate('import/_/partials/section/_edit', $variables),
            // [
            //     'context' => $context,
            //     'elementType' => $elementType,
            //     'sources' => $sources,
            //     'showSidebar' => false,
            //     'showSiteMenu' => $showSiteMenu,
            // ]),
        // ]);
        ]);
    }
    

    public function actionTypes(int $id)
    {
        return json_encode(Craft::$app->getSections()->getEntryTypesBySectionId($id));
        //return json_encode(['id' => $id]);
    }
}
