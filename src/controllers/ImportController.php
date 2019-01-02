<?php
/**
 * Import plugin for Craft CMS 3.x
 *
 * Import data from a Craft 2 JSON export file
 *
 * @link      https://bitbucket.org/unionco
 * @copyright Copyright (c) 2018 UNION
 */

namespace unionco\import\controllers;

use Craft;
use craft\helpers\App;
use craft\web\Controller;
use craft\web\UploadedFile;
use unionco\import\models\Import;
use unionco\import\models\SectionPreview;
use unionco\import\models\EntryPreview;
use unionco\import\models\JsonFileImport;
use unionco\import\models\UserInput;
use unionco\import\models\ImportEntry;

class ImportController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['upload', 'submit'];

    public function actionUpload()
    {
        $uploadedFiles = UploadedFile::getInstancesByName('files');

        $storagePath = Craft::$app->path->getStoragePath() . '/uploads/';
        if (!is_dir($storagePath)) {
            mkdir($storagePath);
        }

        // For now, just allow one file
        $file = $uploadedFiles[0];
        $path = $storagePath . $file->baseName . '.' . $file->extension;
        $file->saveAs($path);

        // parse the file into a useable format
        // -- for now, just JSON
        $import = false;
        switch (strtolower($file->extension)) {
            case 'json':
                $import = new JsonFileImport($path);
                break;
            default:
                return;
        }

        $sectionPreview = new SectionPreview($import);
        //$preview = new ImportPreview($import);

        $sectionOptions = array_map(function ($section) {
            return [
                'value' => $section->id,
                'label' => $section->name,
            ];
        }, Craft::$app->getSections()->getAllSections());

        $defaultOption = [
            'value' => 0,
            'label' => 'Map Section',
        ];
        $sectionOptions = array_merge([$defaultOption], $sectionOptions);

        $serializedSectionPreview = serialize($sectionPreview);

        return $this->renderTemplate('import/sectionPreview/response', [
            'sectionPreview' => $sectionPreview,
            'sectionOptions' => $sectionOptions,
            'file' => $path,
            'serializedSectionPreview' => $serializedSectionPreview,
        ]);
    }

    public function actionPreviewEntries()
    {
        $this->requirePostRequest();

        $formData = Craft::$app->getRequest()->getBodyParams();
        $serialized = $formData['serialized'];
        $sectionPreview = unserialize($serialized);
        $sectionMap = $formData['sectionMapping'] ?? [];

        $entryPreview = new EntryPreview($sectionPreview, $sectionMap);

        return $this->renderTemplate('import/entryPreview/response', [
            'entryPreview' => $entryPreview,
            //'serializedEntryPreview' => serialize($entryPreview),
        ]);
    }

    public function actionSubmit()
    {
        App::maxPowerCaptain();
        $this->requirePostRequest();

        $formData = Craft::$app->getRequest()->getBodyParams();

        //$serialized = $formData['serialized'];
        //$entryPreview = unserialize($serialized);

        $sectionMapping = json_decode($formData['sectionMapping'] ?? "[]", true);
        
        $entries = json_decode($formData['entries'] ?? "[]");
        $entries = array_map(function ($entry) {
            return new ImportEntry($entry->entry);
        }, $entries);
        
        $userInput = new UserInput($formData);

        if (!$userInput->valid()) {
            throw new \Exception('invalid');
        }

        $import = new Import($entries, $sectionMapping, $userInput);
        $results = $import->run();

        return $this->renderTemplate('import/results/response', [
            'results' => $results,
        ]);
        //return json_encode($result);
    }
}
