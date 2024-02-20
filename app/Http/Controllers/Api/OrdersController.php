<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Order;
use App\Models\ProductOrder;
use App\Models\Product;

class OrdersController extends Controller
{

    public function store(Request $request): JsonResponse
    {

        if (empty($request->products)) {
            return response()->json(
                [
                    'message' => 'products are not exist!',
                ],
                400,
            );
        }

        // adding order products to database
        $total = 0;
        $requestProducts = $request->products;

        // get products ids
        $requestProductsIds = [];
        foreach ($requestProducts as $rP) {
            $requestProductsIds[] = $rP['id'];
        }

        // get products from DB
        $dbProducts = Product::whereIn('id', $requestProductsIds)->get();

        // Validation 2
        // check if products count is same (qty, stock ...)
        if (count($requestProducts) != count($dbProducts)) {
            return response()->json(
                [
                    'message' => 'Some of the products that you requested was not found!',
                ],
                400,
            );
        }

        foreach ($requestProducts as $rP) {
            foreach ($dbProducts as $dP) {
                if ($rP['id'] == $dP->id) {
                    $rP['object'] = $dP;
                }
            }
        }

        // create order
        $order = Order::create([
            'user_id' => $request->user()->id,
            'total' => 0,
            'date' => date('Y-m-d H:i:s'),
        ]);

        // todo: get all products from db at once
        foreach ($requestProducts as $rProduct) {

            $total += $rP['object']->price * $rProduct['qty'];

            // add the product
            ProductOrder::create([
                'product' => $rProduct['id'],
                'qty' => $rProduct['qty'],
                'order' => $order->id,
            ]);
        }

        // set the total amount
        $order->total = $total;
        $order->save();

        return response()->json([
            'message' => 'Order has been created successfully',
            'order' => $order,
        ], 200);
    }

    public function index(Request $request): JsonResponse
    {

        $orders = Order::where('user_id', $request->id)
            ->with('products')->get();

        return response()->json([
            'message' => 'Orders has been retrived successfully',
            'order' => $orders,
        ], 201);
    }

    public function show(Order $order):JsonResponse
    {

    }

    public function all():JsonResponse{

        $orders=Order::all();

        return response()->json([
            'data'=>$orders,
            'message'=>'Success '
        ],201);

    }

    public function update(Request $request, $order_id):JsonResponse
    {
        // get & check order
        $order = Order::where(
            [
                ['id', $order_id],
                ['user_id', $request->user()->id]
            ]
        )->with('products')->first();

        // check order & products
        if (empty($order) || empty($request->products)) {
            return response()->json([
                'message' => 'Order/Products were not found'
            ], 400);
        }

        // check products in request
        foreach ($request->products as $product) {
            foreach ($order->products as  $prodOrder) {
                if ($product['id'] == $prodOrder->id) {
                    // requested Product Order Record to be updated was found =>
                    // check update Type:
                    // 1) delete
                    if ($product['qty'] == -1) {
                        $prodOrder->delete();
                    }
                    // 2) update
                    else if (
                        $product['qty'] > 0
                        && $product['qty'] !=  $prodOrder->qty
                    ) {
                        $prodOrder->qty = $product['qty'];
                        $prodOrder->save();
                    }
                }
            }
        }

        // update total
        $total = 0; // init total
        $order = $order->fresh(); // sync ram & db
        // calc the new total
        foreach ($order->products as $pO) {
            $total = $total + ($pO->qty * $pO->product_object->price);
        }
        $order->total = $total;
        $order->save();


        return response()->json([
            'message' => 'Order has been updated successfully',
            'order' => $order,
        ], 201);
    }
}
