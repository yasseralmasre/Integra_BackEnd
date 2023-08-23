<?php

namespace App\Http\Controllers\MarketingControllers;

use App\Models\marketing\SocialMedia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Marketing\SocialMediaResource;
use App\Http\Resources\Marketing\SocialMediaCollection;
use Illuminate\Support\Facades\Validator;


class SocialMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : SocialMediaCollection
    {
        return new SocialMediaCollection(SocialMedia::all());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'blogger'          => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'type'             => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'way'              => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'cost'             => 'required | numeric',
            'expected_revenue' => 'required | numeric',
            'campaign_id'      => 'required | numeric',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        if (SocialMedia::create ([

            'blogger'          => request('blogger') ,
            'type'             => request('type') ,
            'way'              => request('way') ,
            'cost'             => request('cost') ,
            'expected_revenue' => request('expected_revenue') ,
            'campaign_id'      => request('campaign_id')
        ]))
            return $this->success();
        else
            return $this->failure();
    }

    public function show($id)
    {
        $socialmedia = SocialMedia::find($id);

        if($socialmedia)
            return new SocialMediaResource($socialmedia);
        else
            return $this->failure();
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'blogger'          => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'type'             => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'way'              => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'cost'             => 'required | numeric',
            'actual_revenue'   => 'numeric',
            'expected_revenue' => 'required | numeric',
            'campaign_id'      => 'required | numeric',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        $socialmedia = SocialMedia::findOrFail($id);

        $socialmedia->blogger           = request('blogger');
        $socialmedia->type              = request('type');
        $socialmedia->way               = request('way');
        $socialmedia->cost              = request('cost');
        $socialmedia->actual_revenue    = request('actual_revenue');
        $socialmedia->expected_revenue  = request('expected_revenue');
        $socialmedia->campaign_id       = request('campaign_id');


        if($socialmedia->isDirty(['blogger' , 'type' , 'way', 'cost' , 'expected_revenue' , 'actual_revenue', 'campaign_id' ])){
            $socialmedia->save();
            return $this->success();
        }
        else
            return $this->failure();

    }


    public function destroy($id)
    {
        if( $socialmedia = SocialMedia::findOrFail($id)) {
            $socialmedia->delete();
            return $this->success();
        }
        else
            return $this->failure();
    }
}
