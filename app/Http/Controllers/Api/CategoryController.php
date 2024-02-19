<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{


    public function addCat(Request $request):JsonResponse{


        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'desc'=>'required',
        ]);

        if ($validator->fails()){
            return response()->json([
                'message' => 'Error Plase check for inputs '], 404);
        }

        else
            {
                $cat=Category::create($request->all() );
                return response()->json(
                    ['message'=>'Done',

                    ],201
                );
            }
    }


    public function edit(Request $request,$id):JsonResponse{

        $validator = Validator::make($request->all(), [

            'name' => 'required',
            'desc'=>'required',

        ]);

        $cat=Category::find($id);

        if (!$cat){
            return response()->json([
                'message' => 'Error Plase check for inputs '], 404);
        }

        else{
            $cat->update($request->all());

            return response()->json(
                ['message' => 'Done! '], 201);
        }




    }

    public function destroy($id):JsonResponse{

        $cat=Category::find($id);

        if($cat)
            {
                $cat->delete($id);
                return response()->json([
                    'message'=>'Delete Done'
                ],201);
            }

        else{
            return response()->json([
                'message'=>'Bad request'
 ] ,400          );
        }
    }
}
