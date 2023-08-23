<?php

namespace App\Http\Controllers\HRControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\HR\EmployeePerformanceCollection;
use App\Http\Resources\HR\EmployeePerformanceResource;
use App\Models\HR\EmployeePerformance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeePerformanceController extends Controller
{
    public function index() : EmployeePerformanceCollection
    {
        return new EmployeePerformanceCollection(EmployeePerformance::all());
    }

    public function show($id)
    {
        $employeePerformance = EmployeePerformance::find($id);
        if($employeePerformance)
            return new EmployeePerformanceResource($employeePerformance);
        else 
            return $this->failure();
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'employee_id'       => 'required | numeric',
            'performanceRating' => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'comments'          => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'reviewDate'        => 'required | date',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        if(EmployeePerformance::create([
            'employee_id'       => request('employee_id'),
            'performanceRating' => request('performanceRating'),
            'comments'          => request('comments'),
            'reviewDate'        => request('reviewDate'),
        ]))
            return $this->success();
        else
            return $this->failure();    
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'employee_id'       => 'required | numeric',
            'performanceRating' => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'comments'          => 'required | regex:/^[^\'"]+$/',
            'reviewDate'        => 'required | date',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        $employeePerformance = EmployeePerformance::findOrFail($id);
        
        $employeePerformance->employee_id       = request('employee_id');
        $employeePerformance->performanceRating = request('performanceRating');
        $employeePerformance->comments          = request('comments');
        $employeePerformance->reviewDate        = request('reviewDate');

        if($employeePerformance->isDirty(['employee_id' , 'performanceRating' ,  'comments',  'reviewDate'])){
            $employeePerformance->save();
            return $this->success();
        }
        else 
            return $this->failure();
    }

    public function destroy($id)
    {
        if( $employeePerformance = EmployeePerformance::findOrFail($id)){
            $employeePerformance->delete();
            return $this->success();
        } 
        else
            return $this->failure();
    }
}
