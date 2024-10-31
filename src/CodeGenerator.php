<?php

namespace SchemaGen;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class CodeGenerator
{
    protected $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/Templates');
        $this->twig = new Environment($loader);
    }

    public function generateModel(array $modelData): string
    {
        $template = $this->twig->load('Model.php.twig');
        return $template->render($modelData);
    }

    public function generateMigration(array $modelData): string
    {
        $template = $this->twig->load('Migration.php.twig');
        return $template->render($modelData);
    }

    public function generateController(array $controllerData): string
    {
        $template = $this->twig->load('Controller.php.twig');
        return $template->render($controllerData);
    }

    public function generateComponent(array $componentData): string
    {
        $template = $this->twig->load('VueComponent.vue.twig');
        return $template->render($componentData);
    }
}
