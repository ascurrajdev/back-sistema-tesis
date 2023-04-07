<?php
namespace App\Http\Controllers\Api\Users;
use App\Models\Product;
use App\Models\Currency;
use App\Http\Resources\ProductResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductSaveRequest;
use App\Http\Requests\ProductUpdateRequest;

class ProductsController extends Controller{
    public function index(){
        $this->authorize("viewAny",Product::class);
        return Product::paginate();
    }

    public function view(Product $product){
        $this->authorize("view",$product);
        return new ProductResource($product);
    }

    public function store(ProductSaveRequest $request){
        $params = $request->validated();
        $currency = Currency::firstWhere("default",true);
        $product = Product::create(array_filter([
            "name" => $params['name'],
            'amount' => $params['amount'],
            'amount_untaxed' => 0,
            'tax_id' => $params['tax_id'] ?? null,
            'currency_id' => $currency->id,
            'user_id' => $request->user()->id,
            'active_for_reservation' => $params['active_for_reservation'],
            'is_lodging' => $params['is_lodging'],
            'capacity_for_day_max' => $params['capacity_for_day_max'],
            'capacity_for_day_min' => $params['capacity_for_day_min'],
            'stockable' => $params['stockable'] ?? false,
        ]));
        return new ProductResource($product);
    }

    public function update(Product $product,ProductUpdateRequest $request){
        $params = $request->validated();
        $product->fill($params);
        $product->save();
        return new ProductResource($product);
    }

    public function delete(Product $product){
        $this->authorize('delete',$product);
        $product->delete();
        return new ProductResource($product);
    }
}