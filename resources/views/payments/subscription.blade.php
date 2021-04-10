@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{asset('css/normalize.css')}}" />
<link rel="stylesheet" href="{{asset('css/global.css')}}" />
<div class="sr-root">
    <div class="sr-main" style="display: flex;">

        <div class="sr-container">
            <section class="container basic-photo">
                <div>
                    <h1>Basic subscription</h1>
                    <h4>supported only 1 function</h4>
                    <div class="pasha-image">
                        <img src="https://picsum.photos/280/320?random=4" width="140" height="160" />
                    </div>
                </div>
                <button id="basic-plan-btn">$40.00 per week</button>
            </section>
            <section class="container pro-photo">
                <div>
                    <h1>Pro subscription</h1>
                    <h4>supported 10 functions</h4>
                    <div class="pasha-image-stack">
                        <img src="https://picsum.photos/280/320?random=1" width="105" height="120"
                            alt="Sample Pasha image 1" />
                        <!-- <img src="https://picsum.photos/280/320?random=2" width="105" height="120"
                            alt="Sample Pasha image 2" />
                        <img src="https://picsum.photos/280/320?random=3" width="105" height="120"
                            alt="Sample Pasha image 3" /> -->
                    </div>
                </div>
                <button id="pro-plan-btn">$80.00 per week</button>
            </section>
        </div>
        <div id="error-message"></div>
    </div>
</div>
@endsection


@section('javascript')
<!-- <script src="https://js.stripe.com/v3/"></script> -->

<script>
var publishableKey = "{{ env('STRIPE_KEY') }}";
var basicPriceId = "{{ env('MIX_basic_price_id') }}";
var proPriceId = "{{ env('MIX_pro_price_id') }}";
console.log("dd", publishableKey)
// Create a Checkout Session with the selected plan ID
var createCheckoutSession = function(priceId) {
    return fetch("/create-checkout-session", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            priceId: priceId,
        }),
    }).then(function(result) {
        console.log('checkout', result);
        return result.json();
    });
};

// Handle any errors returned from Checkout
var handleResult = function(result) {
    if (result.error) {
        var displayError = document.getElementById("error-message");
        displayError.textContent = result.error.message;
    }
};


var stripe = Stripe(publishableKey);
console.log('basic');
// Setup event handler to create a Checkout Session when button is clicked
document
    .getElementById("basic-plan-btn")
    .addEventListener("click", function(evt) {
        console.log('basic');
        createCheckoutSession(basicPriceId).then(function(data) {
            // Call Stripe.js method to redirect to the new Checkout page
            stripe
                .redirectToCheckout({
                    sessionId: data.sessionId,
                })
                .then(handleResult);
        });
    });

// Setup event handler to create a Checkout Session when button is clicked
document
    .getElementById("pro-plan-btn")
    .addEventListener("click", function(evt) {
        createCheckoutSession(proPriceId).then(function(data) {
            // Call Stripe.js method to redirect to the new Checkout page
            stripe
                .redirectToCheckout({
                    sessionId: data.sessionId,
                })
                .then(handleResult);
        });
    });
</script>
@endsection