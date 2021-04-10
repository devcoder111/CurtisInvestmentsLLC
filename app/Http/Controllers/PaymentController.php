<?php

namespace App\Http\Controllers;

use App\Flower;
use App\Payment;
use App\SubscriptionItem;
use Cartalyst\Stripe\Stripe;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public $flower;

    public function __construct()
    {
        $this->flower = Flower::query()->first();
    }

    public function appPayment(Request $request)
    {
        $intent = $request->user()->createSetupIntent();
        $amount = 100.00;
        $ref = 'app-fee';
        $week = $this->flower->current_week;
        $flowerRootRefId = null;
        $redirect = route('home');

        return view('payments.index', compact('intent', 'amount', 'ref', 'week', 'flowerRootRefId', 'redirect'));
    }

    public function appSubscripton(Request $request)
    {
       
        return view('payments.subscription');
    }

    public function createCheckoutSession(Request $request)
    {
        $domain_url = "https://www.example.com";
        $stripeSecret = env('STRIPE_SECRET');
       
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $checkout_session = \Stripe\Checkout\Session::create([
            'success_url' => $domain_url . '/success.html?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $domain_url . '/canceled.html',
            'payment_method_types' => ['card'],
            'mode' => 'subscription',
            'line_items' => [[
              'price' => $request->priceId,
              'quantity' => 1,
            ]]
        ]);
          
        echo json_encode(['sessionId' => $checkout_session['id']]);
    }

    public function processPayment(Request $request)
    {
        $user = $request->user();
        $plan = env('STRIPE_DEFAULT_PRODUCT_PRICE');

        if($user->subscribedToPlan($plan, 'main')) {
            return redirect()->route('home')->with('success', 'You have already subscribed the plan');
        }
        $paymentMethod = $request->paymentMethod;

        $user->createOrGetStripeCustomer();
        $user->updateDefaultPaymentMethod($paymentMethod);
        $charge = $user
            ->charge(100 * 100, $paymentMethod);

        $ref = $request->get('ref');
        $week = $request->get('week');
        $flowerRootRefId = $request->get('flower_root_ref_id');
        $redirect = $request->has('redirect') ? $request->get('redirect') : route('home');
        $paymentIntent = $charge->asStripePaymentIntent();
        if ($charge && $paymentIntent) {
            Payment::create([
                'user_id' => $user->id,
                'amount' => $paymentIntent->amount,
                'amount_received' => $paymentIntent->amount_received,
                'stripe_payment_intent_id' => $paymentIntent->id,

                'ref' => $ref,
                'week' => $week,
                'flower_root_ref_id' => $flowerRootRefId,
            ]);
            return redirect($redirect)->with('success', 'Successful Payment');
        } else {
            return redirect($redirect)->with('error', 'There was a problem processing the payment');
        }

    }
}