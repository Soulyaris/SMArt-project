@extends('layouts.app')

@section('page-title')
    SMArt comment
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl">
            <div class="card">
                <div class="card-header">You want to delete comment?</div>
                <div class="jumbotron">{{ $comment->comment_text }}</div>
                <a href="{{ route('comment.delete.confirmed', [$comment->id]) }}" type="button" class="btn btn-success">Yes</a>
                <a href="{{ route('image.show', [$image->user, $image->id]) }}" type="button" class="btn btn-danger">No</a>
            </div>
        </div>
    </div>
</div>
@endsection
