<?php

namespace App\Http\Controllers;

use App\Models\ImageModel as Image;
use App\Models\CommentModel as Comment;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
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
        $image = Image::where('id', $comment->image)->get()[0];
        return view('images.deletecomment', ['comment' => $comment, 'image' => $image]);
    }

    public function deleteConfirmed(Comment $comment) {
        $image = Image::where('id', $comment->image)->get()[0];
        $comment->isActive = false;
        $comment->save();

        return redirect()->route('image.show',[$image->user, $image->id]);
    }
}
