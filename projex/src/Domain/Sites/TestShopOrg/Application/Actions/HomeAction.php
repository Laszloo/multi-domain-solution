<?php

declare(strict_types=1);

namespace App\Domain\Sites\TestShopOrg\Application\Actions;

use App\Application\Actions\AbstractAction;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;

class HomeAction extends AbstractAction
{
    public function action(): ResponseInterface
    {
        $response = new Response();

        return $this->view->render($response, '/pages/home.html.twig', [
            'message' => 'Welcome home!',
        ]);
    }
}
