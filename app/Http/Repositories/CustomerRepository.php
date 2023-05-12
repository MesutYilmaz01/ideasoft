<?php

namespace App\Http\Repositories;

use App\Models\Customer;

class CustomerRepository
{
    public function getAll() {
        return Customer::all();
    }

    public function getByCondition(array $conditions) {
        return Customer::where($conditions)->first();
    }

    public function store(array $parameters) {
        return Customer::create($parameters);
    }

    public function update(int $id, array $parameters) {
        return $this->getByCondition(['id' => $id])->update($parameters);
    }

    public function delete(int $id) {
        return $this->getByCondition(['id' => $id])->delete();
    }
}