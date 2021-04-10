@extends('layouts.app')

@section('content')

<style>
.StripeElement {
    width: 100%;
    box-sizing: border-box;
    height: 40px;
    padding: 10px 12px;
    border: 1px solid transparent;
    border-radius: 4px;
    background-color: white;
    box-shadow: 0 1px 3px 0 #e6ebf1;
    -webkit-transition: box-shadow 150ms ease;
    transition: box-shadow 150ms ease;
}

.StripeElement--focus {
    box-shadow: 0 1px 3px 0 #cfd7df;
}

.StripeElement--invalid {
    border-color: #fa755a;
}

.StripeElement--webkit-autofill {
    background-color: #fefde5 !important;
}

.form-row {
    width: 100%;
    float: left;
}

form#payment-form {
    background: #f7f8f9;
    padding: 16px;
}

button#st-btn {
    width: 32%;
    padding: 11px;
    margin-left: 10px;
    margin-top: 21px;
    background: #43458b;
    border: none;
    color: #fff;
    height: 42px;
    line-height: 40px;
    padding: 0 14px;
    box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
    border-radius: 4px;
    font-size: 15px;
    font-weight: 600;
    letter-spacing: 0.025em;
    cursor: pointer;
}

div#card-errors {
    padding: 6px 0;
    color: #fa755a;
    font-weight: 600;
}

.card-deck {
    width: 100%;
    max-width: 400px;
}
</style>

<section class="payment-monthly container">
    <div class="row">
        <div class="col col-md-12 d-flex justify-content-center">
            <div class="card-deck text-center">
                <div class="card mb-4 box-shadow">
                    <form method="POST" action="{{ route('payments.process') }}" id="payment-form">
                        @csrf

                        <div class="card-header bg-transparent">
                            <img src="https://svgshare.com/i/PAK.svg" alt="web-banner" width="120px">
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h3 class="card-title">Make a Payment</h3>
                            <p class="card-text font-weight-bold mb-auto">Powered by Stripe</p>
                            <ul class="list-unstyled my-4">
                                <li>Donec interdum commodo velit, Mauris tristique vitae</li>
                            </ul>
                            <h3 class="mb-4">{{ $amount }} U$D
                                <small class="text-muted">/ month</small>
                            </h3>

                            <input type="hidden" name="ref" value="{{ $ref }}">
                            @if($week) <input type="hidden" name="week" value="{{ $week }}"> @endif
                            @if($flowerRootRefId) <input type="hidden" name="flower_root_ref_id"
                                value="{{ $flowerRootRefId }}"> @endif
                            @if($redirect) <input type="hidden" name="redirect" value="{{ $redirect }}"> @endif

                            <div class="form-row">
                                <label for="card-element">Credit or debit card</label>

                                <div id="card-element">
                                    <!-- A Stripe Card Element will be inserted here. -->
                                </div>

                                <!-- Used to display form errors. -->
                                <div id="card-errors" role="alert"></div>

                                {{--<button type="submit" class="btn btn-lg btn-danger">Pay Now</button>--}}
                            </div>

                        </div>
                        <div class="card-footer bg-danger">
                            <button type="submit" class="btn btn-lg btn-danger" id="card-button"
                                data-secret="{{ $intent->client_secret }}">CONFIRM</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
console.log("aa");
let stripe = Stripe(
    'pk_test_51GtsI6CDacaYxHbOYoLkjgG65QoCCyrZKtTHhfmKcQGFeD6XgKCqZBT2VZSQZwRAFiB3L1DDDqiqFFLAWXU8NyPW00MXrjGmqA');
let elements = stripe.elements();
const cardButton = document.getElementById('card-button');
const clientSecret = cardButton.dataset.secret;

const style = {
    base: {
        color: '#32325d',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
            color: '#aab7c4'
        }
    },
    invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
    }
};

// Create an instance of the card Element.
let card = elements.create('card', {
    style: style
});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});

// Handle form submission.
let form = document.getElementById('payment-form');

form.addEventListener('submit', function(event) {
    event.preventDefault();

    stripe
        .handleCardSetup(clientSecret, card, {
            payment_method_data: {
                //billing_details: { name: cardHolderName.value }
            }
        })
        .then(function(result) {
            console.log(result);
            if (result.error) {
                // Inform the user if there was an error.
                let errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                console.log(result);
                // Send the token to your server.
                stripeTokenHandler(result.setupIntent.payment_method);
            }
        });
});

// Submit the form with the token ID.
function stripeTokenHandler(paymentMethod) {
    // Insert the token ID into the form so it gets submitted to the server
    let form = document.getElementById('payment-form');
    let hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'paymentMethod');
    hiddenInput.setAttribute('value', paymentMethod);
    form.appendChild(hiddenInput);

    // Submit the form
    form.submit();
}
</script>
@endpush