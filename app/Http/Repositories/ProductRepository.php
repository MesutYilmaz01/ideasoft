<?php

namespace App\Http\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function getAll() {
        return Product::all();
    }

    public function getById(int $id) {
        return Product::where('id', $id)->first();
    }

    public function store(array $parameters) {
        return Product::create($parameters);
    }

    public function update(int $id, array $parameters) {
        return $this->getById($id)->update($parameters);
    }

    public function delete(int $id) {
        return $this->getById($id)->delete();
    }
}