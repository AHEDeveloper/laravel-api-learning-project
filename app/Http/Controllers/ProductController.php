<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Models\product;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreproductRequest;
use App\Http\Requests\UpdateproductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = product::all();
        return ApiResponseClass::apiResponse(true,'get all products',$products,200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
           'name' => 'required|string|max:50',
           'price' => 'required|string|max:50',
           'description' => 'nullable|max:500',
        ]);

        if ($validator->fails())
        {
            return ApiResponseClass::apiResponse(false,'validation false',$validator->errors(),422);
        }
        $product = product::query()->create($request->all());
        return ApiResponseClass::apiResponse(true,'create product successful',$product,200);
    }

    public function show(product $product)
    {
        return ApiResponseClass::apiResponse(true,'get product',$product,200);
    }

    public function update(Request $request, product $product)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:50',
            'price' => 'required|string|max:50',
            'description' => 'nullable|max:500',
        ]);

        if ($validator->fails())
        {
            return ApiResponseClass::apiResponse(false,'validation false',$validator->errors(),422);

        }
        $product->update($request->all());
        return ApiResponseClass::apiResponse(true,'update product successful',$product,200);
    }

    public function destroy(product $product)
    {
        $product->delete();
        return ApiResponseClass::apiResponse(true,'delete product successful',null,200);
    }
}
