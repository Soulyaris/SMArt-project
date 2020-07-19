@extends('layouts.app')

@section('page-title')
    SMArt {{ $user->name }}
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl">
            <div class="card">
                <div class="card-header">{{ $user->name }}</div>

            </div>
        </div>
    </div>
</div>
@endsection
