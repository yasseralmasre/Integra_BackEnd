<?php

namespace App\Http\Controllers\HRControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\HR\EmployeeEducationCollection;
use App\Http\Resources\HR\EmployeeEducationResource;
use App\Models\HR\EmployeeEducation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeEducationController extends Controller
{
    public function index() : EmployeeEducationCollection
    {
        return new EmployeeEducationCollection(EmployeeEducation::all());
    }

    public function show($id) : EmployeeEducationResource
    {
        $employeeEducation = EmployeeEducation::find($id);
        if($employeeEducation)
             return new EmployeeEducationResource($employeeEducation);
        else 
             return $this->failure();
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'employee_id'    => 'required | numeric',
            'specialization' => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'degree'         => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'grantingBy'     => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'graduationDate' => 'required | date',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        if(EmployeeEducation::create([
            'employee_id'    => request('employee_id'),
            'specialization' => request('specialization'),
            'degree'         => request('degree'),
            'grantingBy'     => request('grantingBy'),
            'graduationDate' => request('graduationDate'),
        ]))
            return $this->success();
        else
            return $this->failure();

    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'employee_id'    => 'required | numeric',
            'specialization' => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'degree'         => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'grantingBy'     => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'graduationDate' => 'required | date',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        $employeeEducation = EmployeeEducation::findOrFail($id);
        
        $employeeEducation->employee_id    = request('employee_id');
        $employeeEducation->specialization = request('specialization');
        $employeeEducation->degree         = request('degree');
        $employeeEducation->grantingBy     = request('grantingBy');
        $employeeEducation->graduationDate = request('graduationDate');

        if($employeeEducation->isDirty(['employee_id' , 'specialization' ,  'degree',  'grantingBy',  'graduationDate'])){
            $employeeEducation->save();
            return $this->success();
        }
        else 
            return $this->failure();
    }

    public function destroy($id)
    {
        if( $employeeEducation = EmployeeEducation::findOrFail($id)){
            $employeeEducation->delete();
            return $this->success();
        } 
        else
            return $this->failure();
    }
}
