@extends('layouts.app')

@section('page-title')
    SMArt {{ $user->name }}
@endsection

@section('content')
    <main role="main" class="container">
        <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-secondary rounded shadow-sm">
            <div class="bg-light rounded mr-3">
                @if (file_exists($user->avatar))
                    <img class="mr-3" src="{{ '/'.$user->avatar }}" alt="" width="60">
                @else
                    <img class="mr-3" src="{{ '/images/default-avatar.jpg' }}" alt="" width="60">
                @endif
            </div>
            <div class="lh-100">
              <h6 class="mb-0 text-white lh-100">{{ $user->name }}</h6>
            </div>
        </div>
        <div class="card">
            <h5 class="card-header mb-3">Images</h5>
            <div id="image-gallery">
                <div class="grid-container">
                    @foreach ($images as $image)
                        <div>
                            <a href="{{ route('image.show', [$image->user, $image->id]) }}">
                                <img class='grid-item grid-item-{{ $loop->index + 1 }}' src='{{ '/'.$image->link }}' alt=''>
                                <p>{{ $image->name }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            {{ $images->links() }}
        </div>
    </main>
@endsection
