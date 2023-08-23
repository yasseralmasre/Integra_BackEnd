<?php

namespace App\Http\Controllers\RepositoryControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Repository\SupplierCollection;
use App\Http\Resources\Repository\SupplierResource;
use App\Models\Repository\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index () : SupplierCollection {
        return new SupplierCollection(Supplier::all());
    }

    public function show ($id) : SupplierResource {
        $supplier = Supplier::find($id);
        if($supplier)
             return new SupplierResource($supplier);
        else 
             return $this->failure();
    }

    public function store (Request $request) {
        $validator = Validator::make($request->all(), [
            'name'         => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'address'      => 'required | regex:/^[^\'"]+$/',
            'email'        => 'required | email:rfc',
            'phone_number' => 'required | numeric',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        if(Supplier::create([
            'name'         => request('name'),
            'address'      => request('address'),
            'email'        => request('email'),
            'phone_number' => request('phone_number'),
        ]))
            return $this->success();
        else    
            return $this->failure();
    }

    public function update (Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name'         => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'address'      => 'required | regex:/^[a-zA-Z0-9:-]+$/ ',
            'email'        => 'required | email:rfc',
            'phone_number' => 'required | numeric',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        $supplier = Supplier::findOrFail($id);

        $supplier->name         = request('name');
        $supplier->address      = request('address');
        $supplier->email        = request('email');
        $supplier->phone_number = request('phone_number');

        if($supplier->isDirty(['name', 'address', 'email', 'phone_number'])){
            $supplier->save();
            return $this->success();
        }
        else {
            return $this->failure();
        }
    }

    public function destroy ($id) {
        if( $supplier = Supplier::findOrFail($id)){
            $supplier->delete();
            return $this->success();
        } 
        else
            return $this->failure();
    }

    public function getProductsBySupplier($id) {
        $supplier = Supplier::findOrFail($id);
        return new SupplierResource($supplier->products);
    }
}
