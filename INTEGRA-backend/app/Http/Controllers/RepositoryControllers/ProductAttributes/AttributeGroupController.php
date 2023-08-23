<?php

namespace App\Http\Controllers\RepositoryControllers\ProductAttributes;

use App\Http\Controllers\Controller;
use App\Http\Resources\Repository\ProductAttributes\AttributeCollection;
use App\Http\Resources\Repository\ProductAttributes\AttributeGroupCollection;
use App\Http\Resources\Repository\ProductAttributes\AttributeGroupResource;
use App\Models\Repository\ProductAttributes\AttributeGroup;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AttributeGroupController extends Controller
{
    public function index() : AttributeGroupCollection {
        return new AttributeGroupCollection(AttributeGroup::all());
    }

    public function show($id) : AttributeGroupResource {
        return new AttributeGroupResource(AttributeGroup::findOrFail($id));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required | regex:/^[^\'"]+$/',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

       if(AttributeGroup::create([
            'name' => request('name'),
        ]))
            return $this->success();
        else
            return $this->failure();
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'required | regex:/^[^\'"]+$/',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        $attributeGroup = AttributeGroup::findOrFail($id);

        $attributeGroup->name = request('name');

        if($attributeGroup->isDirty(['name'])){
            $attributeGroup->save();
            return $this->success();
        }
        else {
            return $this->failure();
        }
    }

    public function destroy($id) {
        $attributeGroup = AttributeGroup::findOrFail($id);
        $attributeGroup->delete();

        return $this->success();
    }

    public function getAttributesByGroup($id) {
        $attributeGroup = AttributeGroup::findOrFail($id)->attributes;
        return new AttributeCollection($attributeGroup);
    }
}
