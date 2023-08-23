<?php

namespace App\Http\Controllers\RepositoryControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Repository\ImportCollection;
use App\Http\Resources\Repository\ImportProductDetailCollection;
use App\Http\Resources\Repository\ImportResource;
use App\Models\HR\Employee;
use App\Models\Repository\Import;
use App\Models\Repository\ImportProductDetail;
use App\Models\Repository\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class ImportController extends Controller
{
    public function index () : ImportCollection {
        return new ImportCollection(Import::all());
    }

    public function show($id) : ImportResource{
        $import = Import::find($id);
        $import->supplier = Supplier::findOrFail($import->supplier_id)->name;
        $employee = Employee::findOrFail($import->employee_id);
        $import->employee = $employee->firstName ." " .$employee->lastName;

        if($import)
             return new ImportResource($import);
        else 
             return $this->failure();
    } 

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'         => 'required | alpha:regex:/^[a-zA-Z0-9\s]+$/',
            'date'         => 'required | date',
            'total_amount' => 'required | numeric',
            'supplier_id'  => 'required | numeric',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        if(Import::create([
            'name'         => request('name'),
            'date'         => request('date'),
            'total_amount' => request('total_amount'),
            'supplier_id'  => request('supplier_id'),
            'employee_id'  => $user->employee_id,
        ]))
            return $this->success();
        else
            return $this->failure();
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name'         => 'required | alpha:regex:/^[a-zA-Z0-9\s]+$/',
            'date'         => 'required | date',
            'total_amount' => 'required',
            'supplier_id'  => 'required',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        $import = Import::findOrFail($id);

        $import->name         = request('name');
        $import->date         = request('date');
        $import->total_amount = request('total_amount');
        $import->supplier_id  = request('supplier_id');

        if($import->isDirty(['name', 'date', 'total_amount', 'supplier_id'])){
            $import->save();
            return $this->success();
        }
        else 
            return $this->failure();
    }

    public function destroy($id) {
        if($import = Import::findOrFail($id)){
            $import->delete();
            return $this->success();
        } 
        else
            return $this->failure();
    }
}