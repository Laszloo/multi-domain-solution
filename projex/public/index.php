<?php

declare(strict_types=1);

use App\Application\Handlers\HttpErrorHandler;
use App\Application\Handlers\ShutdownHandler;
use App\Application\ResponseEmitter\ResponseEmitter;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/config.php';

$domain = require __DIR__ . '/../app/domainpreloader.php';
define('DOMAIN', $domain);

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

if (APP_MODE === 'PROD') { // Should be set to true in production
	$containerBuilder->enableCompilation(__DIR__ . '/../var/cache');
}

// Set up settings
$settings = require __DIR__ . '/../app/settings.php';
$settings($containerBuilder);

// Set up dependencies
$dependencies = require __DIR__ . '/../app/dependencies.php';
$dependencies($containerBuilder);

// Set up repositories
$repositories = require __DIR__ . '/../app/repositories.php';
$container = null;
if (is_file(__DIR__ . '/../app/' . DOMAIN . '/repositories.php')) {
    $container = require __DIR__ . '/../app/' . DOMAIN . '/repositories.php';
}
$repositories($containerBuilder, $container);

// Set up services
$services = require __DIR__ . '/../app/services.php';
$container = null;
if (is_file(__DIR__ . '/../app/' . DOMAIN . '/services.php')) {
    $container = require __DIR__ . '/../app/' . DOMAIN . '/services.php';
}
$services($containerBuilder, $container);

// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Instantiate the app
AppFactory::setContainer($container);
$app = AppFactory::create();
$callableResolver = $app->getCallableResolver();

// Twig middleware
$twig = Twig::create(APP_ROOT . '/src/Domain/Sites/' . DOMAIN. '/Application/Views', ['cache' => false]);
$app->add(TwigMiddleware::create($app, $twig));

// Register middleware
$middleware = require __DIR__ . '/../app/middleware.php';
$middleware($app);

// Register routes
$routes = require __DIR__ . '/../app/routes.php';
if (is_file(__DIR__ . '/../app/' . DOMAIN . '/routes.php')) {
    $routes = require __DIR__ . '/../app/' . DOMAIN . '/routes.php';
}
$routes($app);

/** @var SettingsInterface $settings */
$settings = $container->get(SettingsInterface::class);

$displayErrorDetails = $settings->get('displayErrorDetails');
$logError = $settings->get('logError');
$logErrorDetails = $settings->get('logErrorDetails');

// Create Request object from globals
$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();

// Create Error Handler
$responseFactory = $app->getResponseFactory();
$errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);

// Create Shutdown Handler
$shutdownHandler = new ShutdownHandler($request, $errorHandler, $displayErrorDetails);
register_shutdown_function($shutdownHandler);

// Add Routing Middleware
$app->addRoutingMiddleware();

// Add Body Parsing Middleware
$app->addBodyParsingMiddleware();

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, $logError, $logErrorDetails);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

// Run App & Emit Response
$response = $app->handle($request);
$responseEmitter = new ResponseEmitter();
$responseEmitter->emit($response);
