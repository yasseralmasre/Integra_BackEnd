<?php

namespace App\Http\Controllers\HRControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\HR\EmployeeAttendenceCollection;
use App\Http\Resources\HR\EmployeeCertifecateCollection;
use App\Http\Resources\HR\EmployeeEducationCollection;
use App\Http\Resources\HR\EmployeePerformanceCollection;
use App\Http\Resources\HR\EmployeeVacationCollection;
use App\Http\Resources\HR\EmployeeCollection;
use App\Http\Resources\HR\EmployeeResource;
use App\Models\HR\Benefit;
use App\Models\HR\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index() : EmployeeCollection
    {
        return new EmployeeCollection(Employee::all());
    }

    public function show($id) : EmployeeResource
    {
        $employee = Employee::find($id);
        if($employee)
             return new EmployeeResource($employee);
        else 
             return $this->failure();
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'firstName'    => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'lastName'     => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'dateOfBrith'  => 'required | date',
            'gender'       => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'address'      => 'required | regex:/^[^\'"]+$/',
            'email'        => 'required | email',
            'phone'        => 'required | numeric',
            'dateOfHire'   => 'required | date',
            'salary'       => 'required | numeric',
            'supervisorId' => 'required | numeric',
            'status'       => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'departmentId' => 'required | numeric',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        Employee::create([
            'firstName'     => request('firstName'),
            'lastName'      => request('lastName'),
            'dateOfBrith'   => request('dateOfBrith'),
            'gender'        => request('gender'),
            'address'       => request('address'),
            'email'         => request('email'),
            'phone'         => request('phone'),
            'dateOfHire'    => request('dateOfHire'),
            'salary'        => request('salary'),
            'supervisorId'  => request('supervisorId'),
            'status'        => request('status'),
            'department_id'  => request('departmentId'),
        ]);

        return response()->json(["message" => "The process has been succeded"]);
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'firstName'    => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'lastName'     => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'dateOfBrith'  => 'required | date',
            'gender'       => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'address'      => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'email'        => 'required | email',
            'phone'        => 'required | numeric',
            'dateOfHire'   => 'required | date',
            'salary'       => 'required | numeric',
            'supervisorId' => 'required | numeric',
            'status'       => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'departmentId' => 'required | numeric',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        $employee = Employee::findOrFail($id);
        
        $employee->firstName    = request('firstName');
        $employee->lastName     = request('lastName');
        $employee->dateOfBrith  = request('dateOfBrith');
        $employee->gender       = request('gender');
        $employee->address      = request('address');
        $employee->email        = request('email');
        $employee->phone        = request('phone');
        $employee->dateOfHire   = request('dateOfHire');
        $employee->salary       = request('salary');
        $employee->supervisorId = request('supervisorId');
        $employee->status       = request('status');
        $employee->department_id = request('departmentId');

        if($employee->isDirty(['firstName' , 'lastName' ,  'dateOfBrith',  'gender',  'address',  'email',  'phone',  'dateOfHire',  'salary',  'supervisorId',  'status',  'departmentId'])){
            $employee->save();
            return $this->success();
        }
        else 
            return $this->failure();
    }

    public function destroy($id)
    {
        if( $employee = Employee::findOrFail($id)){
            $employee->delete();
            return $this->success();
        } 
        else
            return $this->failure();
    }

    public function attachBenefitToEmployee($id)
    {
        $benefitId = request('benefitId');


        $currentDate = Carbon::now();
        $startOfIncomingMonth = $currentDate->copy()->startOfMonth()->addMonth();
        $dateAfterYear = $startOfIncomingMonth->copy()->addYear();

        $employee = Employee::findOrFail($id);
        $employee->benefits()->attach($benefitId, [
            'enrollmentDate'    => $currentDate->toDateString(),
            'coverageStartDate' =>  $startOfIncomingMonth->toDateString(),
            'coverageEndDate'   => $dateAfterYear->toDateString(),
         ]);

        return $this->success();
    }

    public function detachBenefitOfEmployee($id) {
        Employee::find($id)->benefits()->detach(request('benefitId'));
        return $this->success();
    }

    public function showEmployeeDetails($id)
    {
        $employee = Employee::findOrFail($id);
        $employeeDetails = [];
        $employeeBenefits = [];
       
        foreach($employee->benefits as $benefit){

            $benefitName       = $benefit->name;
            $benefitCost       = $benefit->cost;
            $enrollmentDate    = $benefit->pivot->enrollmentDate;
            $coverageStartDate = $benefit->pivot->coverageStartDate;
            $coverageEndDate   = $benefit->pivot->coverageEndDate;

            $employeeBenefit[] = compact( 'benefitName' , 'benefitCost' ,'enrollmentDate','coverageStartDate' , 'coverageEndDate');
    
        }
        $id           = $employee->id;
        $firstName    = $employee->firstName;
        $lastName     = $employee->lastName;
        $certificates = $employee->employeeCertificates;
        $educations   = $employee->employeeEducations;
        $performances = $employee->employeePerformances;
        $vacations    = $employee->employeeVacations;

        $employeeDetails[] = compact('id', 'firstName' , 'lastName' , 'certificates' , 'educations' , 'performances' ,'vacations' );
        
        foreach($employeeBenefits as $employeeBenefit)
        {
            $enrollmentDate    = $employeeBenefit['enrollmentDate'];
            $coverageStartDate = $employeeBenefit['coverageStartDate'];
            $coverageEndDate   = $employeeBenefit['coverageEndDate'];
            $benefitName       = $employeeBenefit['benefitName'];
            $benefitCost       = $employeeBenefit['benefitCost'];
            $employeeDetails[] = compact('benefitName' , 'benefitCost', 'enrollmentDate' ,'coverageStartDate' ,'coverageEndDate' );
        }
         
        return $employeeDetails;
    }
}
