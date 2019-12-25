<?php

namespace App\Http\Controllers;

use App\Food;
use App\Location;
use App\LocationDetails;
use App\LocationPhotos;
use App\LocationReviews;
use Illuminate\Http\Request;

class FoodApiController extends Controller
{
    public function index()
    {
        return view('resturant_api');
    }

    public function getData(Request $request)
    {
        $lat = $request->lat;
        $lon = $request->lon;
        $input = $request->input;
//      $searchResturent = file_get_contents("https://maps.googleapis.com/maps/api/place/queryautocomplete/json?key=".env('GOOGLE_API_KEY')."&language=en&radius=10000&location=$lat,$lon&input=$input");

        $searchResturent = file_get_contents("https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=$lat,$lon&radius=5000&type=restaurant&keyword=$input&key=" . env('GOOGLE_API_KEY'));
        $searchResturent = json_decode($searchResturent, true);


        $rv = [];
        if (isset($searchResturent['results'])) {
            foreach ($searchResturent['results'] as $sku) {
                if (isset($sku['id'])) {

                    $details = file_get_contents("https://maps.googleapis.com/maps/api/place/details/json?place_id=" . $sku['place_id'] . "&key=" . env('GOOGLE_API_KEY'));
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
                    foreach ($locDetails['photos'] as $pdetails) {

                        // $images = file_get_contents("https://maps.googleapis.com/maps/api/place/photo?maxwidth=1000&photoreference=".$pdetails['photo_reference']."&key=".env('GOOGLE_API_KEY'));
                        $images = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=1000&photoreference=" . $pdetails['photo_reference'] . "&key=" . env('GOOGLE_API_KEY');
                        $rimage[] = $images;
                    }


                    //        Check this food has locations
                    $result = Food::where('food_name', $request->input)->first();

                    if (!$result) {
                        $food = Food::create([
                            'food_name' => $result->food_name
                        ]);
                        return $result;

                        $location_check = Location::where('place_id', $sku['place_id'])->first();
                        if (!$location_check) {
                            Location::create([
                                'place_id' => $sku['place_id'],
                                'food_id' => $food->id,
                                'location_id' => $sku['id'],
                            ]);

                            LocationDetails::create([
                                'place_id' => $sku['place_id'],
                                'name' => $locDetails['name'],
                                'formatted_address' => $locDetails['formatted_address'],
                                'formatted_phone_number' => $locDetails['formatted_phone_number'],
                                'international_phone_number' => $locDetails['international_phone_number'],
                                'opening_hours' => json_encode($locDetails['opening_hours']),
                                'rating' => $locDetails['rating'],
                                'user_ratings_total' => $locDetails['user_ratings_total'],

                            ]);

                            foreach ($rimage as $photo) {
                                LocationPhotos::create([
                                    'place_id' => $sku['place_id'],
                                    'photo_reference' => $photo
                                ]);
                            }

                            foreach ($locDetails['reviews'] as $review) {
                                LocationReviews::create([
                                    'place_id' => $sku['place_id'],
                                    'author_name' => $review['author_name'],
                                    'author_url' => $review['author_url'],
                                    'profile_photo_url' => $review['profile_photo_url'],
                                    'relative_time_description' => $review['relative_time_description'],
                                    'text' => $review['text']
                                ]);
                            }

                        }

                        $rv[] = array(
                            'id' => $sku['id'],
//                       'description' => $sku['description'],
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
}
