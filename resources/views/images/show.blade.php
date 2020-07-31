@extends('layouts.app')

@section('page-title')
    SMArt image creation
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
          <p class="card-text">Made by <b><a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a></b></p>
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
        <img src="{{ '/'.$image->link }}" class="img-fluid fit-height" alt="{{ $image->name }}">
        @if (Auth::user())
            @if (Auth::user()->id == $user->id || Auth::user()->isAdmin)
                <div class="image-control">
                    <a class="image-control-edit" href="{{ route('image.edit', [$user->id, $image->id]) }}"></a>
                    <a class="image-control-delete" href="{{ route('image.delete', [$user->id, $image->id]) }}"></a>
                </div>
            @endif
        @endif
    </div>
    <div class="card">
        <div class="card-header">
          Featured
        </div>
        <div class="card-body">
          <h5 class="card-title">Special title treatment</h5>
          <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
          <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
    </div>
</div>
<script src="{{ asset('js/jquery.slim.min.js') }}"></script>
<script>
    window.addEventListener("load", function(event) {

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
                    console.log(data);
                    $( '#image-info-container' ).html( data );
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
