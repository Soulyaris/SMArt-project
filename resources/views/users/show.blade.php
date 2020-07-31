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
        <div class="my-3 p-3 bg-white rounded shadow-sm">
            <h5 class="border-bottom border-gray pb-2 mb-2">Images</h5>
            <div class="row text-center text-lg-left">
                @foreach ($images as $image)
                    <div class="col-lg-3 col-md-4 col-sm-4">
                        <a href="{{ route('image.show', ['user' => $image->user, 'image' => $image->id]) }}" class="d-block mb-4 img-thumbnail @if (!($image->isActive)) bg-dark @endif">
                            <div class="gallery-img-name rounded-top">{{ $image->name }}</div>
                            <img class="img-fluid image-resposive-height" src="{{ '/'.$image->link }}" alt="">
                        </a>
                    </div>
                @endforeach
            </div>
            {{ $images->links() }}
        </div>
    </main>
@endsection
