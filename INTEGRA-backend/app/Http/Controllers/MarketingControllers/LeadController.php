<?php

namespace App\Http\Controllers\MarketingControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Marketing\Lead;
use App\Http\Resources\Marketing\LeadResource;
use App\Http\Resources\Marketing\CustomerCollection;
use App\Http\Resources\Marketing\CampaignCollection;
use App\Http\Resources\Marketing\LeadCollection;
use Illuminate\Support\Facades\Validator;


class LeadController extends Controller
{

    public function index() : LeadCollection
    {
        return new LeadCollection(Lead::all());
    }

    public function store(Request $request )
    {

        $validator = Validator::make($request->all(), [
            'type' => 'required | regex:/^[a-zA-Z0-9\s]+$/',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

            if($lead = Lead::create ([
                'type' => request('type') ,
            ]))

                return $this->success();
            else
                return $this->failure(); 


    }

    public function show(string $id) : LeadResource
    {
        $lead = Lead::find($id);

        if($lead)
            return new LeadResource($lead);
        else
            return $this->failure(); 
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'type' => 'required | regex:/^[a-zA-Z0-9\s]+$/',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        $lead = Lead::findOrFail($id);

        $lead->type = request('type');

        if($lead->isDirty(['type'])){
            $lead->save();
            return $this->success();
        }
        else 
            return $this->failure();
        

    }

    public function destroy(string $id)
    {
        if( $lead = Lead::findOrFail($id)) {
            $lead->delete();
            return $this->success();
        } 
        else
            return $this->failure();
    }

    public function attachLeadToCustomer($id) {

        $lead = Lead::find($id)->customers()->attach(request('customer_id'));

        if($lead)
            return $this->success();
        else
            return $this->failure();

    }
    //error

    public function detachLeadToCustomer($id) {

        $lead = Lead::find($id)->customers()->detach(request('customer_id'));

        if($lead)
            return $this->success();
        else
            return $this->failure();

    }

    public function showLeadCustomers($id) {
        $lead = Lead::findOrFail($id);
        return new CustomerCollection($lead->customers);
    }

    public function showLeadCampaigns($id) {
        $lead = Lead::findOrFail($id);
        return new CampaignCollection($lead->campaigns);
    }
}
