<?php

namespace App\Http\Controllers\MarketingControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Marketing\Customer;
use App\Http\Resources\Marketing\CustomerResource;
use App\Http\Resources\Marketing\CustomerCollection;
use App\Http\Resources\Marketing\LeadCollection;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{

    public function index() : CustomerCollection{
        return new CustomerCollection(Customer::all());
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name'    => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'gender'  => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'age'     => 'required | numeric | max:99',
            'address' => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'email'   => 'required | email:rfc',
            'phone'   => 'required | numeric | max:9999999999 ',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        if(Customer::create ([

            'name'    => request('name') ,
            'gender'  => request('gender') ,
            'age'     => request('age') ,
            'address' => request('address') ,
            'email'   => request('email') ,
            'phone'   => request('phone') ,
        ]))

            return $this->success();
        else
            return $this->failure();
    }

    public function show($id) : CustomerResource{
        $customer = Customer::find($id);

        if($customer)
            return new CustomerResource($customer);
        else
            return $this->failure();
    }

    public function update(Request $request , $id){

        $validator = Validator::make($request->all(), [
            'name'    => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'gender'  => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'age'     => 'required | numeric | max:99',
            'address' => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'email'   => 'required | email:rfc',
            'phone'   => 'required | numeric | max:99999999999999 ',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        $customer = Customer::findOrFail($id);

        $customer->name    = request('name');
        $customer->gender  = request('gender');
        $customer->age     = request('age');
        $customer->address = request('address');
        $customer->email   = request('email');
        $customer->phone   = request('phone');


        if($customer->isDirty(['name' , 'gender' , 'age', 'address' , 'email' , 'phone'])){
            $customer->save();
            return $this->success();
        }
        else
            return $this->failure();

    }

    public function destroy($id){
        if( $customer = Customer::findOrFail($id)) {
            $customer->delete();
            return $this->success();
        }
        else
            return $this->failure();
    }

    public function showCustomerLeads($id) {
        $customer = Customer::findOrFail($id);
        return new LeadCollection($customer->leads);
    }
}
