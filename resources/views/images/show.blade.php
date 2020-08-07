@extends('layouts.app')

@section('page-title')
    SMArt image
@endsection

@section('content')
<div class="container">
    @if ($image->isActive)
        <div class="card">
    @else
        <div class="card bg-dark text-white">
    @endif
        <div class="card-body zero-bottom-padding">
          <h5 class="card-title">{{ $image->name }}</h5>
          <p class="card-text">Made by <b><a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a></b> in {{ $category }} <small>at {{ date_format($image->created_at, 'd.m.Y')}}</small></p>
          <div id="image-info-container">
            <p class="card-text"><small class="text-muted">Viewed {{ ($image->views) ? $image->views :'0' }} times, rated {{ ($rating['rating-count']) ? $rating['rating-count'] : '0'}} times, rating: {{ ($rating['rating']) ? $rating['rating'] : '0' }}</small>
                @if ($rated !== 'cannot-rate')
                    <div class="image-rating">
                        @if ($rated !== 'not-rated')
                            @for ($i = 0; $i < 5; $i++)
                                @if ($i < $rated)
                                    <div class="rating-star-rated active"></div>
                                @else
                                    <div class="rating-star-rated"></div>
                                @endif
                            @endfor
                        @else
                            <form action="{{ route('image.rate', $image->id) }}" method="POST" class="image-rating-form">
                                @csrf
                                @for ($i = 1; $i <= 5; $i++)
                                <input class="rating-star" type="radio" id="rating-mark{{$i}}" name="rating" value="{{$i}}">
                                <label for="rating-mark{{$i}}"></label>
                                @endfor
                            </form>
                        @endif
                    </div>
                @endif
            </div>
        </div>
        <a id="showModal">
            <img src="{{ Storage::disk('s3')->url($image->link) }}" class="img-fluid fit-height" alt="{{ $image->name }}">
        </a>
        @if (Auth::user())
            @if (Auth::user()->id == $user->id || Auth::user()->isAdmin)
                <div class="image-control">
                    <a class="image-control-edit" href="{{ route('image.edit', [$user->id, $image->id]) }}"></a>
                    <a class="image-control-delete" href="{{ route('image.delete', [$user->id, $image->id]) }}"></a>
                </div>
            @endif
        @endif
    </div>

    <div id="modalImage">
        <div class="modal-content">
            <button id="closeModal" class="close-modal">&times;</button>
            <img src="{{ Storage::disk('s3')->url($image->link) }}" class="img-fluid modal-image" alt="{{ $image->name }}">
        </div>
    </div>

    <div class="card">
        <div class="card-header">
          Comments
        </div>
        @if (Auth::user())
            <form class="card-body border-bottom" id="comment-form" action="{{ route('comment.create', $image->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="comment-field">{{ __('Paste your comment here:') }}</label>

                    <div>
                        <textarea class="form-control @error('comment') is-invalid @enderror" id="comment-field" name="comment" rows="4" required></textarea>

                        @error('comment')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <div>
                        <button type="submit" class="btn btn-success">
                            {{ __('Submit') }}
                        </button>
                    </div>
                </div>
            </form>
        @endif
        @foreach ($comments as $comment)
            <div class="card-body border-bottom{{ $comment->isActive ? "" : " bg-dark" }}">
                <div class="list-group">
                    <h5 class="list-group-item active bg-secondary"><a class="text-light" href={{ route("users.show", $comment->userid) }}>{{ $comment->username}}</a></h5>
                    <p class="list-group-item" data-comment-id="{{ $comment->id }}">{{ $comment->comment_text}}</p>
                    @if (Auth::user() && (Auth::user()->id === $comment->userid || Auth::user()->isAdmin))
                        <div class="image-control">
                            <a class="image-control-edit" href="{{ route('comment.edit', [$comment->id]) }}"></a>
                            <a class="image-control-delete" href="{{ route('comment.delete', [$comment->id]) }}"></a>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach

        {{ $comments->links() }}
    </div>
</div>
<script src="{{ asset('js/jquery.slim.min.js') }}"></script>
<script>
    window.addEventListener("load", function(event) {

        $( '#showModal' ).on('click', function (e) {
            e.preventDefault;
            $( '#modalImage' ).addClass('active');
        });

        $( '#closeModal' ).on('click', function (e) {
            e.preventDefault;
            $( '#modalImage' ).removeClass('active');
        });

        $( '#modalImage' ).on('click', function (e) {
            e.preventDefault;
            $( this ).removeClass('active');
        });


        var form = $( '.image-rating-form' ).first();

        form.submit(function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: form.attr('action'),
                data: form.serialize(),
                success: function(data){
                    if (data === 'error') {
                        $( '.image-rating-form' ).first().append("<div class='alert alert-danger p-1 ml-1' role='alert' style='display: inline-block'>Error ocured</div>");
                        setTimeout(function(){
                            $('.alert-danger').remove();
                        }, 1800);
                    } else {
                        $( '#image-info-container' ).html( data );
                    };
                }
            })
        });

        $( '.image-rating-form label' ).each(function () {
            $( this ).click(function () {
                var checkId = $( this ).attr('for');
                $( '#'+checkId ).first().attr('checked', true);
                form.submit();
            });

            $( this ).mouseenter(function () {
                var labelFor = $( this ).attr('for');
                var labelId = labelFor.substring(labelFor.length - 1);
                $( '.image-rating-form label' ).slice(0,labelId).addClass('active');
            });

            $( this ).mouseout(function () {
                $( '.image-rating-form label' ).each(function () {
                    $( this ).removeClass('active');
                });
            });
        });
    });
</script>
@endsection
