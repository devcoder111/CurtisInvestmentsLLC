@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Maintenance</div>

        <div class="card-body">
            <p>Warning, entering into maintenance mode will block access to all users except for admins.</p>

            <form action="{{ route('admin.maintenance.toggle') }}" method="POST">
                @csrf

                <button type="submit" class="btn btn-{{ $maintenance ? 'primary' : 'danger' }} btn-lg">Turn {{ $maintenance ? 'OFF' : 'ON' }}</button>
            </form>
        </div>
    </div>
@endsection
