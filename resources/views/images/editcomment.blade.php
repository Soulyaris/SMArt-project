@extends('layouts.app')

@section('page-title')
    SMArt comment
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Comment</div>
                <div class="card-body">
                    <form class="card-body border-bottom" id="comment-form" action="{{ route('comment.update', $comment->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="comment-field">{{ __('Update your comment here:') }}</label>

                            <div>
                                <textarea class="form-control @error('comment') is-invalid @enderror" id="comment-field" name="comment" rows="4" required>{{ $comment->comment_text }}</textarea>

                                @error('comment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
