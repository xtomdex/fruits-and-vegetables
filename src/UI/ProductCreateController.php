<?php

declare(strict_types=1);

namespace App\UI;

use App\Application\Exception\ValidationException;
use App\Application\UseCase\Product\Create\Command;
use App\Application\UseCase\Product\Create\Handler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/products',
    name: 'product_create',
    methods: ['POST']
)]
final class ProductCreateController extends AbstractController
{
    public function __construct(
        private readonly Handler $handler
    ) {}

    public function __invoke(Request $request): Response
    {
        try {
            $command = new Command(
                (float) $request->request->get('quantity'),
                $request->request->get('name'),
                $request->request->get('type'),
                $request->request->get('unit'),
            );
            return $this->json(($this->handler)($command), Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return $this->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
