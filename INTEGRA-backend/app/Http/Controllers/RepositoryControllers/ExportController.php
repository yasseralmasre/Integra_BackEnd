<?php

namespace App\Http\Controllers\RepositoryControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Repository\ExportCollection;
use App\Http\Resources\Repository\ExportResource;
use App\Models\HR\Employee;
use App\Models\Marketing\Customer;
use App\Models\Repository\Export;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class ExportController extends Controller
{
    public function index () : ExportCollection {
        return new ExportCollection(Export::all());
    }

    public function show($id) : ExportResource {
        $export = Export::findOrFail($id);
        $export->customer = Customer::findOrFail($export->customer_id)->name;
        $employee = Employee::findOrFail($export->employee_id);
        $export->employee = $employee->firstName ." " .$employee->lastName;

        if($export)
             return new exportResource($export);
        else
             return $this->failure();
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'          => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'date'          => 'required | date',
            'total_amount'  => 'required | numeric',
            'customer_id'   => 'required',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        $token = JWTAuth::getToken();
        $user  = JWTAuth::toUser($token);

       if( Export::create([
            'name'          => request('name'),
            'date'          => request('date'),
            'total_amount'  => request('total_amount'),
            'employee_id'   => $user->employee_id,
            'customer_id'   => request('customer_id'),
        ]))
            return $this->success();
        else
            return $this->failure();
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name'          => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'date'          => 'required | date',
            'total_amount'  => 'required | numeric',
            'customer_id'   => 'required',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        $export = Export::findOrFail($id);

        $export->name         = request('name');
        $export->date         = request('date');
        $export->total_amount = request('total_amount');
        $export->customer_id  = request('customer_id');

        if($export->isDirty(['name', 'date', 'total_amount', 'customer_id'])){
            $export->save();
            return $this->success();
        }
        else {
            return $this->failure();
        }
    }

    public function destroy($id) {
        if( $export = Export::findOrFail($id)){
            $export->delete();
            return $this->success();
        }
        else
            return $this->failure();
    }
}
