<?php

namespace App\Http\Controllers\HRControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\HR\EmployeeCollection;
use App\Http\Resources\HR\DepartmentCollection;
use App\Http\Resources\HR\DepartmentResource;
use App\Models\HR\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    public function index() : DepartmentCollection
    {
        return new DepartmentCollection(Department::all());
    }

    public function show($id) : DepartmentResource
    {
        $department = Department::find($id);
        if($department)
             return new DepartmentResource($department);
        else 
             return $this->failure();
    }

    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required | regex:/^[a-zA-Z0-9\s]+$/',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        if(Department::create(request()->all()))
            return $this->success();
        else
            return $this->failure();    
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required | regex:/^[a-zA-Z0-9\s]+$/',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        $department = Department::findOrFail($id);

        $department->name = request('name');

        if($department->isDirty(['name'])){
            $department->save();
            return $this->success();
        }
        else 
            return $this->failure();
    }

    public function destroy($id)
    {
        if( $department = Department::findOrFail($id)){
            $department->delete();
            return $this->success();
        } 
        else
            return $this->failure();
    }

    public function showDepartmentEmployees($id) 
    {
        $department = Department::findOrFail($id);
        return new EmployeeCollection($department->employees);
    }

}
