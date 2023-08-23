<?php

namespace App\Http\Controllers\RepositoryControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Repository\ProductDetailCollection;
use App\Http\Resources\Repository\ProductDetailResource;
use App\Models\Repository\Product;
use App\Models\Repository\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ProductDetailController extends Controller
{
    public function index() : ProductDetailCollection {
        $productDetail = ProductDetail::query();
        $productDetail = $productDetail->join('products', 'products.id', '=', 'product_details.product_id')
            ->select('product_details.*', 'products.name', 'products.price')
            ->get();

        return new ProductDetailCollection($productDetail);
    }

    public function show($id) : ProductDetailResource {
        return new ProductDetailResource(ProductDetail::findOrFail($id));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'details'    => 'required',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        try {
        $details = request('details');
        foreach($details as $detail){
            $product_id = $detail["productId"];
            $stock = $detail["stock"];
            $group_id = $detail["groupId"];
            unset($detail["productId"]);
            unset($detail["groupId"]);
            unset($detail["stock"]);
            ProductDetail::create([
                'stock'                => $stock,
                'product_id'           => $product_id,
                'attribute_group_id'   => $group_id,
                'details'              => $detail,
            ]);
        }
        return $this->success();
        } catch (Throwable $e) {
            return $this->failure();
        }
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'details'    => 'required',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        $newStock = request('details')['group1']['stock'];

        $productDetail = ProductDetail::findOrFail($id);
        $stocks = $newStock - $productDetail->stock;
        $productStock = Product::findOrFail($productDetail->product_id);

        $productDetails = $productStock->details;
        foreach($productDetails as $detail) {
            $stocks += $detail->stock;
        }

        if($stocks > $productStock->quantity_in_stock) {
            return response()->json(['message' => 'The process has failed as the stock quantity specified in the details exceeds the available stock of the product.']);
        }

        $details = request('details')['group1'];
        $productDetail->stock = $details["stock"];
        unset($details["stock"]);
        $productDetail->details = $details;

        if($productDetail->isDirty(['stock', 'details'])){
            $productDetail->save();
            return $this->success();
        }
        else {
            return $this->failure();
        }
    }

    public function destroy($id) {
        if($detail = ProductDetail::findOrFail($id)){
            $detail->delete();
            return $this->success();
        }
        else
            return $this->failure();
    }
}
