<?php

namespace App\Http\Controllers\MarketingControllers;

use App\Models\Marketing\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Marketing\EventResource;
use App\Http\Resources\Marketing\EventCollection;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{

    public function index()
    {
        return new EventCollection(Event::all());
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'             => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'place'            => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'description'      => 'required | regex:/^[^\'"]+$/',
            'type'             => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'cost'             => 'required | numeric',
            'expected_revenue' => 'required | numeric',
            'campaign_id'      => 'required | numeric',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        if (Event::create ([

            'name'             => request('name') ,
            'place'            => request('place') ,
            'description'      => request('description') ,
            'type'             => request('type') ,
            'cost'             => request('cost') ,
            'expected_revenue' => request('expected_revenue') ,
            'campaign_id'      => request('campaign_id') ,

        ]))

            return $this->success();
        else
            return $this->failure();
    }

    public function show($id) : EventResource
    {
        $event = Event::find($id);

        if($event)
            return new EventResource($event);
        else
            return $this->failure();
    }

    public function update(Request $request,  $id)
    {

        $validator = Validator::make($request->all(), [
            'name'             => 'required | regex:/^[A-Za-z\s]+$/',
            'place'            => 'required | regex:/^[^\'"]+$/',
            'description'      => 'required | regex:/^[A-Za-z\s]+$/',
            'type'             => 'required | regex:/^[A-Za-z\s]+$/',
            'cost'             => 'required | numeric',
            'actual_revenue'   => 'numeric',
            'expected_revenue' => 'required | numeric',
            'campaign_id'      => 'required | numeric',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        $event = Event::findOrFail($id);

        $event->name                  = request('name');
        $event->place                 = request('place');
        $event->description           = request('description');
        $event->type                  = request('type');
        $event->cost                  = request('cost');
        $event->actual_revenue        = request('actual_revenue');
        $event->expected_revenue      = request('expected_revenue');
        $event->campaign_id           = request('campaign_id');

        if($event->isDirty(['name' , 'place' , 'description' , 'type' , 'cost' , 'actual_revenue','expected_revenue' , 'campaign_id' ])){
            $event->save();
            return $this->success();
        }
        else
            return $this->failure();

    }

    public function destroy($id)
    {
        if( $event = Event::findOrFail($id)) {
            $event->delete();
            return $this->success();
        }
        else
            return $this->failure();
    }
}
