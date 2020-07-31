<?php

namespace App\Http\Controllers;

use App\Models\ImageModel as Image;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request) {

        $validatedData = $request->validate([
            'name' => 'string|min:1',
        ]);


        $images = Image::where('isActive', true)->when($request->name, function ($query, $requestName) {
            if ($requestName):
                return $query->where('name', 'ILIKE', '%'.$requestName.'%');
            endif;
        })->paginate(50);
        return view('gallery', ['images' => $images]);
    }
}
