<?php

namespace App\Http\Controllers;

use App\Http\Contracts\IProductService;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private IProductService $productService;

    public function __construct(IProductService $productService)
    {
        $this->productService = $productService;
    }

    public function getAll(){
        return ProductResource::collection($this->productService->getAll());
    }

    public function get(int $id){
        $product = $this->productService->getByCondition(['id' => $id]);
        if(!$product) {
            return response('Bu id ile kayıt bulunamadı...',400);
        }
        return new ProductResource($product);
    }

    public function store(ProductStoreRequest $request)
    {
        $product = $this->productService->store($request->all());
        if(!$product) {
            return response('Ekleme işlemi başarısız...',400);
        }
        return new ProductResource($product);
    }

    public function update(int $id, ProductUpdateRequest $request)
    {
        $isExists = $this->productService->getByCondition(['id' => $id]);
        
        if(!$isExists) {
            return response('Bu id ile kayıt bulunamadı...',400);
        }

        $isUpdated = $this->productService->update($id, $request->all());
        if(!$isUpdated) {
            return response('Güncelleme işlemi başarısız...',400);
        }
        return response('Güncelleme başarılı',200);
    }

    public function delete(int $id)
    {
        $product = $this->productService->getByCondition(['id' => $id]);
        if(!$product) {
            return response('Bu id ile kayıt bulunamadı...',400);
        }
        $isDeleted = $this->productService->delete($id);
        if(!$isDeleted) {
            return response('Silme işlemi başarısız...',400);
        }
        return response('Silme başarılı',200);
    }
}
