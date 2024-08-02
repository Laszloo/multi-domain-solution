<?php

declare(strict_types=1);

use App\Domain\Sites\ExampleCom\Application\Actions\HomeAction;
use App\Domain\Sites\ExampleCom\Application\Actions\BrandAction;
use Slim\App;

return function (App $app) {
    $app->get('/', HomeAction::class);
    $app->get('/brand', BrandAction::class);
};
