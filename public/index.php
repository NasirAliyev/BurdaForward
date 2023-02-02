<?php

use App\Core\Application;
use App\Core\Config;
use App\Core\TemplateEngine\TemplateEngineInterface;
use Symfony\Component\HttpFoundation\Request;

require_once dirname(__DIR__) . '/vendor/autoload.php';

define('ROOT', DIRECTORY_SEPARATOR . dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('APP', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR);
define('CONFIG', ROOT . 'config' . DIRECTORY_SEPARATOR);

// Set the config
$config = (new Config())
    ->setDebugMode(true)
    ->setRoutesDir(CONFIG . 'routes.yml')
    ->setControllersNamespace('App\Presentation\Controllers')
    ->setTemplateDir('Presentation/Views')
    ->setTemplateEngine(TemplateEngineInterface::TEMPLATE_ENGINE_TWIG)
    ->setNotFoundTemplate('not_found.html.twig');

$request = Request::createFromGlobals();

// Build the application
$app = new Application($config, $request);

$app->run();
