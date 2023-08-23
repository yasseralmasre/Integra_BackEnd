<?php

namespace App\Http\Controllers\RepositoryControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Repository\ExportProductDetailCollection;
use App\Models\Repository\ExportProductDetail;
use App\Models\Repository\Product;
use App\Models\Repository\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExportProductDetailController extends Controller
{
    public function index () : ExportProductDetailCollection{
        return new ExportProductDetailCollection(ExportProductDetail::all());
    }

    public function store (Request $request) {
        $validator = Validator::make($request->all(), [
            'export_id'          => 'required | numeric',
            'product_details_id' => 'required | numeric',
            'quantity'           => 'required | numeric',
            'total_amount'       => 'required | numeric',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        $product_detail = ProductDetail::find(request('product_details_id'));
        if (request('quantity') > $product_detail->stock) {
            return response()->json(['message' => 'fuck you mother']);
        }

        $product_detail->stock = $product_detail->stock - request('quantity');
        $product_detail->save();

        $product = Product::find($product_detail->product_id);
        $product->quantity_in_stock = $product->quantity_in_stock - request('quantity');
        $product->save();

        ExportProductDetail::Create([
            'export_id'          => request('export_id'),
            'product_details_id' => request('product_details_id'),
            'quantity'           => request('quantity'),
            'total_amount'       => request('total_amount'),
        ]);

        return $this->success();
    }

    public function update (Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'export_id'          => 'required | numeric',
            'product_details_id' => 'required | numeric',
            'quantity'           => 'required | numeric',
            'total_amount'       => 'required | numeric',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        $export = ExportProductDetail::findOrFail($id);


        $product_detail = ProductDetail::find(request('product_details_id'));
        if (request('quantity') > ($product_detail->stock + $export->stock)) {
            return response()->json(['message' => 'fuck you mother']);
        }

        $stock = $export->stock;

        $product_detail->stock = $product_detail->stock - request('quantity') + $stock;
        $product_detail->save();

        $product = Product::find($product_detail->product_id);
        $product->quantity_in_stock = $product->quantity_in_stock - request('quantity') + $stock;
        $product->save();

        $export->export_id          = request('export_id');
        $export->product_details_id = request('product_details_id');
        $export->quantity           = request('quantity');
        $export->total_amount       = request('total_amount');

        if($export->isDirty(['export_id', 'product_details_id', 'quantity', 'total_amount'])){
            $export->save();
            return $this->success();
        }
        else
            return $this->failure();

    }

    public function destroy ($id) {
        $export_product = ExportProductDetail::findOrFail($id);

        $product_detail = ProductDetail::find($export_product->product_details_id);
        $product_detail->stock = $product_detail->stock + $export_product->quantity;
        $product_detail->save();

        $product = Product::find($product_detail->product_id);
        $product->quantity_in_stock = $product->quantity_in_stock + $export_product->quantity;
        $product->save();

        $export_product->delete();

        return $this->success();
    }

    public function productsByExportId($id) {
        $export_product = ExportProductDetail::query();
        $export_product = $export_product->where('export_id', $id);
        $export_product = $export_product->join('product_details', 'product_details.id', '=', 'export_product.product_details_id')
            ->join('products', 'products.id', '=', 'product_details.product_id')
            ->select('export_product.*', 'products.name', 'products.price', 'product_details.details')
            ->get();

        return new ExportProductDetailCollection($export_product);
    }
}
