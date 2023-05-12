<?php

namespace App\Http\Controllers;

use App\Http\Contracts\ICustomerService;
use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Http\Resources\CustomerResource;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private ICustomerService $customerService;

    public function __construct(ICustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function getAll(){
        return CustomerResource::collection($this->customerService->getAll());
    }

    public function get(int $id){
        $customer = $this->customerService->getByCondition(['id' => $id]);
        if(!$customer) {
            return response('Bu id ile kayıt bulunamadı...',400);
        }
        return new CustomerResource($customer);
    }

    public function store(CustomerStoreRequest $request)
    {
        $customer = $this->customerService->store($request->all());
        if(!$customer) {
            return response('Ekleme işlemi başarısız...',400);
        }
        return new CustomerResource($customer);
    }

    public function update(int $id, CustomerUpdateRequest $request)
    {
        $isExists = $this->customerService->getByCondition(['id' => $id]);
        
        if(!$isExists) {
            return response('Bu id ile kayıt bulunamadı...',400);
        }

        $isUpdated = $this->customerService->update($id, $request->all());
        if(!$isUpdated) {
            return response('Güncelleme işlemi başarısız...',400);
        }
        return response('Güncelleme başarılı',200);
    }

    public function delete(int $id)
    {
        $isDeleted = $this->customerService->delete($id);
        if(!$isDeleted) {
            return response('Silme işlemi başarısız...',400);
        }
        return response('Silme başarılı',200);
    }
}
