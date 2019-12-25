<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FoodApiController extends Controller
{
    public function index(){
        return view('resturant_api');
    }

    public function getData(Request $request){
        $lat = $request->lat;
        $lon = $request->lon;
        $input = $request->input;
//        $searchResturent = file_get_contents("https://maps.googleapis.com/maps/api/place/queryautocomplete/json?key=".env('GOOGLE_API_KEY')."&language=en&radius=10000&location=$lat,$lon&input=$input");
        $searchResturent = file_get_contents("https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=$lat,$lon&radius=5000&type=restaurant&keyword=$input&key=".env('GOOGLE_API_KEY'));
        $searchResturent = json_decode($searchResturent, true);

        $rv = [];
        if(isset($searchResturent['results'])){
            foreach ($searchResturent['results'] as $sku) {
                if(isset($sku['id'])){

                    $details = file_get_contents("https://maps.googleapis.com/maps/api/place/details/json?place_id=".$sku['place_id']."&key=".env('GOOGLE_API_KEY'));
                    $details = json_decode($details, true);

                    $locDetails = array(
                        'formatted_address' => isset($details['result']['formatted_address']) ? $details['result']['formatted_address'] : '',
                        'formatted_phone_number' => isset($details['result']['formatted_phone_number']) ? $details['result']['formatted_phone_number'] : '',
                        'international_phone_number' => isset($details['result']['international_phone_number']) ? $details['result']['international_phone_number'] : '',
                        'name' => isset($details['result']['name']) ? $details['result']['name'] : '',
                        'opening_hours' => isset($details['result']['opening_hours']['weekday_text']) ? $details['result']['opening_hours']['weekday_text'] : [],
                        'photos' => isset($details['result']['photos']) ? $details['result']['photos'] : [],
                        'rating' => isset($details['result']['rating']) ? $details['result']['rating'] : 0,
                        'user_ratings_total' => isset($details['result']['user_ratings_total']) ? $details['result']['user_ratings_total'] : 0,
                        'reviews' => isset($details['result']['reviews']) ? $details['result']['reviews'] : [],
                    );

                    $rimage = [];
                    foreach($locDetails['photos'] as $pdetails){

                        // $images = file_get_contents("https://maps.googleapis.com/maps/api/place/photo?maxwidth=1000&photoreference=".$pdetails['photo_reference']."&key=".env('GOOGLE_API_KEY'));
                        $images = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=1000&photoreference=".$pdetails['photo_reference']."&key=".env('GOOGLE_API_KEY');
                        $rimage[] = $images;
                    }

                    $rv[] = array(
                        'id' => $sku['id'],
//                        'description' => $sku['description'],
                        'place_id' => $sku['place_id'],
                        'details' => $locDetails,
                        'storePhotos' => $rimage,

                    );
                }
            }
        }

        return response()->json(['locations' => $rv], 200);
    }

}
