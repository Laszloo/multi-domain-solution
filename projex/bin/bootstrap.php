<?php

// bootstrap.php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use DI\Container;
use App\Application\Settings\SettingsInterface;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/config.php';

$containerBuilder = new \DI\ContainerBuilder();

$settings = require_once __DIR__ . '/../app/settings.php';
$settings($containerBuilder);

$container = $containerBuilder->build();
$container->set(EntityManager::class, static function (Container $c): EntityManager {
    $settings = $c->get(SettingsInterface::class);

    // Use the ArrayAdapter or the FilesystemAdapter depending on the value of the 'dev_mode' setting
    // You can substitute the FilesystemAdapter for any other cache you prefer from the symfony/cache library

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
});

return $container;
