<?php

namespace App\Http\Controllers;

use App\Http\Contracts\ICustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private ICustomerService $customerService;

    public function __construct(ICustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function getAll(Request $request){
        $customers = $this->customerService->getAll();
        dd($customers);
    }
}
