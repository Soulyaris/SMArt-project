<?php

namespace App\Http\Controllers;

use App\Models\ImageModel as Image;
use App\Models\CommentModel as Comment;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class CommentModelController extends Controller
{
    public function create(Image $image, CommentRequest $request) {
        $comment = new Comment;
        if ($request->comment) {
            $comment->image = $image->id;
            $comment->user = Auth::user()->id;
            $comment->comment_text = $request->comment;
            $comment->save();
        }

        return redirect()->route('image.show',[$image->user, $image->id]);
    }

    public function edit(Comment $comment) {
        if (Gate::denies('update-comment', $comment->user)):
            return redirect()->route('gallery');
        endif;

        return view('images.editcomment', ['comment' => $comment]);
    }

    public function update(Comment $comment, CommentRequest $request) {
        if ($request->comment) {
            $comment->comment_text = $request->comment;
            $comment->save();
        }
        $image = Image::where('id', $comment->image)->get()[0];
        return redirect()->route('image.show',[$image->user, $image->id]);
    }

    public function delete(Comment $comment) {
        if (Gate::denies('update-comment', $comment->user)):
            return redirect()->route('gallery');
        endif;

        $image = Image::where('id', $comment->image)->get()[0];
        return view('images.deletecomment', ['comment' => $comment, 'image' => $image]);

    }

    public function deleteConfirmed(Comment $comment) {
        if (Gate::denies('update-comment', $comment->user)):
            return redirect()->route('gallery');
        endif;

        $image = Image::where('id', $comment->image)->get()[0];
        $comment->isActive = false;
        $comment->save();

        return redirect()->route('image.show',[$image->user, $image->id]);

    }
}
