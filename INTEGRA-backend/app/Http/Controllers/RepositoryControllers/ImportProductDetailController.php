<?php

namespace App\Http\Controllers\RepositoryControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Repository\ImportProductDetailCollection;
use App\Models\Repository\Import;
use App\Models\Repository\ImportProductDetail;
use App\Models\Repository\Product;
use App\Models\Repository\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImportProductDetailController extends Controller
{
    public function index () : ImportProductDetailCollection{
        return new ImportProductDetailCollection(ImportProductDetail::all());
    }

    public function store (Request $request) {
        $validator = Validator::make($request->all(), [
            'import_id'          => 'required | numeric',
            'product_details_id' => 'required | numeric',
            'quantity'           => 'required | numeric',
            'total_amount'       => 'required | numeric',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        $product_detail = ProductDetail::find(request('product_details_id'));
        $product_detail->stock = $product_detail->stock + request('quantity');
        $product_detail->save();

        $product = Product::find($product_detail->product_id);
        $product->quantity_in_stock = $product->quantity_in_stock + request('quantity');
        $product->save();

        ImportProductDetail::Create([
            'import_id'          => request('import_id'),
            'product_details_id' => request('product_details_id'),
            'quantity'           => request('quantity'),
            'total_amount'       => request('total_amount'),
        ]);

        return $this->success();
    }

    public function update (Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'import_id'          => 'required | numeric',
            'product_details_id' => 'required | numeric',
            'quantity'           => 'required | numeric',
            'total_amount'       => 'required | numeric',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }
        $import = ImportProductDetail::findOrFail($id);

        $stock = $import->stock;

        $product_detail = ProductDetail::find(request('product_details_id'));
        $product_detail->stock = $product_detail->stock + request('quantity') - $stock ;
        $product_detail->save();

        $product = Product::find($product_detail->product_id);
        $product->quantity_in_stock = $product->quantity_in_stock + request('quantity') - $stock;
        $product->save();
        

        $import->import_id          = request('import_id');
        $import->product_details_id = request('product_details_id');
        $import->quantity           = request('quantity');
        $import->total_amount       = request('total_amount');

        if($import->isDirty(['import_id', 'product_details_id', 'quantity', 'total_amount'])){
            $import->save();
            return $this->success();
        }
        else 
            return $this->failure();

    }

    public function destroy ($id) {
        $import_product = ImportProductDetail::findOrFail($id);

        $product_detail = ProductDetail::find($import_product->product_details_id);
        $product_detail->stock = $product_detail->stock - $import_product->quantity;
        $product_detail->save();

        $product = Product::find($product_detail->product_id);
        $product->quantity_in_stock = $product->quantity_in_stock - $import_product->quantity;
        $product->save();

        $import_product->delete();

        return $this->success();
    }

    public function productsByImportId($id) {
        $import_product = ImportProductDetail::query();
        $import_product = $import_product->where('import_id', $id);
        $import_product = $import_product->join('product_details', 'product_details.id', '=', 'import_product.product_details_id')
            ->join('products', 'products.id', '=', 'product_details.product_id')
            ->select('import_product.*', 'products.name', 'products.price', 'product_details.details')
            ->get();

        return new ImportProductDetailCollection($import_product);
    }
}
