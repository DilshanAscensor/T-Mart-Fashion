<?php

namespace App\Http\Controllers;

use App\Mail\AdminOrderMail;
use App\Mail\CustomerOrderMail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
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
        $request->validate([
            'full_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address1' => 'required',
            'city' => 'required',
            'district' => 'required',
            'payment_method' => 'required|in:cod,card'
        ]);

        $cart = session('cart');

        if (!$cart || count($cart) == 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart is empty'
            ], 422);
        }

        try {
            DB::beginTransaction();

            // ✅ IMPORTANT: STOCK VALIDATION BEFORE ORDER
            foreach ($cart as $item) {

                $variant = ProductVariant::where('id', $item['variant_id'])->lockForUpdate()->first();

                if (!$variant) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 'error',
                        'message' => "Product variant not found."
                    ], 422);
                }

                if ($variant->available_stock < $item['quantity']) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 'error',
                        'message' => "{$item['name']} ({$item['color']} - {$item['size']}) is out of stock."
                    ], 422);
                }
            }

            // 💰 totals
            $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
            $shipping = 400;
            $tax = 0;
            $discount = 0;
            $total = $subtotal + $shipping + $tax - $discount;

            $order = Order::create([
                'full_name'      => $request->full_name,
                'email'          => $request->email,
                'phone'          => $request->phone,
                'address1'       => $request->address1,
                'address2'       => $request->address2,
                'city'           => $request->city,
                'district'       => $request->district,
                'postal_code'    => $request->postal_code,

                'subtotal'       => $subtotal,
                'shipping'       => $shipping,
                'tax'            => $tax,
                'discount'       => $discount,
                'total'          => $total,

                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'status'         => 'pending',
            ]);

            // 🧾 Save Order Items
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item['product_id'] ?? null,
                    'product_name' => $item['name'],
                    'image'        => $item['image'],
                    'color'        => $item['color'] ?? null,
                    'size'         => $item['size'] ?? null,
                    'quantity'     => $item['quantity'],
                    'price'        => $item['price'],
                    'total'        => $item['price'] * $item['quantity'],
                ]);
            }

            DB::commit();

            $order->load('items');

            session()->forget('cart');

            // ==================== COD ====================
            if ($request->payment_method === 'cod') {
                $this->sendOrderEmails($order);

                return response()->json([
                    'status'   => 'success',
                    'message'  => 'Order placed successfully!',
                    'redirect' => route('home.index')
                ]);
            }

            // ==================== CARD ====================
            return response()->json([
                'status'   => 'card',
                'redirect' => route('payment.card', $order->id)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Checkout Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }
    private function sendOrderEmails(Order $order)
    {
        try {
            // $adminEmail   = 'dilshan.zincat@gmail.com';
            $adminEmail   = 'sanjumadhumadawa90@gmail.com';

            // === ADMIN EMAIL ===
            Mail::to($adminEmail)
                ->send(new AdminOrderMail($order));

            Log::info('Admin order email sent', [
                'order_id' => $order->id,
                'to' => $adminEmail,
            ]);

            // === CUSTOMER EMAIL ===
            Mail::to($order->email)
                ->send(new CustomerOrderMail($order));

            Log::info('Customer order email sent', [
                'order_id' => $order->id,
                'to' => $order->email
            ]);
        } catch (\Exception $e) {
            Log::error('Order email sending failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
