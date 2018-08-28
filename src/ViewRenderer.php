<?php
namespace paws\twig;

use Paws;
use yii\twig\Twig_Empty_Loader;
use yii\twig\Extension;

class ViewRenderer extends \yii\twig\ViewRenderer
{
    public function init()
    {
        // Create environment with empty loader
        $loader = new Twig_Empty_Loader();
        $this->twig = new \Twig_Environment($loader, array_merge([
            'cache' => Paws::getAlias($this->cachePath),
            'charset' => Paws::$app->charset,
        ], $this->options));

        // Adding custom globals (objects or static classes)
        if (!empty($this->globals)) {
            $this->addGlobals($this->globals);
        }

        // Adding custom functions
        if (!empty($this->functions)) {
            $this->addFunctions($this->functions);
        }

        // Adding custom filters
        if (!empty($this->filters)) {
            $this->addFilters($this->filters);
        }

        $this->addExtensions([new Extension($this->uses)]);

        // Adding custom extensions
        if (!empty($this->extensions)) {
            $this->addExtensions($this->extensions);
        }

        $this->twig->addGlobal('app', Paws::$app);
    }
}