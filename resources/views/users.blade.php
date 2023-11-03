@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 class="panel-title">User</h1>
                </div>

                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                    <div class="table-responsive">
                        @include('partials.searchReferrals')
                        <a href="/register" class="btn btn-success pull-right col-md-offset-1">Add New User</a>
                        <table id="referrals-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                @if($user->id !== auth()->id())
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>
                                        @if($user->status)
                                        <form method="POST" action="{{ route('users.status', ['id' => $user->id, 'action' => 'block']) }}">
                                            {{ csrf_field() }}
                                            <button type="button" data-action="Block" class="btn btn-warning confirm-action-button">Block</button>
                                        </form>
                                        @else
                                        <form method="POST" action="{{ route('users.status', ['id' => $user->id, 'action' => 'unblock']) }}">
                                            {{ csrf_field() }}
                                            <button type="button" data-action="Unblock" class="btn btn-success confirm-action-button">Unblock</button>
                                        </form>
                                        @endif

                                        <form method="POST" action="{{ route('users.delete', $user->id) }}">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="button" data-action="Delete" class="btn btn-danger confirm-action-button">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel-footer">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection