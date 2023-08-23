<?php

namespace App\Http\Controllers\HRControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\HR\EmployeeVacationCollection;
use App\Http\Resources\HR\EmployeeVacationResource;
use App\Models\HR\EmployeeVacation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeVacationController extends Controller
{
    public function index() : EmployeeVacationCollection
    {
        return new EmployeeVacationCollection(EmployeeVacation::all());
    }

    public function show($id) : EmployeeVacationResource
    {
        $employeeVacation = EmployeeVacation::find($id);
        if($employeeVacation)
            return new EmployeeVacationResource($employeeVacation);
        else 
            return $this->failure();
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'employee_id'      => 'required | numeric',
            'startDate'        => 'required | date',
            'endDate'          => 'required | date',
            'typeOfVacation'   => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'reasonOfVacation' => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'status'           => 'required | regex:/^[a-zA-Z0-9\s]+$/',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

       if( EmployeeVacation::create([
            'employee_id'      => request('employee_id'),
            'startDate'        => request('startDate'),
            'endDate'          => request('endDate'),
            'typeOfVacation'   => request('typeOfVacation'),
            'reasonOfVacation' => request('reasonOfVacation'),
            'status'           => request('status'),
        ]))
            return $this->success();
        else 
            return $this->failure();   
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'employee_id'      => 'required | numeric',
            'startDate'        => 'required | date',
            'endDate'          => 'required | date',
            'typeOfVacation'   => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'reasonOfVacation' => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'status'           => 'required | regex:/^[a-zA-Z0-9\s]+$/',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        $employeeVacation = EmployeeVacation::findOrFail($id);

        $employeeVacation->employee_id      = request('employee_id');
        $employeeVacation->startDate        = request('startDate');
        $employeeVacation->endDate          = request('endDate');
        $employeeVacation->typeOfVacation   = request('typeOfVacation');
        $employeeVacation->reasonOfVacation = request('reasonOfVacation');
        $employeeVacation->status           = request('status');

        if($employeeVacation->isDirty(['employee_id' , 'startDate' ,  'endDate',  'typeOfVacation',  'reasonOfVacation',  'status'])){
            $employeeVacation->save();
            return $this->success();
        }
        else 
            return $this->failure();
    }

    public function destroy($id)
    {
        if( $employeeVacation = EmployeeVacation::findOrFail($id)){
            $employeeVacation->delete();
            return $this->success();
        } 
        else
            return $this->failure();
    }
}
