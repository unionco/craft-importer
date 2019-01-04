<?php
/**
 * Import plugin for Craft CMS 3.x
 *
 * Import data from a Craft 2 JSON export file
 *
 * @link      https://bitbucket.org/unionco
 * @copyright Copyright (c) 2018 UNION
 */

namespace unionco\import;

use Craft;
use craft\base\Plugin;
use craft\console\Application as ConsoleApplication;
use craft\events\RegisterCpNavItemsEvent;
use craft\events\RegisterTemplateRootsEvent;
use craft\events\RegisterUrlRulesEvent;
use craft\web\twig\variables\Cp;
use craft\web\UrlManager;
use craft\web\View;
use unionco\import\models\Settings;
use unionco\import\services\Entry as EntryService;
use unionco\import\twigextensions\ImportTwigExtension;
use yii\base\Event;

class Import extends Plugin
{
    public static $plugin;
    public $schemaVersion = '0.0.1';

    public function init()
    {
        parent::init();
        self::$plugin = $this;

        // Add in our console commands
        if (Craft::$app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'unionco\import\console\controllers';
        }

        Craft::$app->view->twig->addExtension(new ImportTwigExtension());

        Event::on(
            Cp::class,
            Cp::EVENT_REGISTER_CP_NAV_ITEMS,
            function (RegisterCpNavItemsEvent $event) {
                $event->navItems[] = [
                    'url' => 'import',
                    'label' => 'Import',
                    'icon' => '@unionco/import/assetbundles/import/dist/img/icon.svg',
                ];
            }
        );

        // Register our CP routes
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['import/sections/new'] = 'import/section/new-section-modal';
                $event->rules['import/sections/types/<id:\d+>'] = 'import/section/types';
                $event->rules['import/upload'] = 'import/import/upload';
                $event->rules['import/preview-entries'] = 'import/import/preview-entries';
                $event->rules['import/submit'] = 'import/import/submit';
            }
        );

        // Base template directory
        Event::on(View::class, View::EVENT_REGISTER_CP_TEMPLATE_ROOTS, function (RegisterTemplateRootsEvent $e) {
            if (is_dir($baseDir = $this->getBasePath() . DIRECTORY_SEPARATOR . 'templates')) {
                $e->roots[$this->id] = $baseDir;
            }
        });

        $this->setComponents([
            'entries' => \unionco\import\services\EntryService::class,
            'assets' => \unionco\import\services\AssetService::class,
            'tags' => \unionco\import\services\TagService::class,
            'sections' => \unionco\import\services\SectionService::class,
        ]);

        Craft::info(
            Craft::t(
                'import',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    protected function createSettingsModel()
    {
        return new Settings();
    }

    // protected function settingsHtml(): string
    // {
    //     return Craft::$app->view->renderTemplate(
    //         'import/settings',
    //         [
    //             'settings' => $this->getSettings()
    //         ]
    //     );
    // }
}
