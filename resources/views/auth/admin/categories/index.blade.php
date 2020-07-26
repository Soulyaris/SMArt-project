@extends('layouts.app')

@section('page-title')
    SMArt Categories
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl">
            <div class="card">
                <div class="card-header">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <h3>Categories</h3>
                        <a href="{{ route('admin.categories.add') }}" class="btn btn-success"><b>+</b> Add</a>
                    </nav>
                </div>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-1">
                        @foreach ($categories as $category)
                            <div class="col mb-4">
                                @if ($category->isActive)
                                    <div class="card">
                                @else
                                    <div class="card text-white bg-dark">
                                @endif

                                    <h5 class="card-header">{{ $category->name }}</h5>
                                    <div class="card-body">
                                      <h5 class="card-title">Number of assigned images</h5>
                                      <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary">Update</a>
                                      <a href="{{ route('admin.categories.delete', $category->id) }}" class="btn btn-danger">Delete</a>
                                    </div>
                                  </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
