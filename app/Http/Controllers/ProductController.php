<?php

namespace App\Http\Controllers;

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
        return response()->json([
           'status' => true,
           'message' => 'get all products',
           'data' => $products
        ]);
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
            return response()->json([
                'success' => false,
                'message' => 'error',
                'data' => $validator->errors()
            ])  ;
        }
        $product = product::query()->create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'create product successful',
            'data' => $product
        ]);
    }

    public function show(product $product)
    {
        return response()->json([
           'success' => true,
           'message' => 'get product',
            'data' => $product
        ]);
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
            return response()->json([
                'success' => false,
                'message' => 'error',
                'data' => $validator->errors()
            ])  ;
        }
        $product->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'update product successful',
            'data' => $product
        ]);
    }

    public function destroy(product $product)
    {
        $product->delete();
        return response()->json([
            'status' => true,
            'message' => 'delete product successful',
            'data' => $product
        ]);
    }
}
