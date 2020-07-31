@extends('layouts.app')

@section('page-title')
    SMArt {{ $image->name }} image
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl">
            <div class="card">
                <div class="card-header">You want to delete image: <b>{{ $image->name }}</b>?</div>
                <a href="{{ route('image.delete.confirmed', [$image->user, $image->id]) }}" type="button" class="btn btn-success">Yes</a>
                <a href="{{ route('image.show', [$image->user, $image->id]) }}" type="button" class="btn btn-danger">No</a>
            </div>
        </div>
    </div>
</div>
@endsection
