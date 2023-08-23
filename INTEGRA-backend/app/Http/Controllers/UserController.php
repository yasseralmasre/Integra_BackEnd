<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserManagement\RoleCollection;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserManagement\UserResource;
use App\Http\Resources\UserManagement\UserCollection;
use App\Models\HR\Department;
use App\Models\HR\Employee;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        return new UserCollection(User::all());
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'fullName'    => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'username'    => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'email'       => 'required | email:rfc',
            'password'    => 'required',
            'employee_id' => 'required | numeric',

        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        if (User::create ([

            'fullName'    => request('fullName') ,
            'username'    => request('username') ,
            'email'       => request('email') ,
            'password'    => Hash::make(request('password')) ,
            'employee_id' => request('employee_id') ,


        ]))

            return $this->success();
        else
            return $this->failure();
    }

    public function show($id) : UserResource
    {
        $user = User::find($id);

        if($user)
            return new UserResource($user);
        else
            return $this->failure();
    }

    public function update(Request $request,  $id)
    {

        $validator = Validator::make($request->all(), [
            'fullName'    => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'username'    => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'email'       => 'required | email:rfc',
            'password'    => 'required',
            'employee_id' => 'required | numeric',

        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        $user = User::findOrFail($id);

        $user->fullName    = request('fullName');
        $user->username    = request('username');
        $user->email       = request('email');
        $user->password    = Hash::make(request('password'));
        $user->employee_id = request('employee_id');

        if($user->isDirty(['fullName' , 'username' , 'email' , 'password' , 'employee_id' ])){
            $user->save();
            return $this->success();
        }
        else
            return $this->failure();

    }

    public function destroy($id)
    {
        if( $user = User::findOrFail($id)) {
            $user->delete();
            return $this->success();
        }
        else
            return $this->failure();
    }

    public function getMe()
    {
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        $employee = Employee::findOrFail($user->employee_id);

        $department = Department::findOrFail($employee->department_id)->name;

        $superVisor = $employee->employee->firstName . " " . $employee->employee->lastName;
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
        $firstName    = $employee->firstName;
        $lastName     = $employee->lastName;
        $dateOfBrith  = $employee->dateOfBrith;
        $gender       = $employee->gender;
        $address      = $employee->address;
        $email        = $employee->email;
        $phone        = $employee->phone;
        $dateOfHire   = $employee->dateOfHire;
        $salary       = $employee->salary;
        $status       = $employee->status;
        $certificates = $employee->employeeCertificates;
        $educations   = $employee->employeeEducations;
        $performances = $employee->employeePerformances;
        $vacations    = $employee->employeeVacations;

        $employeeDetails[] = compact('firstName','lastName', 'dateOfBrith',
        'gender', 'address', 'email', 'phone', 'dateOfHire', 'salary',
        'status', 'department', 'superVisor', 'certificates', 'educations',
        'performances', 'vacations');

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

    public function showUserRoles($id)
    {
        $user = User::findOrFail($id);
        $roles = $user->roles;
        return new RoleCollection($roles);
    }

}
