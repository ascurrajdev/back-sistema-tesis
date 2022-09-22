<?php
namespace App\Http\Controllers\Api\Users;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductSaveRequest;
use App\Http\Requests\ProductUpdateRequest;

class ProductsController extends Controller{
    public function index(){
        return Product::paginate();
    }

    public function view(Product $product){
        return new ProductResource($product);
    }

    public function store(ProductSaveRequest $request){
        $params = $request->validated();
        $product = Product::create(array_filter([
            "name" => $params['name'],
            'amount' => $params['amount'],
            'amount_untaxed' => 0,
            'tax_id' => $params['tax_id'],
            'currency_id' => $params['currency_id'],
            'user_id' => $request->user()->id,
            'active_for_reservation' => $params['active_for_reservation'],
            'is_lodging' => $params['is_lodging'],
            'capacity_for_day_max' => $params['capacity_for_day_max'],
            'capacity_for_day_min' => $params['capacity_for_day_min'],
            'stockable' => $params['stockable']
        ]));
        return new ProductResource($product);
    }

    public function update(Product $product,ProductUpdateRequest $request){
        $params = $request->validated();
        $product->fill(array_filter($params));
        return new ProductResource($product);
    }

    public function delete(Product $product){
        $product->delete();
        return new ProductResource($product);
    }
}