<?php

declare(strict_types=1);

use App\Domain\Sites\TestShopOrg\Application\Actions\HomeAction;
use App\Domain\Sites\TestShopOrg\Application\Actions\BrandAction;
use Slim\App;
//use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->get('/', HomeAction::class);
    $app->get('/product-search', BrandAction::class);
    /*
    $app->get('/category/{name}', HomeAction::class);
    $app->get('/brand/{name}', HomeAction::class);
    $app->get('/type/{name}', HomeAction::class);
    $app->group('/blog', function (Group $group) {
        $group->get('', HomeAction::class);
        $group->get('/{name}', HomeAction::class);
    });
    $app->get('/contact', HomeAction::class);
     */
};
