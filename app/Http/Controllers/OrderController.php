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
    public function index(Request $request)
    {

        $orders = DB::table('orders')
            ->where('user_id', $request->user_id)
            ->where('status', 'complete')
            ->orderBy('updated_at', 'desc')
            ->get();

        foreach ($orders as $order) {

            $orderItems = DB::table('order_items')
                ->join('pizzas', 'order_items.pizza_id', '=', 'pizzas.id')
                ->where('order_id', $order->id)
                ->select('order_items.*', 'pizzas.name', 'pizzas.picture')
                ->get();

                $order->items = $orderItems;
        }

        return $orders;
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

        //if there is some pending orders from this user we delete them so we have only one pending
        if ($request->user_id) {
            DB::table('orders')
                ->where('user_id', $request->user_id)
                ->where('status', 'pending')
                ->delete();
        }

        $order = new Order;
        $order->user_id = $request->user_id;
        $order->token = $request->token;
        $order->total_price = $request->total_price;
        $order->status = $request->status;
        $order->save();

        foreach ($request->items as $reqItem) {
            $orderItem = new OrderItem;
            $orderItem->order_id = $order->id;
            $orderItem->pizza_id = $reqItem['pizza_id'];
            $orderItem->quantity = $reqItem['quantity'];
            $orderItem->price = $reqItem['price'];

            $orderItem->save();
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

        //orders are updated each time new item is added
        //new item is always last item in array

        $lastIndex = count($request->items) - 1;

        if ($lastIndex > -1) {

            $newItem = $request->items[$lastIndex];

            $orderItem = new OrderItem;
            $orderItem->order_id = $id;
            $orderItem->pizza_id = $newItem['pizza_id'];
            $orderItem->quantity = $newItem['quantity'];
            $orderItem->price = $newItem['price'];
            $orderItem->save();
        }

        $affected = DB::table('orders')
            ->where('id', $id)
            ->update([
                'user_id' => $request->user_id,
                'token' => $request->token,
                'total_price' => $request->total_price,
                'street' => $request->street,
                'postal_code' => $request->postal_code,
                'city' => $request->city,
                'country' => $request->country,
                'status' => $request->status,
            ]);

        $order = DB::table('orders')
        ->where('id', $id)
        ->get();

        return $order;
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
                ->orderBy('updated_at', 'desc')
                ->take(1)
                ->get();

        }
        else {

            $order = DB::table('orders')
                ->where('token', $request->header('X-CSRFToken'))
                ->where('status', 'pending')
                ->orderBy('updated_at', 'desc')
                ->take(1)
                ->get();
        }

        if (isset($order[0])) {

            $order[0]->items = DB::table('order_items')
                ->join('pizzas', 'order_items.pizza_id', '=', 'pizzas.id')
                ->where('order_id', $order[0]->id)
                ->select('order_items.*', 'pizzas.name', 'pizzas.picture')
                ->get();
        }

        return $order;

    }

    public function deleteOrderItem(Request $request, $id)
    {

        $item = DB::table('order_items')
            ->where('id', $id)
            ->get();

        DB::table('order_items')->where('id', $id)->delete();

        $items = DB::table('order_items')
            ->join('pizzas', 'order_items.pizza_id', '=', 'pizzas.id')
            ->where('order_id', $item[0]->order_id)
            ->select('order_items.*', 'pizzas.name', 'pizzas.picture')
            ->get();

        $totalPrice = 0;

        foreach ($items as $reqItem) {
            $totalPrice += $reqItem->price;
        }

        $affected = DB::table('orders')
        ->where('id', $item[0]->order_id)
        ->update([
            'total_price' => $totalPrice,
        ]);

        $order = DB::table('orders')
        ->where('id', $item[0]->order_id)
        ->get();

        $order[0]->items = $items;

        return $order;
    }


    public function complete(Request $request, $id)
    {

        $affected = DB::table('orders')
            ->where('id', $id)
            ->update([
                'status' => 'complete',
                'street' => $request->input('street'),
                'postal_code' => $request->input('postalCode'),
                'city' => $request->input('city'),
                'country' => $request->input('country'),
            ]);

        $order = DB::table('orders')
        ->where('id', $id)
        ->get();

        return $order;
    }
}
