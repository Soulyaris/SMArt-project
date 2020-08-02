<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel as Category;
use App\Models\ImageModel as Image;
use DateTime;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request) {

        $validatedData = $request->validate([
            'name' => 'nullable|string|min:2|max:120',
            'category' => 'nullable|integer',
            'showlast' => 'nullable|string',
        ]);

        $categories = Category::where('isActive', true)->orderBy('name', 'asc')->get();

        $images = Image::where('isActive', true)->when($request->name, function ($query, $requestName) {
            if ($requestName):
                return $query->where('name', 'ILIKE', '%'.$requestName.'%');
            endif;
        })->when($request->showlast, function ($query, $showLast) {
            $currentDate = new DateTime();
            $previousDate = new DateTime();
            switch ($showLast):
                case "day":
                    $previousDate->modify('-1 day'); break;
                case "week":
                    $previousDate->modify('-1 week'); break;
                case "month":
                    $previousDate->modify('-1 month'); break;
                case "year":
                    $previousDate->modify('-1 year'); break;
            endswitch;
            return $query->whereBetween('created_at', [$previousDate->format('Y-m-d H:i:s'), $currentDate->format('Y-m-d H:i:s')]);
        })->when($request->category, function ($query, $requestCategory) {
            if ($requestCategory):
                return $query->where('category', $requestCategory);
            endif;
        })->orderBy('created_at', $request->sortmethod ? "desc" : "asc")->paginate(50);
        return view('gallery', ['images' => $images, 'categories' => $categories]);
    }
}
