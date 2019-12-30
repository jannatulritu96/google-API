<?php

namespace App\Http\Controllers;

use App\Location;
use App\LocationDetail;
use App\LocationPhoto;
use App\LocationReview;
use Illuminate\Http\Request;

class FoodApiController extends Controller
{
    public function index(Request $request)
    {
        return view('resturant_api');
    }

    public function getData(Request $request)
    {
        $request->validate([
            'lat'=>'required',
            'lng'=>'required',
            'input' => 'required'
        ]);
        $lat = $request->lat;
        $lng = $request->lng;
        $input = $request->input;


//      $searchResturent = file_get_contents("https://maps.googleapis.com/maps/api/place/queryautocomplete/json?key=".env('GOOGLE_API_KEY')."&language=en&radius=10000&location=$lat,$lon&input=$input");

        $searchResturent = file_get_contents("https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=$lat,$lng&radius=5000&type=restaurant&keyword=$input&key=" . env('GOOGLE_API_KEY'));
        $searchResturent = json_decode($searchResturent, true);
        $rv = [];

        if (isset($searchResturent['results'])) {
            foreach ($searchResturent['results'] as $sku) {
                if (isset($sku['id'])) {
                   $details = file_get_contents("https://maps.googleapis.com/maps/api/place/details/json?place_id=" . $sku['place_id'] . "&key=" . env('GOOGLE_API_KEY'));
                    $details = json_decode($details, true);
                    $locDetails = array(
                        'formatted_address' => isset($details['formatted_address']) ? $details['formatted_address'] : '',
                        'formatted_phone_number' => isset($details['formatted_phone_number']) ? $details['formatted_phone_number'] : '',
                        'international_phone_number' => isset($details['international_phone_number']) ? $details['international_phone_number'] : '',
                        'name' => isset($details['name']) ? $details['name'] : '',
                        'opening_hours' => isset($details['opening_hours']['weekday_text']) ? $details['opening_hours']['weekday_text'] : [],
                        'photos' => isset($details['photos']) ? $details['photos'] : [],
                        'rating' => isset($details['rating']) ? $details['rating'] : 0,
                        'user_ratings_total' => isset($details['user_ratings_total']) ? $details['user_ratings_total'] : 0,
                        'reviews' => isset($details['reviews']) ? $details['reviews'] : [],
                    );

                    $rimage = [];
                    foreach ($locDetails['photos'] as $pdetails) {

                        // $images = file_get_contents("https://maps.googleapis.com/maps/api/place/photo?maxwidth=1000&photoreference=".$pdetails['photo_reference']."&key=".env('GOOGLE_API_KEY'));
                        $images = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=1000&photoreference=" . $pdetails['photo_reference'] . "&key=" . env('GOOGLE_API_KEY');
                        $rimage[] = $images;
                    }
                         $location_check = Location::where('place_id', $sku['place_id'])->first();
                        if (!$location_check && $sku['place_id'] !==null) {
                            Location::create([
                                'place_id' => $sku['place_id'],
                                'location_id' => $sku['id'],
                                'lat'=> $sku['geometry']['location']['lat'],
                                'lng'=>  $sku['geometry']['location']['lng'],

                            ]);

                            LocationDetail::create([
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
                                LocationPhoto::create([
                                    'place_id' => $sku['place_id'],
                                    'photo_reference' => $photo
                                ]);
                            }

                            foreach ($locDetails['reviews'] as $review) {
                                LocationReview::create([
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
                            'place_id' => $sku['place_id'],
                            'details' => $locDetails,
                            'storePhotos' => $rimage,
                        );
                    }
                }
            }
//        print_r($rv);
            return response()->json(['locations' => $rv], 200);
        }


        public function searchFromDatabase(Request $request){
            $request->validate([
                'lat'=>'required',
                'lng'=>'required',
                'input' => 'required'
            ]);
            $lat = $request->lat;
            $lng = $request->lng;
            $input = $request->input;


            // \DB::raw("id,
            //           ( 6371 * acos( cos( radians($lat) ) *
            //             cos( radians( lat ) )
            //             * cos( radians( lng ) - radians($lng)
            //             ) + sin( radians($lat) ) *
            //             sin( radians( lat ) ) )
            //           ) AS distance"))

//            $haversine = "(6371 * acos(cos(radians($lat)) * cos(radians(lat)) * cos(radians(lng) - radians($lng)) + sin(radians($lat)) * sin(radians(lat))))";

            $data = Location::select(
                \DB::raw("id, place_id, location_id,
                          ( 6371 * acos( cos( radians($lat) ) *
                            cos( radians( lat ) )
                            * cos( radians( lng ) - radians($lng)
                            ) + sin( radians($lat) ) *
                            sin( radians( lat ) ) )
                          ) AS distance"))
                ->orderBy('id', 'desc')
                ->get()->toArray();


//                $properties = DB::select("SELECT id,OwnerId, IDX_Address, Y_DD, X_DD,image, ( 6371 * acos( cos( radians($origLat) ) * cos( radians( Y_DD ) ) * cos( radians( X_DD ) - radians($origLon) ) + sin( radians($origLat) ) * sin(radians(Y_DD)) ) ) AS distance  FROM  properties  HAVING     distance < 1500 ORDER BY  distance LIMIT 0,30");



            $rv = [];
            foreach ($data as $sku) {
//                return $sku;
                if (isset($sku['location_id'])) {
//                    $details = file_get_contents("https://maps.googleapis.com/maps/api/place/details/json?place_id=" . $sku['place_id'] . "&key=" . env('GOOGLE_API_KEY'));
//                    $details = json_decode($details, true);
                    $details = LocationDetail::where('place_id',$sku['place_id'])->first()->toArray();
                    //     dump($details);
                    //     return "https://maps.googleapis.com/maps/api/place/details/json?place_id=" . $sku['place_id'] . "&key=" . env('GOOGLE_API_KEY');
                    $photo = LocationPhoto::where('place_id',$sku['place_id'])->get()->toArray();
                    $reviews = LocationReview::where('place_id',$sku['place_id'])->get()->toArray();
                    $locDetails = array(
                        'formatted_address' => isset($details['formatted_address']) ? $details['formatted_address'] : '',
                        'formatted_phone_number' => isset($details['formatted_phone_number']) ? $details['formatted_phone_number'] : '',
                        'international_phone_number' => isset($details['international_phone_number']) ? $details['international_phone_number'] : '',
                        'name' => isset($details['name']) ? $details['name'] : '',
//                        'opening_hours' => isset($details['opening_hours']) ? $details['opening_hours']['weekday_text'] : [],
                        'photos' => $photo,  //isset($details['photos']) ? $details['photos'] : [],
                        'rating' => isset($details['rating']) ? $details['rating'] : 0,
                        'user_ratings_total' => isset($details['user_ratings_total']) ? $details['user_ratings_total'] : 0,
                        'reviews' => $reviews, //isset($details['reviews']) ? $details['reviews'] : [],
                    );

                    $rimage = [];
                    foreach ($locDetails['photos'] as $pdetails) {

                        // $images = file_get_contents("https://maps.googleapis.com/maps/api/place/photo?maxwidth=1000&photoreference=".$pdetails['photo_reference']."&key=".env('GOOGLE_API_KEY'));
                        $images = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=1000&photoreference=" . $pdetails['photo_reference'] . "&key=" . env('GOOGLE_API_KEY');
                        $rimage[] = $images;
                    }
//                    $location_check = Location::where('place_id', $sku['place_id'])->first();
//                    if (!$location_check && $sku['place_id'] !==null) {
//                        Location::create([
//                            'place_id' => $sku['place_id'],
//                            'location_id' => $sku['id'],
//                            'lat'=> $sku['geometry']['location']['lat'],
//                            'lng'=>  $sku['geometry']['location']['lng'],
//
//                        ]);
//
//                        LocationDetail::create([
//                            'place_id' => $sku['place_id'],
//                            'name' => $locDetails['name'],
//                            'formatted_address' => $locDetails['formatted_address'],
//                            'formatted_phone_number' => $locDetails['formatted_phone_number'],
//                            'international_phone_number' => $locDetails['international_phone_number'],
//                            'opening_hours' => json_encode($locDetails['opening_hours']),
//                            'rating' => $locDetails['rating'],
//                            'user_ratings_total' => $locDetails['user_ratings_total'],
//
//                        ]);
//
//                        foreach ($rimage as $photo) {
//                            LocationPhoto::create([
//                                'place_id' => $sku['place_id'],
//                                'photo_reference' => $photo
//                            ]);
//                        }
//
//                        foreach ($locDetails['reviews'] as $review) {
//                            LocationReview::create([
//                                'place_id' => $sku['place_id'],
//                                'author_name' => $review['author_name'],
//                                'author_url' => $review['author_url'],
//                                'profile_photo_url' => $review['profile_photo_url'],
//                                'relative_time_description' => $review['relative_time_description'],
//                                'text' => $review['text']
//                            ]);
//                        }
//
//                    }

                    $rv[] = array(
                        'id' => $sku['id'],
                        'place_id' => $sku['place_id'],
                        'details' => $locDetails,
                        'storePhotos' => $rimage,
                    );
                }
            }

//            dd($rv);

//            $add = explode(',',$request->formatted_address);
//            return $data = Location::with(['relLocationDetail'])->get();
//            $databaseSearch = new LocationDetail();
//            foreach ($add as $key => $address){
//                $databaseSearch = $databaseSearch->where('formatted_address', 'like', "%".$address."%");
//            }
//            $databaseSearch =  $databaseSearch->get();
            return response()->json(['success' => true, 'searchDatabase' => $rv]);
        }

    }

