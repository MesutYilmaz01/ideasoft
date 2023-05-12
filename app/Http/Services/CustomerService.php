<?php

namespace App\Http\Services;

use App\Http\Contracts\ICustomerService;
use App\Http\Repositories\CustomerRepository;

class CustomerService implements ICustomerService
{

    private CustomerRepository $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getAll() {
        return $this->customerRepository->getAll();
    }

    public function getByCondition(array $conditions) {
        return $this->customerRepository->getByCondition($conditions);
    }

    public function store(array $parameters) {
        return $this->customerRepository->store($parameters);
    }

    public function update(int $id, array $parameters) {
        return $this->customerRepository->update($id, $parameters);
    }

    public function delete(int $id) {
        return $this->customerRepository->delete($id);
    }
}