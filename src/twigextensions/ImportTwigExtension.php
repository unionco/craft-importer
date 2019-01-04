<?php

namespace unionco\import\twigextensions;

use Craft;
use Twig_Extension;
use unionco\import\Import as ImportPlugin;

class ImportTwigExtension extends Twig_Extension
{
    public function __construct()
    {
        $env = Craft::$app->getView()->getTwig();
        $env->addGlobal('import', ImportPlugin::$plugin);
    }
}
