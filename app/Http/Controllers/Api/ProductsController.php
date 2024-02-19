<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{


    public function index(): JsonResponse
    {

        $prducts = Product::all();

        return response()->json([
            'data' => $prducts,
            'message' => 'all Proucts'
        ], 201);
    }

    public function GetProducts(Request $request): JsonResponse
    {
        // init request parameters
        $name = $request->name;
        $category = $request->category;

        $proudcts = Product::get();

        // filter by name
        if (!empty($name)) {
            $proudcts = $proudcts->where('name', $name);
        }

        // filter by category
        if (!empty($category)) {
            $proudcts = $proudcts->where('category', $category);
        }

        return response()->json([
            'message' => 'products has been retreived successfully',
            'data' => $proudcts,
        ], 200);
    }

    public function GetCategories(): JsonResponse
    {
        $categories = Category::all();

        return response()->json([
            'message' => 'Categroies has been retreived successfully',
            'data' => $categories,
        ], 200);
    }

    public function store(Request $request):JsonResponse {

        if(true){
            $validator = Validator::make($request->all(), [
                'category' => 'required',
                'name' => 'required',
                'price'=>'required',
                'description'=>'required',
            ]);

            if ($validator->fails()){
                return response()->json([
                    'message' => 'Error Plase check for inputs '], 404);
            }
            else {

                $product=Product::create($request->all());

                return response()->json([
                    'message' => 'Done '], 201);
            }
        }

        else{
            return response()->json([
                'message'=>true
            ],201);
        }


    }


    public function update(Request $request ,$id):JsonResponse

    {
        $validator = Validator::make($request->all(), [
            'category' => 'required',
            'name' => 'required',
            'price'=>'required',
            'description'=>'required',
        ]);

        $poduct=Product::find($id);

        if (!$poduct){
            return response()->json([
                'message' => 'Error Plase check for inputs '], 404);
        }

        else{
            $poduct->update($request->all());

            return response()->json(
               ['message' => 'Done! '], 201);
        }


    }


    public function info():JsonResponse {

        $usersCount=User::all()->count();
        $productCount=Product::all()->count();
        $orderCount=Order::all()->count();

        return response()->json(
            [
                'Count Of Product'=>$productCount,
                'Count Of Users'=>$usersCount,
                'Count Of Order'=>$orderCount,
            ],201
        );


    }

}
