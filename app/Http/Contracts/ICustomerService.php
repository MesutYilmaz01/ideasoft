<?php

namespace App\Http\Contracts;

interface ICustomerService
{
    public function getAll();

    public function getByCondition(array $conditions);

    public function store(array $parameters);

    public function update(int $id, array $parameters);

    public function delete(int $id);
}