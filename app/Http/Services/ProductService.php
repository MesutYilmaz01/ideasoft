<?php

namespace App\Http\Services;

use App\Http\Contracts\IProductService;
use App\Http\Repositories\ProductRepository;

class ProductService implements IProductService
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
}