<?php

namespace App\Controller;

use App\Service\ProductService;
use Exception;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
            $context = SerializationContext::create()->setGroups(["productList", "getProduct"]);
            $jsonProducts = $this->serializer->serialize($products, 'json', $context);
            return new JsonResponse($jsonProducts, Response::HTTP_OK, [], true);
        } catch (Exception $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode(), []);
        }
    }

    #[Route('/api/products/{id}', name: 'detail_product', methods: ['GET'])]
    public function getDetailUser(int $id): JsonResponse
    {
        try {
            $product = $this->productService->getProductDetail($id);
            $context = SerializationContext::create()->setGroups(["productDetails", "getProduct"]);
            $jsonProduct = $this->serializer->serialize($product, 'json', $context);
            return new JsonResponse($jsonProduct, Response::HTTP_OK, [], true);
        } catch (Exception $exception) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }
    }
}
