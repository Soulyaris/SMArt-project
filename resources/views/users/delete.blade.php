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
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="{{ route('users.delete.confirmed', $user->id) }}" type="button" class="btn btn-success">Yes</a>
                    <a href="{{ url()->previous() }}" type="button" class="btn btn-danger">No</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
