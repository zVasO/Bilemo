<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class ProductService
{

    public function __construct(private readonly ProductRepository $productRepository)
    {
    }

    /**
     * @return Product[]
     * @throws Exception
     */
    public function getAllProducts(): array
    {
        $productList = $this->productRepository->findAll();
        if (empty($productList)) {
            throw new Exception("No content", Response::HTTP_NO_CONTENT);
        }
        return $productList;
    }

    /**
     * @param int $id
     * @return Product
     * @throws Exception
     */
    public function getProductDetail(int $id): Product
    {
        $product = $this->productRepository->find($id);
        if ($product === null) {
            throw new Exception("No content", Response::HTTP_NO_CONTENT);
        }
        return $product;
    }
}
