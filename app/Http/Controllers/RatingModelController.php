<?php

namespace App\Http\Controllers;

use App\Models\ImageModel as Image;
use App\Models\RatingModel as Rating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RatingModelController extends Controller
{
    public function rate(Image $image, Request $request) {
        $rating = new Rating();
        $rating->user = Auth::user()->id;
        $rating->image = $image->id;
        $rating->rating = $request->rating;
        $saved = $rating->save();

        if (!($saved)):
            echo "error";
        endif;

        $image->rating = $image->rating ? $image->rating + $request->rating : $request->rating;
        $image->rating_count = $image->rating_count ? $image->rating_count + 1 : 1;
        $saved = $image->save();

        if (!($saved)):
            echo "error";
        endif;

        $output = '<p class="card-text"><small class="text-muted">Viewed '.$image->views.' times, rated '.$image->rating_count.' times, rating: '.$image->rating.'</small><div class="image-rating">';
        for ($i = 0; $i < 5; $i++):
            if ($i < $request->rating):
                $output .= '<div class="rating-star-rated active"></div> ';
            else:
                $output .= '<div class="rating-star-rated"></div> ';
            endif;
        endfor;
        $output .= '</div>';
        echo $output;
    }
}
