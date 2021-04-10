@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                @include('payments.fire-alert')

                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                        <style>
                            .home-widget .card {
                                height: 100%;
                            }

                            .card .card-img-top {
                                height: 75px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            }
                        </style>

                        <div class="row">
                            <div class="col-lg-6 col-md-12 home-widget mb-4">
                                <div class="card bg-light">
                                    <div class="card-img-top bg-primary text-light">
                                        <h2>{{ $readableMemberState }}</h2>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Member Information</h5>
                                        @if ($memberState == 'pre-fire') <p class="card-text member-state">You are not
                                            assigned to a flower yet.</p> @endif
                                        @if ($memberState != 'pre-fire') <p class="card-text member-state">You are in
                                            <b>{{ $memberState }}</b> position.
                                            @if($requiresPayment)   <b>You haven't paid yet</b>. @endif
                                        </p> @endif

                                        @if ($memberState == 'fire')
                                            @if($requiresPayment)
                                                <a href="{{ route('payments.app') }}" class="btn btn-primary">Pay Blessing</a>
                                            @else
                                                <button type="button" class="btn btn-primary" disabled>Already paid
                                                </button>
                                            @endif
                                        @endif

                                        @if ($memberState != 'pre-fire')
                                            <a href="{{ route('flower') }}" type="button" class="btn btn-link">Open
                                                Details</a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12 home-widget mb-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5 class="card-title">Referral Program</h5>
                                        <p class="card-text">Send this link to refer someone to the app.</p>
                                        <input type="text" class="form-control"
                                               value="{{ route('register') }}?ref={{ Auth::user()->id }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
