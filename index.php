<?php

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/vendor/autoload.php';

$container = new Container();

$container->set('view', function() {
    return Twig::create(__DIR__ . '/src/templates');
});

AppFactory::setContainer($container);
$app = AppFactory::create();
$app->add(TwigMiddleware::createFromContainer($app));

$app->get('/', function (Request $request, Response $response, array $args) {
    return $this
        ->get('view')
        ->render($response, 'index.html.twig');
});

$app->run();
