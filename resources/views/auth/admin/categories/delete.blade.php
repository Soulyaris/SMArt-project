@extends('layouts.app')

@section('page-title')
    SMArt {{ $category->name }}
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl">
            <div class="card">
                <div class="card-header">You want to delete category: <b>{{ $category->name }}</b>?</div>
                <a href="{{ route('admin.categories.delete.confirmed', $category->id) }}" type="button" class="btn btn-success">Yes</a>
                <a href="{{ route('admin.categories.index', $category->id) }}" type="button" class="btn btn-danger">No</a>
            </div>
        </div>
    </div>
</div>
@endsection
