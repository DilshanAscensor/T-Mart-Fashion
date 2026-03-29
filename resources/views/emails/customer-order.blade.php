<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body style="font-family: Arial; background:#f5f5f5; padding:20px;">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">

                <table width="650" style="background:#fff;padding:30px;border-radius:8px">

                    <tr>
                        <td align="center" style="border-bottom:1px solid #eee;padding-bottom:15px">
                            <h2 style="margin:0">TMart Fashion</h2>
                            <p style="color:#777">Order Confirmation</p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:20px 0">

                            <p>Hi <strong>{{ $order->full_name }}</strong>,</p>

                            <p>Your order has been placed successfully.</p>

                            <p>
                                <strong>Order ID:</strong> #{{ $order->order_number }} <br>
                                <strong>Order Date:</strong> {{ $order->created_at->format('d M Y - h:i A') }}
                            </p>

                        </td>
                    </tr>

                    <tr>
                        <td>

                            <h3>Order Items</h3>

                            <table width="100%" style="border-collapse:collapse">

                                <thead>
                                    <tr style="background:#f3f3f3">
                                        <th align="left" style="padding:10px">Product</th>
                                        <th align="center">Qty</th>
                                        <th align="right">Price</th>
                                        <th align="right">Total</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr style="border-bottom:1px solid #eee">
                                            <td style="padding:10px">
                                                {{ $item->product_name }}

                                                @if ($item->color)
                                                    <br><small>Color: {{ $item->color }}</small>
                                                @endif

                                                @if ($item->size)
                                                    <br><small>Size: {{ $item->size }}</small>
                                                @endif

                                            </td>

                                            <td align="center">
                                                {{ $item->quantity }}
                                            </td>

                                            <td align="right">
                                                LKR {{ number_format($item->price, 2) }}
                                            </td>

                                            <td align="right">
                                                LKR {{ number_format($item->total, 2) }}
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>

                        </td>
                    </tr>

                    <tr>
                        <td style="padding-top:20px">

                            <table width="100%">
                                <tr>
                                    <td>Subtotal</td>
                                    <td align="right">LKR {{ number_format($order->subtotal, 2) }}</td>
                                </tr>

                                <tr>
                                    <td>Shipping</td>
                                    <td align="right">LKR {{ number_format($order->shipping, 2) }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Total</strong></td>
                                    <td align="right">
                                        <strong>LKR {{ number_format($order->total, 2) }}</strong>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <tr>
                        <td style="border-top:1px solid #eee;padding-top:20px;text-align:center;color:#777">

                            Thank you for shopping with <strong>TMart Fashion</strong>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
