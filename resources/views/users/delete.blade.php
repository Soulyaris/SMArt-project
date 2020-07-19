@extends('layouts.app')

@section('page-title')
    SMArt {{ $user->name }}
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl">
            <div class="card">
                <div class="card-header">You want to delete user: <b>{{ $user->name }}</b>?</div>
                <a href="{{ route('users.delete.confirmed', $user->id) }}" type="button" class="btn btn-success">Yes</a>
                    @if (Auth::user()->isAdmin)
                        <a href="{{ route('users.show', $user->id) }}" type="button" class="btn btn-danger">No</a>
                    @endif
            </div>
        </div>
    </div>
</div>
@endsection
