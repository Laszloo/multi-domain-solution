<?php

declare(strict_types=1);

namespace App\Domain\Sites\TestShopOrg\Application\Actions;

use App\Application\Actions\AbstractAction;
use App\Domain\Sites\TestShopOrg\Application\Contract\BrandServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;

class BrandAction extends AbstractAction
{
    public function __construct(
        private readonly BrandServiceInterface $brandService
    ) {
    }

    public function action(): ResponseInterface
    {
        $response = new Response();

        return $this->view->render($response, '/pages/brand.html.twig', [
            'brandData' => $this->brandService->getDummyExample(),
        ]);
    }
}
