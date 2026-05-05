<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pay Now - {{ $order->id }}</title>

    <!-- Correct checkout.js for v63+ -->
    <script src="https://test-bankofceylon.mtf.gateway.mastercard.com/static/checkout/checkout.min.js"
        data-error="errorCallback" data-cancel="cancelCallback" data-complete="completeCallback"></script>
</head>

<body>

    <h2>Processing Payment...</h2>

    <script>
        function errorCallback(error) {
            console.error("Payment Error:", error);
            alert("Payment Error: " + JSON.stringify(error));
            window.location.href = "{{ route('home.index') }}";
        }

        function cancelCallback() {
            alert("Payment cancelled by user.");
            window.location.href = "{{ route('home.index') }}";
        }

        function completeCallback(result) {
            console.log("Complete Callback:", result);
        }

        Checkout.configure({
            session: {
                id: "{{ $sessionId }}"
            }
        });

        Checkout.showPaymentPage();
    </script>

</body>

</html>
