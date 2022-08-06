<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/api/products', name: 'products', methods: ['GET'])]
    public function getAllUser(): JsonResponse
    {
        return $this->json([
            'message' => 'Product list!',
            'path' => 'src/Controller/ProductController.php',
        ]);
    }

    #[Route('/api/products/{id}', name: 'detail_product', methods: ['GET'])]
    public function getDetailUser(int $id): JsonResponse
    {
        return $this->json([
            'message' => 'Product detail!',
            'path' => 'src/Controller/ProductController.php',
        ]);
    }
}
