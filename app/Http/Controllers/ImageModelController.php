<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use Illuminate\Http\Request;
use App\Models\ImageModel as Image;
use App\Models\RatingModel as Rating;
use App\Models\CommentModel as Comment;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ImageModelController extends Controller
{
    public function store($userId, $link) {
        $path = $link->store('public/images/'.$userId);
        $path = str_replace('public/', 'storage/', $path);

        return $path;
    }

    public function show(User $user, Image $image) {
        if ($image->isActive || (Auth::user() && Auth::user()->isAdmin)):
            ($image->views) ? $image->views++ : $image->views = 1;
            $image->save();
            if (Auth::user() && Auth::user()->isAdmin):
                $comments = Comment::leftjoin(DB::raw('(SELECT "id" AS "userid", "name" AS "username" FROM "users") AS "user"'), 'comments.user', '=', 'user.userid')->where('image', $image->id)->orderBy('comments.id', 'asc')->paginate(50);
            else:
                $comments = Comment::leftjoin(DB::raw('(SELECT "id" AS "userid", "name" AS "username" FROM "users") AS "user"'), 'comments.user', '=', 'user.userid')->where('image', $image->id)->where('isActive', true)->orderBy('comments.id', 'asc')->paginate(50);
            endif;
            $rated = 'cannot-rate';
            if (Auth::user()):
                $rating = Rating::where('image', $image->id)->where('user', Auth::user()->id)->get();
                $rated = $rating->isEmpty() ? 'not-rated' : $rating[0]->rating;
            endif;
            return view('images.show', ['user' => $user, 'image' => $image, 'rated' => $rated, 'rating' => ['rating' => $image->rating, 'rating-count' => $image->rating_count], 'comments' => $comments]);
        else:
            return redirect()->route('users.show', $user->id);
        endif;
    }

    public function add() {
        $categories = DB::table('categories')->where('isActive', '=', 'true')->orderBy('name','asc')->get();
        return view('images.add', ['categories' => $categories]);
    }

    public function create(ImageRequest $request) {
        $userId = Auth::user()->id;
        $image = new Image();
        if ($request->get('name')):
            $image->name = $request->get('name');
        endif;
        if ($request->file('image')):
            $link = $request->file('image');
            $path = $this->store($userId, $link);
            $image->link = $path;
        endif;
        $image->user = $userId;
        if ($request->get('category')):
            $image->category = $request->get('category');
        endif;
        $image->save();

        $newImage = Image::where('link', '=', $path)->get();

        return redirect()->route('image.show', ['user' => $userId, 'image' => $image->id]);
    }

    public function edit(User $user, Image $image) {
        if (Gate::allows('update-user', $user)):
            return view('images.edit', ['image' => $image]);
        else:
            return redirect()->route('image.show', [$user, $image]);
        endif;
    }

    public function update(Request $request) {
        $id = request()->route('image');
        $image = Image::find($id);
        $validatedData = $request->validate([
            'name' => 'required|min:2|max:120',
        ]);
        $image->name = $request->get('name');
        if ($request->get('isActive') != null):
            $image->isActive = true;
        else:
            $image->isActive = false;
        endif;
        $image->save();
        return redirect()->route('image.show', ['user' => $image->user, 'image' => $image->id]);
    }

    public function delete(User $user, Image $image) {
        if (Gate::allows('delete-user', $user)):
            return view('images.delete', ['image' => $image]);
        else:
            return redirect()->route('image.show', [$user, $image]);
        endif;
    }

    public function deleteConfirmed(User $user,Image $image) {

        $image->update(array('isActive' => false));
        return redirect()->route('users.show', $image->user);
    }
}
