<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Http\Controllers;
use Slim\Factory\AppFactory;
use Slim\Views\TwigMiddleware;
use Slim\Views\Twig;

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$twig = Twig::create(__DIR__ . '/../templates', ['cache' => false]);

$app  = AppFactory::create();
$app->addErrorMiddleware(true, true, true);
$app->add(TwigMiddleware::create($app, $twig));

$app->get('/', Controllers\IndexController::class . ':home');
$app->get('/health', Controllers\IndexController::class . ':health');

$app->get('/messages', Controllers\MessageController::class . ':index');
$app->get('/messages/new', Controllers\MessageController::class . ':newMessage');
$app->post('/messages', Controllers\MessageController::class . ':create');
$app->get('/messages/{id}', Controllers\MessageController::class . ':read');

$app->run();
