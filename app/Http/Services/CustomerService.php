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
        return $this->customerRepository->getAll($conditions);
    }

    public function add(array $parameters) {
        return $this->customerRepository->add($parameters);
    }

    public function update(int $id, array $parameters) {
        return $this->customerRepository->update($id, $parameters);
    }

    public function delete(int $id) {
        return $this->customerRepository->delete($id);
    }
}