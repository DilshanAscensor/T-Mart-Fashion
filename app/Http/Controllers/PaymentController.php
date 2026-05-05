<?php

namespace App\Http\Controllers;

use App\Mail\AdminOrderMail;
use App\Mail\CustomerOrderMail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function card($orderId)
    {
        $order = Order::findOrFail($orderId);

        $merchantId = env('MPGS_MERCHANT_ID');
        $password   = env('MPGS_PASSWORD');

        $url = "https://test-bankofceylon.mtf.gateway.mastercard.com/api/rest/version/100/merchant/{$merchantId}/session";

        $payload = [
            "apiOperation" => "INITIATE_CHECKOUT",

            "interaction" => [
                "operation" => "PURCHASE",
                "returnUrl" => route('payment.success', ['orderId' => $order->id]),
                "merchant" => [
                    "name" => "T-Mart Fashion",
                ]
            ],

            "order" => [
                "id"          => (string) $order->id,
                "amount"      => number_format((float) $order->total, 2, '.', ''),
                "currency"    => "LKR",
                "reference"   => "ORD-" . $order->id,
                "description" => "Purchase from T-Mart Fashion - Order #{$order->id}",
            ]
        ];

        Log::info('MPGS Payload', ['payload' => $payload]);

        $response = Http::withBasicAuth("merchant.{$merchantId}", $password)
            ->post($url, $payload);

        Log::info('MPGS Session Response', [
            'status' => $response->status(),
            'body'   => $response->body()
        ]);

        if (!$response->successful()) {
            Log::error('MPGS Failed', ['body' => $response->body()]);
            return abort(500, 'Payment initialization failed.');
        }

        $data = $response->json();

        if (empty($data['session']['id'] ?? null)) {
            return abort(500, 'Failed to create payment session.');
        }

        return view('payment.card', [
            'sessionId' => $data['session']['id'],
            'order'     => $order
        ]);
    }
    public function success(Request $request)
    {
        $orderId = $request->query('orderId');
        $resultIndicator = $request->query('resultIndicator');

        $order = Order::find($orderId);

        if (!$order) {
            return redirect()->route('home.index')
                ->with('error', 'Order not found.');
        }

        $merchantId = env('MPGS_MERCHANT_ID');
        $password   = env('MPGS_PASSWORD');

        $url = "https://test-bankofceylon.mtf.gateway.mastercard.com/api/rest/version/100/merchant/{$merchantId}/order/{$orderId}";

        $response = Http::withBasicAuth("merchant.{$merchantId}", $password)
            ->get($url);

        Log::info('MPGS Order Verify Response', [
            'order_id' => $orderId,
            'status'   => $response->status(),
            'body'     => $response->body()
        ]);

        $data = $response->json();

        $isSuccess = false;

        if (isset($data['result']) && $data['result'] === 'SUCCESS') {
            if (isset($data['order']['status']) && $data['order']['status'] === 'CAPTURED') {
                $isSuccess = true;
            } elseif (isset($data['transaction']) && isset($data['transaction'][0]['result']) && $data['transaction'][0]['result'] === 'SUCCESS') {
                $isSuccess = true;
            }
        }

        if ($resultIndicator && session('mpgs_success_indicator') === $resultIndicator) {
            $isSuccess = true;
        }

        if ($isSuccess) {
            $order->update([
                'payment_status' => 'paid',
            ]);

            session()->forget('mpgs_success_indicator');

            // ✅ Send emails after successful payment
            $this->sendOrderEmails($order);

            return redirect()->route('home.index')
                ->with('success', 'Payment successful! Thank you for your order.');
        }

        $order->update([
            'payment_status' => 'failed'
        ]);

        return redirect()->route('home.index')
            ->with('error', 'Payment failed or could not be verified.');
    }

    public function cancel($orderId)
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->update(['payment_status' => 'cancelled']);
        }

        return redirect()->route('home.index')
            ->with('error', 'Payment was cancelled.');
    }

    private function sendOrderEmails(Order $order)
    {
        try {
            Mail::to('dilshanmadushanka981@gmail.com')
                ->send(new AdminOrderMail($order));

            // Customer Email
            Mail::to($order->email)
                ->send(new CustomerOrderMail($order));

            Log::info('Order emails sent', ['order_id' => $order->id]);
        } catch (\Exception $e) {
            Log::error('Email sending failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}
