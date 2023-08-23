<?php

namespace App\Http\Controllers\RepositoryControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Repository\CategoryCollection;
use App\Http\Resources\Repository\CategoryResource;
use App\Http\Resources\Repository\ProductResource;
use App\Models\Repository\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index() : CategoryCollection {
        return new CategoryCollection(Category::all());
    }

    public function show($id) : CategoryResource {
        $catagory = Category::find($id);
        if($catagory)
             return new CategoryResource($catagory);
        else 
             return $this->failure();
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required | regex:/^[a-zA-Z0-9\s]+$/',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

       if( Category::create([
            'name' => request('name'),
        ]))
            return $this->success();
        else
            return $this->failure();
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'required | regex:/^[a-zA-Z0-9\s]+$/',
        ]);

        if ($validator->fails()) {
            return  $validator->errors();
        }

        $category = Category::findOrFail($id);

        $category->name = request('name');

        if($category->isDirty(['name'])){
            $category->save();
            return $this->success();
        }
        else {
            return $this->failure();
        }
    }

    public function destroy($id) {
        if( $catagory = Category::findOrFail($id)){
            $catagory->delete();
            return $this->success();
        } 
        else
            return $this->failure();
    }

    public function getProductsByCategory($id) {
        $catagory = Category::findOrFail($id);
        return new ProductResource($catagory->products);
    }
}
