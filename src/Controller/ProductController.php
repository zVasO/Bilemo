<?php

namespace App\Controller;

use App\Service\ProductService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class ProductController extends AbstractController
{


    public function __construct(private readonly ProductService $productService, private readonly SerializerInterface $serializer)
    {
    }


    /**
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/api/products', name: 'products', methods: ['GET'])]
    public function getAllUser(): JsonResponse
    {
        try {
            $products = $this->productService->getAllProducts();
            $jsonProducts = $this->serializer->serialize($products, 'json', ["groups" => "productList"]);
            return new JsonResponse($jsonProducts, Response::HTTP_OK, [], true);
        } catch (Exception $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode(), []);
        }
    }

    #[Route('/api/products/{id}', name: 'detail_product', methods: ['GET'])]
    public function getDetailUser(int $id): JsonResponse
    {
        try {
            $user = $this->getUser();
            $product = $this->productService->getProductDetail($id);
            $jsonProduct = $this->serializer->serialize($product, 'json', ["groups" => "productDetails"]);
            return new JsonResponse($jsonProduct, Response::HTTP_OK, [], true);
        } catch (Exception $exception) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }
    }
}
