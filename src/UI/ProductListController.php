<?php

declare(strict_types=1);

namespace App\UI;

use App\Application\Exception\ValidationException;
use App\Application\UseCase\Product\List\Command;
use App\Application\UseCase\Product\List\Handler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/products',
    name: 'product_list',
    methods: ['GET']
)]
final class ProductListController extends AbstractController
{
    public function __construct(
        private readonly Handler $handler
    ) {}

    public function __invoke(Request $request): Response
    {
        try {
            $command = new Command(
                $request->query->get('type'),
                $request->query->get('unit'),
                $request->query->get('name')
            );
            return $this->json(($this->handler)($command));
        } catch (ValidationException $e) {
            return $this->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
