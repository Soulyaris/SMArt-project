<?php

namespace App\Http\Controllers;

use App\Models\ImageModel as Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TopsController extends Controller
{
    public function index() {
        $imageCountTop = Image::select('user', 'username', DB::raw('count(id) as "image_count"'))->leftjoin(DB::raw('(SELECT "id" AS "userid", "name" AS "username" FROM "users") AS "user"'), 'images.user', '=', 'user.userid')->groupBy('user')->groupBy('username')->orderBy('image_count', 'desc')->limit(10)->get();

        $topViewedUsers = Image::select('user', 'username', DB::raw('sum(views) as "views_count"'))->leftjoin(DB::raw('(SELECT "id" AS "userid", "name" AS "username" FROM "users") AS "user"'), 'images.user', '=', 'user.userid')->groupBy('user')->groupBy('username')->orderBy('views_count', 'desc')->limit(10)->get();

        $topRatedUsers = Image::select('user', 'username', DB::raw('sum(rating) as "rating_count"'))->leftjoin(DB::raw('(SELECT "id" AS "userid", "name" AS "username" FROM "users") AS "user"'), 'images.user', '=', 'user.userid')->groupBy('user')->groupBy('username')->orderBy('rating_count', 'desc')->limit(10)->get();

        return view('util.tops', ['imageCountTop' => $imageCountTop, 'topViewedUsers' => $topViewedUsers, 'topRatedUsers' => $topRatedUsers]);
    }
}
