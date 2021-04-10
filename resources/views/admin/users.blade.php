@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Manage Users</div>

        <div class="card-body">
            <table class="table table-bordered mb-5">
                <thead>
                <tr class="table-active">
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Wallet</th>
                    <th scope="col">Role</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->wallet }}</td>
                        <td>{{ $user->friendlyRole }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-right">
                {!! $users->links() !!}
            </div>
        </div>
    </div>
@endsection
