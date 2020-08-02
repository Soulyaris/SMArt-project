@extends('layouts.app')

@section('page-title')
    SMArt Project
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <h5 class="card-header mb-3">SMArt project gallery</h5>
            <form class="form-inline mt-2 mt-md-0 card-body pt-0 pb-0" method="POST" action="{{ route('gallery') }}" id="gallery-filter-form">
                <div class="input-group w-100 mb-3">
                    @csrf
                    <div class="input-group-prepend">
                        <button id="filter-openner" class="btn btn-outline-primary" type="button">Filter</button>
                    </div>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Image name" name="name" id="name" aria-label="name" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div id='gallery-filter' class='container border border-top-0 rounded'>
                    <h5>Filter</h5>
                    <div class="filter-group border rounded mb-2" id="show-last">
                        <div class="filter-group-header bg-secondary">By date</div>
                        <div class="filter-group-body">
                            <input class="" type="radio" id="show-last-day" name="showlast" value="day">
                            <label for="show-last-day">Show last day</label>
                            <input class="" type="radio" id="show-last-week" name="showlast" value="week">
                            <label for="show-last-week">Show last week</label>
                            <input class="" type="radio" id="show-last-month" name="showlast" value="month">
                            <label for="show-last-month">Show last month</label>
                            <input class="" type="radio" id="show-last-year" name="showlast" value="year">
                            <label for="show-last-year">Show last year</label>
                        </div>
                    </div>
                    <div class='filter-group border rounded mb-2' id='sort-row'>
                        <div class="filter-group-header bg-secondary">Sort type</div>
                        <div class="filter-group-body">
                            <input type="checkbox" name="sortmethod" id="sortmethod">
                            <label for="sortmethod">Sort by date</label>
                        </div>
                    </div>
                    <div class="filter-group border rounded mb-2" id="category">
                        <div class="filter-group-header bg-secondary">By category</div>
                        <div class="filter-group-body">
                            @foreach ($categories as $category)
                                <input class="" type="radio" id="category{{ $category->id }}" name="category" value="{{ $category->id}}">
                                <label for="category{{ $category->id }}">{{ $category->name }}</label>
                            @endforeach
                        </div>
                    </div>
                    <div class="filter-group input-group w-100">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Filter') }}
                        </button>
                        <a class="btn btn-primary" href="{{ route('gallery') }}">Clear</a>
                    </div>
                </div>
            </form>
            <div id="image-gallery">
                <div class="grid-container">
                    @foreach ($images as $image)
                        <div>
                            <a href="{{ route('image.show', [$image->user, $image->id]) }}">
                                <img class='grid-item grid-item-{{ $loop->index + 1 }}' src='{{ Storage::disk('s3')->url($image->link) }}' alt=''>
                                <p>{{ $image->name }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            {{ $images->links() }}
        </div>
    </div>
    <script>
        window.addEventListener("DOMContentLoaded", function(event) {
            var filterBtn = $( '#filter-openner' ).first();
            var galleryFilter = $( '#gallery-filter' ).first();

            filterBtn.on('click', function (e) {
                e.preventDefault();

                filterBtn.toggleClass('active');
                galleryFilter.toggleClass('active');
            });

        });
    </script>
@endsection
