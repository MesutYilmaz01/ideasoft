<?php

namespace App\Http\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function getAll() {
        return Product::all();
    }

    public function getByCondition(array $conditions) {
        return Product::where($conditions)->first();
    }

    public function store(array $parameters) {
        return Product::create($parameters);
    }

    public function update(int $id, array $parameters) {
        return $this->getByCondition(['id' => $id])->update($parameters);
    }

    public function delete(int $id) {
        return $this->getByCondition(['id' => $id])->delete();
    }
}