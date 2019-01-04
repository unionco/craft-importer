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
use unionco\import\models\FileImportEntry;
use unionco\import\models\ImportPreview;
use unionco\import\models\ImportRunner;
use unionco\import\models\JsonFileImport;
use unionco\import\models\SectionPreview;
use unionco\import\models\UserImportParameters;

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

    public function actionUpload(): ?\yii\web\Response
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
                throw new \Exception('Unsupported file format');
                return null;
        }

        $sectionPreview = new SectionPreview($import);
        $serializedSectionPreview = serialize($sectionPreview);

        return $this->renderTemplate('import/sectionPreview/response', [
            'sectionPreview' => $sectionPreview,
            'file' => $path,
            'serializedSectionPreview' => $serializedSectionPreview,
        ]);
    }

    public function actionPreviewEntries(): \yii\Web\Response
    {
        $this->requirePostRequest();

        $formData = Craft::$app->getRequest()->getBodyParams();
        $serialized = $formData['serialized'];
        $sectionPreview = unserialize($serialized);

        $sectionMap = $formData['sectionMapping'] ?? [];

        $importPreview = new ImportPreview($sectionPreview, $sectionMap);

        return $this->renderTemplate('import/importPreview/response', [
            'importPreview' => $importPreview,
        ]);
    }

    public function actionSubmit(): \craft\web\Response
    {
        App::maxPowerCaptain();
        $this->requirePostRequest();

        $formData = Craft::$app->getRequest()->getBodyParams();

        $entries = json_decode($formData['entries'] ?? "[]");
        $entries = array_map(function ($entry) {
            return new FileImportEntry($entry->entry);
        }, $entries);

        $userInput = new UserImportParameters($formData);

        if (!$userInput->valid()) {
            throw new \Exception('invalid');
        }

        $import = new ImportRunner($entries, $userInput);
        $results = $import->run();

        return $this->renderTemplate('import/results/response', [
            'results' => $results,
        ]);
        //return json_encode($result);
    }
}
