<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        EntityManagerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $cache = $settings->get('doctrine')['dev_mode'] ?
                new ArrayAdapter() :
                new FilesystemAdapter(directory: $settings->get('doctrine')['cache_dir']);

            $config = ORMSetup::createAttributeMetadataConfiguration(
                $settings->get('doctrine')['metadata_dirs'],
                $settings->get('doctrine')['dev_mode'],
                null,
                $cache
            );

            $connection = DriverManager::getConnection($settings->get('doctrine')['connection']);

            return new EntityManager($connection, $config);
        }
    ]);
};
