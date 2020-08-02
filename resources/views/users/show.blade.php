@extends('layouts.app')

@section('page-title')
    SMArt {{ $user->name }}
@endsection

@section('content')
    <main role="main" class="container">
        <div class="d-flex align-items-center p-3 my-3
            @if ($user->isActive)
                text-dark bg-light
            @else
                text-white bg-dark
            @endif
            rounded shadow-sm position-relative">
            <div class="bg-light rounded mr-3">
                @if (Storage::disk('s3')->exists($user->avatar))
                    <img class="mr-3" src="{{ Storage::disk('s3')->url($user->avatar) }}" alt="" width="60">
                @else
                    <img class="mr-3" src="{{ '/images/default-avatar.jpg' }}" alt="" width="60">
                @endif
            </div>
            <div class="lh-100">
              <h6 class="mb-0 lh-100"><big>{{ $user->name }}</big> <small>registered at {{ date_format($user->created_at, 'd.m.Y') }}</small></h6>
            </div>
            @if (Auth::user())
                @if (Auth::user()->id == $user->id || Auth::user()->isAdmin)
                    <div class="image-control">
                        <a class="image-control-edit" href="{{ route('users.edit', [$user->id]) }}"></a>
                        @if (Auth::user()->isAdmin)
                            <a class="image-control-delete" href="{{ route('users.delete', [$user->id]) }}"></a>
                        @endif
                    </div>
                @endif
            @endif
        </div>
        <div class="card">
            <h5 class="card-header mb-3">Images</h5>
            <div id="image-gallery">
                <div class="grid-container">
                    @foreach ($images as $image)
                        <div {{ $image->isActive ? '' : 'class=bg-dark' }}>
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
    </main>
@endsection
