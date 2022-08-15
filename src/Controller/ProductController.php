<?php

namespace App\Controller;

use App\Service\ProductService;
use Exception;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class ProductController extends AbstractController
{
    public function __construct(private readonly ProductService $productService, private readonly SerializerInterface $serializer, private readonly TagAwareCacheInterface $cache)
    {
    }


    /**
     * This method return the list of all product.
     *
     * @OA\Response(
     *     response=200,
     *     description="Return the list of all product",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Product::class, groups={"productList", "getProduct"}))
     *     )
     * )
     * @OA\Tag(name="Products")
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/api/products', name: 'products', methods: ['GET'])]
    public function getAllUser(): JsonResponse
    {
        $idCache = "getAllProducts";
        $productService = $this->productService;

        $jsonProducts = $this->cache->get($idCache, function (ItemInterface $item) use ($productService) {
            $item->tag("productsCache");
            echo("Pas en cache");
            $products = $productService->getAllProducts();
            $context = SerializationContext::create()->setGroups(["productList", "getProduct"]);
            return $this->serializer->serialize($products, 'json', $context);
        });

        return new JsonResponse($jsonProducts, Response::HTTP_OK, [], true);
    }


    /**
     *
     * This method return the detail of a product.
     *
     * @OA\Response(
     *     response=200,
     *     description="Return the detail of product",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Product::class, groups={"productDetails", "getProduct"}))
     *     )
     * )
     *
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="The identifiant of a product",
     *     @OA\Schema(type="int")
     * )
     * @OA\Tag(name="Products")
     *
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/api/products/{id}', name: 'detail_product', methods: ['GET'])]
    public function getDetailUser(int $id): JsonResponse
    {
        $idCache = "getProductDetails".$id;
        $productService = $this->productService;

        $jsonProduct = $this->cache->get($idCache, function (ItemInterface $item) use ($productService,$id) {
            $item->tag("productsCache");
            echo("Pas en cache");
            $product = $this->productService->getProductDetail($id);
            if (null === $product) {
                return new JsonResponse(null, Response::HTTP_NOT_FOUND);
            }
            $context = SerializationContext::create()->setGroups(["productDetails", "getProduct"]);
            return $this->serializer->serialize($product, 'json', $context);

        });

        //TODO create ExceptionSubscriber RuntimeException + celles qui en generent sauf JWT
        return new JsonResponse($jsonProduct, Response::HTTP_OK, [], true);
    }
}
