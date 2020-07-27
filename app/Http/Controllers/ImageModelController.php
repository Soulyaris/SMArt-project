<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use Illuminate\Http\Request;
use App\Models\ImageModel as Image;
use App\Models\ImageModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ImageModelController extends Controller
{
    public function store($userId, $link) {
        $path = $link->store('public/images/'.$userId);
        $path = str_replace('public/', 'storage/', $path);

        return $path;
    }

    public function show($userId, $imageId) {
        $image = Image::where('id', '=', $imageId)->get()[0];
        return view('images.show', ['image' => $image]);
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
}
