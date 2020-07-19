@extends('layouts.app')

@section('page-title')
    SMArt Users
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl">
            <div class="card">
                <div class="card-header">Users</div>
                    <form class="form-inline mt-2 mt-md-0" method="POST" action="{{ route('users.index') }}">
                    <div class="input-group w-100 mb-3">
                        @csrf
                        <input type="text" class="form-control" placeholder="Username" name="username" id="username" aria-label="Username" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                          <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </div>
                    </div>
                </form>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-3">
                        @foreach ($users as $user)
                            <div class="col mb-4">
                                <div class="card">
                                    <img src="..." class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $user->name }}</h5>
                                        <p class="card-text">{{ $user->email }}</p>
                                    </div>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('users.show', $user->id) }}" type="button" class="btn btn-success">View</a>
                                        @if (Auth::user()->id == $user->id || Auth::user()->isAdmin)
                                            <a href="{{ route('users.edit', $user->id) }}" type="button" class="btn btn-primary">Update</a>
                                        @endif
                                        @if (Auth::user()->isAdmin)
                                            <a href="{{ route('users.destroy', $user->id) }}" type="button" class="btn btn-danger">Delete</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
