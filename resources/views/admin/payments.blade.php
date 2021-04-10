@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Payments</div>

        <div class="card-body">
            <div class="jumbotron">
                <h1 class="display-4">Stripe Payments</h1>
                <p class="lead">Enrollment and fire payments are handled by Stripe</p>
                <hr class="my-4">
                <p>For more information, access the stripe dashboard.</p>
                <a class="btn btn-primary btn-lg" href="{{ env('STRIPE_DASHBOARD') }}" role="button">Stripe Dashboard</a>
            </div>
        </div>
    </div>
@endsection
