<?php

namespace App\Http\Controllers;

use App\Mail\AdminOrderMail;
use App\Mail\CustomerOrderMail;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'full_name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'address1' => 'required',
                'city' => 'required',
                'district' => 'required',
                // 'payment_method' => 'required'
                'payment_method' => 'nullable'
            ]);

            $cart = session('cart');

            if (!$cart || count($cart) == 0) {
                return back()->with('error', 'Cart is empty');
            }

            DB::beginTransaction();
        } catch (\Exception $e) {

            DB::rollback();

            Log::error('Checkout ', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Order failed');
        }

        try {

            $subtotal = 0;

            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            $shipping = 500;
            $tax = 0;
            $discount = 0;
            $total = $subtotal + $shipping + $tax - $discount;

            // create order
            $order = Order::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address1' => $request->address1,
                'address2' => $request->address2,
                'city' => $request->city,
                'district' => $request->district,
                'postal_code' => $request->postal_code,

                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'tax' => $tax,
                'discount' => $discount,
                'total' => $total,

                'payment_method' => 'cod',
                'payment_status' => 'pending',
                'status' => 'pending'
            ]);

            // save items
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'] ?? null,
                    'product_name' => $item['name'],
                    'image' => $item['image'],
                    'color' => $item['color'] ?? null,
                    'size' => $item['size'] ?? null,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['price'] * $item['quantity']
                ]);
            }

            DB::commit();

            // load items for email
            $order->load('items');

            // send admin mail
            Mail::to('dilshanmadushanka981@gmail.com')->send(new AdminOrderMail($order));

            // send customer mail
            Mail::to($order->email)->send(new CustomerOrderMail($order));

            session()->forget('cart');

            return response()->json([
                'status' => 'success',
                'message' => 'Order ' . $order->order_number . ' placed successfully!',
                'redirect' => route('home.index')
            ]);
        } catch (\Exception $e) {

            DB::rollback();

            Log::error('Checkout Store Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Order failed'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
