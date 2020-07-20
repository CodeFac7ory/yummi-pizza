<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Order;
use App\Http\Resources\Order as OrderResource;
use App\Http\Resources\OrderCollection;

use App\OrderItem;
use App\Http\Resources\Order as OrderItemResource;
use App\Http\Resources\OrderItemCollection;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new OrderCollection(Order::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = new Order;
        $order->user_id = $request->user_id;
        $order->token = $request->token;
        $order->total_price = $request->total_price;
        $order->address = $request->address;
        $order->status = $request->status;
        $order->save();

        // $order->items = [];

        foreach ($request->items as $reqItem) {
            $orderItem = new OrderItem;
            $orderItem->order_id = $order->id;
            $orderItem->pizza_id = $reqItem['pizza_id'];
            $orderItem->quantity = $reqItem['quantity'];
            $orderItem->price = $reqItem['price'];

            $orderItem->save();

            // $order->items[] = array(
            //     'name' => $orderItem['id'],
            //     'order_id' => $orderItem['order_id'],
            //     'pizza_id' => $orderItem['pizza_id'],
            //     'quantity' => $orderItem['quantity'],
            //     'price' => $orderItem['price']
            // );
        }

        return (new OrderResource($order))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order->user_id = $request->user_id;
        $order->token = $request->token;
        $order->total_price = $request->total_price;
        $order->address = $request->address;
        $order->status = $request->status;

        $affected = DB::table('users')
            ->where('id', $id)
            ->update([
                'user_id' => $request->user_id,
                'token' => $request->token,
                'total_price' => $request->total_price,
                'address' => $request->address,
                'status' => $request->status,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function cart(Request $request)
    {
        if ($request->input('user_id')) {
            $order = DB::table('orders')
                ->where('user_id', $request->input('user_id'))
                ->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->take(1)
                ->get();

        }
        else {

            $order = DB::table('orders')
                ->where('token', $request->header('X-CSRFToken'))
                ->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->take(1)
                ->get();
        }

        if (isset($order[0])) {

            $order[0]->items = DB::table('order_items')
                ->join('pizzas', 'order_items.pizza_id', '=', 'pizzas.id')
                ->where('order_id', '=', $order[0]->id)
                ->select('order_items.*', 'pizzas.name', 'pizzas.picture')
                ->get();
        }

        return $order;

    }

    public function deleteOrderItem(Request $request, $id)
    {

        $res = DB::table('order_items')->where('id', $id)->delete();
        return $res;
    }
}
