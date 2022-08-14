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
     */
    public function getAllProducts(): array
    {
        return $this->productRepository->findAll();
    }

    /**
     * @param int $id
     * @return Product|null
     */
    public function getProductDetail(int $id): ?Product
    {
        return $this->productRepository->find($id);
    }
}
