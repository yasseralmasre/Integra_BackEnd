<?php

namespace App\Http\Controllers\RepositoryControllers\ProductAttributes;

use App\Http\Controllers\Controller;
use App\Http\Resources\Repository\ProductAttributes\AttributeCollection;
use App\Http\Resources\Repository\ProductAttributes\AttributeResource;
use App\Models\Repository\ProductAttributes\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttributeController extends Controller
{
    public function index() : AttributeCollection {

        return new AttributeCollection(Attribute::all());
    }

    public function show($id) : AttributeResource {

        return new AttributeResource(Attribute::findOrFail($id));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'     => 'required | regex:/^[^\'"]+$/',
            'type'     => 'required',
            'group_id' => 'required | numeric',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

       if(Attribute::create([
            'name'     => request('name'),
            'type'     => request('type'),
            'values'   => request('values'),
            'group_id' => request('group_id'),
        ]))
            return $this->success();
        else
            return $this->failure();
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name'     => 'required | regex:/^[^\'"]+$/',
            'type'     => 'required',
            'values'   => 'required',
            'group_id' => 'required | numeric',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        $attribute = Attribute::findOrFail($id);

        $attribute->name     = request('name');
        $attribute->type     = request('type');
        $attribute->values   = request('values');
        $attribute->group_id = request('group_id');

        if($attribute->isDirty(['name', 'type', 'group_id'])){
            $attribute->save();
            return $this->success();
        }
        else {
            return $this->failure();
        }
    }

    public function destroy($id) {
        $attribute = Attribute::findOrFail($id);
        $attribute->delete();

        return $this->success();
    }
}
