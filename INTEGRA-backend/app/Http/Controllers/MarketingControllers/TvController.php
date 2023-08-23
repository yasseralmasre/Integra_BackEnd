<?php

namespace App\Http\Controllers\MarketingControllers;

use App\Models\marketing\Tv;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Marketing\TvResource;
use App\Http\Resources\Marketing\TvCollection;
use Illuminate\Support\Facades\Validator;

class TvController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : TvCollection
    {
        return new TvCollection(Tv::all());
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'channel'            => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'time'               => 'required',
            'cost'               => 'required | numeric',
            'advertising_period' => 'required | numeric',
            'campaign_id'        => 'required | numeric',
            'actual_revenue'     => 'numeric',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        if (Tv::create ([

            'channel'            => request('channel') ,
            'time'               => request('time') ,
            'cost'               => request('cost') ,
            'advertising_period' => request('advertising_period') ,
            'expected_revenue'   => request('expected_revenue') ,
            'campaign_id'        => request('campaign_id')
        ]))

            return $this->success();
        else
            return $this->failure();

    }

    public function show($id)
    {
        $tv = Tv::find($id);
        if($tv)
            return new TvResource($tv);
        else
            return $this->failure();
    }

    public function update(Request $request,  $id)
    {

        $validator = Validator::make($request->all(), [
            'channel'            => 'required | regex:/^[a-zA-Z0-9\s]+$/',
            'time'               => 'required',
            'cost'               => 'required | numeric',
            'advertising_period' => 'required | numeric',
            'actual_revenue'     => 'numeric',
            'expected_revenue'   => 'required | numeric',
            'campaign_id'        => 'required | numeric',

        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        $tv = Tv::findOrFail($id);

        $tv->channel            = request('channel');
        $tv->time               = request('time');
        $tv->cost               = request('cost');
        $tv->advertising_period = request('advertising_period');
        $tv->actual_revenue     = request('actual_revenue');
        $tv->expected_revenue   = request('expected_revenue');
        $tv->campaign_id        = request('campaign_id');

        if($tv->isDirty(['channel' , 'time' , 'cost', 'advertising_period' , 'expected_revenue' ,  'actual_revenue', 'campaign_id' ])){
            $tv->save();
            return $this->success();
        }
        else
            return $this->failure();

    }

    public function destroy($id)
    {
        if( $tv = Tv::findOrFail($id)) {
            $tv->delete();
            return $this->success();
        }
        else
            return $this->failure();
    }
}
