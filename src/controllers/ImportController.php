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
use unionco\import\Import;
use unionco\import\models\JsonFileImport;

/**
 * Import Controller
 *
 * Generally speaking, controllers are the middlemen between the front end of
 * the CP/website and your plugin’s services. They contain action methods which
 * handle individual tasks.
 *
 * A common pattern used throughout Craft involves a controller action gathering
 * post data, saving it on a model, passing the model off to a service, and then
 * responding to the request appropriately depending on the service method’s response.
 *
 * Action methods begin with the prefix “action”, followed by a description of what
 * the method does (for example, actionSaveIngredient()).
 *
 * https://craftcms.com/docs/plugins/controllers
 *
 * @author    UNION
 * @package   Import
 * @since     0.0.1
 */
class ImportController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['index', 'do-something', 'upload'];

    // Public Methods
    // =========================================================================

    /**
     * Handle a request going to our plugin's index action URL,
     * e.g.: actions/import/import
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $result = 'Welcome to the ImportController actionIndex() method';

        return $result;
    }

    /**
     * Handle a request going to our plugin's actionDoSomething URL,
     * e.g.: actions/import/import/do-something
     *
     * @return mixed
     */
    public function actionDoSomething()
    {
        $result = 'Welcome to the ImportController actionDoSomething() method';

        return $result;
    }

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

        $import = false;
        switch (strtolower($file->extension)) {
            case 'json':
                $import = new JsonFileImport($path);
                break;
            default:
                return;
        }

        $entries = $import->getEntries();

        return $this->renderTemplate('import/_/components/fileImport', [
            'entries' => $entries,
        ]);
    }
}
