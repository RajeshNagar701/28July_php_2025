@extends('layouts.app')
@section('title', 'Secure Payment')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <h2 class="fw-800 mb-2">Secure Payment</h2>
            <p class="text-muted mb-4">You are about to pay <strong>₹{{ number_format($order->total, 2) }}</strong> for Order <strong>{{ $order->order_number }}</strong>.</p>
            
            <button id="rzp-button1" class="btn btn-primary btn-lg px-5 shadow-sm fw-700">
                <i class="bi bi-shield-lock me-2"></i>Pay Now with Razorpay
            </button>
            <p class="mt-3 text-muted small"><i class="bi bi-lock-fill text-success"></i> Secure 256-bit SSL encryption.</p>

            <!-- Razorpay Checkout Form Callback -->
            <form action="{{ route('checkout.callback') }}" method="POST" id="razorpay-form" class="d-none">
                @csrf
                <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
                <input type="hidden" name="razorpay_signature" id="razorpay_signature">
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var options = {
    "key": "{{ config('services.razorpay.key') }}", // Use public test key
    "amount": "{{ round($order->total * 100) }}", 
    "currency": "INR",
    "name": "ShoeStore",
    "description": "Order #{{ $order->order_number }}",
    "image": "{{ asset('img/logo.png') }}",
    "order_id": "{{ $order->razorpay_order_id }}", 
    "handler": function (response){
        // Populate hidden form and submit to callback
        document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
        document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
        document.getElementById('razorpay_signature').value = response.razorpay_signature;
        document.getElementById('razorpay-form').submit();
    },
    "prefill": {
        "name": "{{ $order->shipping_name }}",
        "email": "{{ $order->shipping_email }}",
        "contact": "{{ $order->shipping_phone }}"
    },
    "theme": {
        "color": "#6C3AFF"
    }
};
var rzp1 = new Razorpay(options);
rzp1.on('payment.failed', function (response){
    alert("Payment failed! Reason: " + response.error.description);
});
document.getElementById('rzp-button1').onclick = function(e){
    rzp1.open();
    e.preventDefault();
}
</script>
@endsection
