<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => APP_MODE !== 'PROD', // Should be set to false in production
                'logError'            => false,
                'logErrorDetails'     => false,
                'logger' => [
                    'name' => 'slim-app',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
                'doctrine' => [
                    // Enables or disables Doctrine metadata caching
                    // for either performance or convenience during development.
                    'dev_mode' => APP_MODE === 'DEV',

                    // Path where Doctrine will cache the processed metadata
                    // when 'dev_mode' is false.
                    'cache_dir' => APP_ROOT . '/var/doctrine',

                    // List of paths where Doctrine will search for metadata.
                    // Metadata can be either YML/XML files or PHP classes annotated
                    // with comments or PHP8 attributes.
                    'metadata_dirs' => [APP_ROOT . '/src/Domain'],

                    // The parameters Doctrine needs to connect to your database.
                    // These parameters depend on the driver (for instance the 'pdo_sqlite' driver
                    // needs a 'path' parameter and doesn't use most of the ones shown in this example).
                    // Refer to the Doctrine documentation to see the full list
                    // of valid parameters: https://www.doctrine-project.org/projects/doctrine-dbal/en/current/reference/configuration.html
                    'connection' => [
                        'driver' => 'pdo_mysql',
                        'host' => $_ENV['DATABASE_HOST'],
                        'port' => $_ENV['DATABASE_PORT'],
                        'dbname' => $_ENV['DATABASE_NAME'],
                        'user' => $_ENV['DATABASE_USERNAME'],
                        'password' => $_ENV['DATABASE_PASSWORD'],
                        'charset' => 'utf8'
                    ]
                ]
            ]);
        }
    ]);
};

