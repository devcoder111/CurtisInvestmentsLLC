@extends('layouts.guest')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Contact</div>

                    <div class="card-body">
                        <!-- Success message -->
                        @if(Session::has('success'))
                            <div class="alert alert-success">
                                {{Session::get('success')}}
                            </div>
                        @endif

                        <form action="{{ route('contact.process') }}" method="post">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control {{ $errors->has('name') ? 'error' : '' }}" name="name" id="name">
                                    <!-- Error -->
                                    @if ($errors->has('name'))
                                        <div class="error">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Email</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control {{ $errors->has('email') ? 'error' : '' }}" name="email" id="email">

                                    @if ($errors->has('email'))
                                        <div class="error">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Subject</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control {{ $errors->has('subject') ? 'error' : '' }}" name="subject"
                                           id="subject">

                                    @if ($errors->has('subject'))
                                        <div class="error">
                                            {{ $errors->first('subject') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Message</label>
                                <div class="col-md-6">
                                    <textarea class="form-control {{ $errors->has('message') ? 'error' : '' }}" name="message" id="message"
                                              rows="4"></textarea>

                                    @if ($errors->has('message'))
                                        <div class="error">
                                            {{ $errors->first('message') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>

    </script>
@endpush
