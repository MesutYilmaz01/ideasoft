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

    public function getAll() {
        return $this->productRepository->getAll();
    }

    public function getById(int $id) {
        return $this->productRepository->getById($id);
    }

    public function store(array $parameters) {
        return $this->productRepository->store($parameters);
    }

    public function update(int $id, array $parameters) {
        return $this->productRepository->update($id, $parameters);
    }

    public function delete(int $id) {
        return $this->productRepository->delete($id);
    }
}