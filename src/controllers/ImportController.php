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
use craft\web\Controller;
use craft\web\UploadedFile;
use craft\helpers\App;
use unionco\import\Import as ImportModule;
use unionco\import\models\Import;
use unionco\import\models\UserInput;
use unionco\import\models\JsonFileImport;
use unionco\import\models\ImportPreview;

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

        $preview = new ImportPreview($import);

        return $this->renderTemplate('import/_/components/importPreview', [
            'preview' => $preview,
            'file' => $path,
        ]);
    }

    public function actionSubmit()
    {
        App::maxPowerCaptain();
        $this->requirePostRequest();

        $formData = Craft::$app->getRequest()->getBodyParams();

        $importFilePath = $formData['importFile'];
        $parts = explode('.', $importFilePath);
        $length = count($parts);

        $extension = $parts[$length-1];

        switch (strtolower($extension)) {
            case 'json':
                $fileImport = new JsonFileImport($importFilePath);
                break;
            default:
                return;
        }

        $userInput = new UserInput($formData);
        if (!$userInput->valid()) {
            throw new \Exception('invalid');
        }

        $import = new Import($fileImport, $userInput);
        $result = $import->run();
        
        return json_encode($result);
    }
}
