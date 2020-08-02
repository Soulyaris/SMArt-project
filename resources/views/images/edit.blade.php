@extends('layouts.app')

@section('page-title')
    SMArt {{ $image->name }} image
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Image: <b>{{ $image->name }}</b></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('image.update', [$image->user, $image->id]) }}" enctype="multipart/form-data"
                    >
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $image->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @if (Auth::user()->isAdmin)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="isActive" name="isActive" @if ($image->isActive) checked @endif>
                                <label class="form-check-label" for="isActive">image is active</label>
                            </div>
                        @endif

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                                <a class="btn btn-primary" href="{{ url()->previous() }}">Get back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
