<?php

namespace App\Http\Controllers\HRControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\HR\EmployeeCollection;
use App\Http\Resources\HR\BenefitCollection;
use App\Http\Resources\HR\BenefitResource;
use App\Models\HR\Benefit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BenefitController extends Controller
{

    public function index() : BenefitCollection
    {
        return new BenefitCollection(Benefit::all());
    }

    public function show($id) : BenefitResource
    {
        $benefit = Benefit::find($id);
        if($benefit)
             return new BenefitResource($benefit);
        else
             return $this->failure();
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'cost' => 'required | numeric',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

       if(Benefit::create([
            'name' => request('name'),
            'cost' => request('cost'),
        ]))
            return $this->success();
        else
            return $this->failure();
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'cost' => 'required | numeric',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        $benefit = Benefit::findOrFail($id);

        $benefit->name = request('name');
        $benefit->cost = request('cost');

        if($benefit->isDirty(['name' , 'cost'])){
            $benefit->save();
            return $this->success();
        }
        else
            return $this->failure();
    }

    public function destroy($id)
    {
        if( $benefit = Benefit::findOrFail($id)){
            $benefit->delete();
            return $this->success();
        }
        else
            return $this->failure();
    }

    public function showBenefitEmployees($id)
    {
        $benefit = Benefit::findOrFail($id);
        $data = [];
        foreach($benefit->employees as $employee){
        $id = $employee->id;
        $firstName = $employee->firstName;
        $lastName = $employee->lastName;
        $enrollmentDate = $employee->pivot->enrollmentDate;
        $coverageStartDate = $employee->pivot->coverageStartDate;
        $coverageEndDate = $employee->pivot->coverageEndDate;
            
        $data [] = compact('id', 'firstName' , 'lastName' , 'enrollmentDate' , 'coverageStartDate' , 'coverageEndDate');
        
        }
        return $data;
    }
}
