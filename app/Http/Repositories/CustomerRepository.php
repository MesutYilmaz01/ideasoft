<?php

namespace App\Http\Repositories;

use App\Models\Customer;

class CustomerRepository
{
    public function getAll() {
        return Customer::all();
    }

    public function getById(int $id) {
        return Customer::where('id', $id)->first();
    }

    public function store(array $parameters) {
        return Customer::create($parameters);
    }

    public function update(int $id, array $parameters) {
        return $this->getById($id)->update($parameters);
    }

    public function delete(int $id) {
        return $this->getById($id)->delete();
    }
}