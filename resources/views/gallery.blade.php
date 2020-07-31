@extends('layouts.app')

@section('page-title')
    SMArt Project
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <h5 class="card-header mb-3">SMArt project gallery</h5>
            <form class="form-inline mt-2 mt-md-0 card-body pt-0 pb-0" method="POST" action="{{ route('gallery') }}">
                <div class="input-group w-100 mb-3">
                    @csrf
                    <input type="text" class="form-control" placeholder="Image name" name="name" id="name" aria-label="name" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </div>
            </form>
            <div id="image-gallery">
                <div class="grid-container">
                    @foreach ($images as $image)
                        <div>
                            <a href="{{ route('image.show', [$image->user, $image->id]) }}">
                                <img class='grid-item grid-item-{{ $loop->index + 1 }}' src='{{ $image->link }}' alt=''>
                                <p>{{ $image->name }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            {{ $images->links() }}
        </div>
    </div>
@endsection
