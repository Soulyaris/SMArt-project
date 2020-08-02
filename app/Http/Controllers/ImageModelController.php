<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Models\CategoryModel as Category;
use Illuminate\Http\Request;
use App\Models\ImageModel as Image;
use App\Models\RatingModel as Rating;
use App\Models\CommentModel as Comment;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ImageModelController extends Controller
{
    public function storeImage($userId, $link) {
        $path = $link->store('images/'.$userId, 's3');
        Storage::disk('s3')->setVisibility($path, 'public');

        return $path;
    }

    public function show(User $user, Image $image) {
        if ($image->isActive || (Auth::user() && Auth::user()->isAdmin)):
            ($image->views) ? $image->views++ : $image->views = 1;
            $image->save();

            $category = Category::where('id', $image->category)->get()[0];

            $adminCheck = (!(Auth::user() && Auth::user()->isAdmin));
            $comments = Comment::leftjoin(DB::raw('(SELECT "id" AS "userid", "name" AS "username" FROM "users") AS "user"'), 'comments.user', '=', 'user.userid')->where('image', $image->id)->when($adminCheck, function ($query, $adminCheck) {
                    return $query->where('isActive', true);
            })->orderBy('comments.id', 'asc')->paginate(50);

            $rated = 'cannot-rate';
            if (Auth::user()):
                $rating = Rating::where('image', $image->id)->where('user', Auth::user()->id)->get();
                $rated = $rating->isEmpty() ? 'not-rated' : $rating[0]->rating;
            endif;
            //$image->link = Storage::disk('s3')->get($image->link);
            return view('images.show', ['user' => $user, 'image' => $image, 'rated' => $rated, 'rating' => ['rating' => $image->rating, 'rating-count' => $image->rating_count], 'comments' => $comments, 'category' => $category->name]);
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
            $path = $this->storeImage($userId, $link);
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
            'name' => 'required|string|min:2|max:120',
        ]);
        $image->name = $request->get('name');
        if ($request->get('isActive') != null):
            if (Auth::user() && Auth::user()->isAdmin):
                $image->isActive = true;
            else:
                $image->isActive = false;
            endif;
        endif;
        $image->save();
        return redirect()->route('image.show', ['user' => $image->user, 'image' => $image->id]);
    }

    public function delete(User $user, Image $image) {
        if (Gate::allows('delete-image', $user)):
            return view('images.delete', ['image' => $image]);
        else:
            return redirect()->route('image.show', [$user, $image]);
        endif;
    }

    public function deleteConfirmed(User $user,Image $image) {

        $image->isActive = false;
        $image->save();
        return redirect()->route('users.show', $image->user);
    }
}
