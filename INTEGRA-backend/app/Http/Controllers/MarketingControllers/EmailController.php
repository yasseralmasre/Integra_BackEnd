<?php

namespace App\Http\Controllers\MarketingControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Marketing\Email;
use App\Http\Resources\Marketing\EmailResource;
use App\Http\Resources\Marketing\EmailCollection;
use Illuminate\Support\Facades\Validator;



class EmailController extends Controller
{

    public function index() : EmailCollection
    {
        return new EmailCollection(Email::all());
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'content' => 'required | regex:/^[^\'"]+$/',
            'sender'  => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'reciver' => 'required | regex:/^[a-zA-Z0-9\s]+$/',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        if($email = Email::create ([
            'content' => request('content') ,
            'sender'  => request('sender') ,
            'reciver' => request('reciver') ,
        ]))
            return $this->success();
        else
            return $this->failure();
    }

    public function show($id) 
    {
        $email = Email::findOrFail($id);

        if($email)
            return new EmailResource($email);
        else
            return $this->failure();    
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'content' => 'required | regex:/^[^\'"]+$/',
            'sender'  => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'reciver' => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'expected_revenue' => 'required | numeric',
            'actual_revenue'   => 'required | numeric',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        $email = Email::findOrFail($id);

        $email->content = request('content');
        $email->sender = request('sender');
        $email->reciver = request('reciver');

        if($email->isDirty(['content' , 'sender' , 'reciver'])){
            $email->save();
            return $this->success();
        }
        else 
            return $this->failure();
        
    }

    public function destroy(string $id)
    {
        if( $email = Email::findOrFail($id)) {
            $email->delete();
            return $this->success();
        } 
        else
            return $this->failure();
    }
    //error

    public function attachEmailToLead($id) {

        $email = Email::find($id)->leads()->attach(request('lead_id'));

        if($email)
            return $this->success();
        else
            return $this->failure();    

    }

    public function detachEmailToLead($id) {

        $email = Email::find($id)->leads()->detach(request('lead_id'));

        if($email)
              return $this->success();
        else
             return $this->failure();    
    }


}
