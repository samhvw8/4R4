<?php

namespace Wingi\Http\Controllers;

use Illuminate\Http\Request;
use Wingi\Entities\Room;
use Wingi\Entities\RoomAddress;
use Wingi\Http\Requests;

class RoomsController extends Controller
{

    /**
     * Get all Room
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $rooms = Room::all();

        return response()->json([
            'status' => true,
            'data' => [
                'rooms' => $rooms,
            ],
        ]);
    }

    /**
     * Create room
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
//        'user_id', 'price', 'area', 'amenity', 'room_add_id', 'image_album_url', 'bed'
//        'latitude', 'longitude', 'district', 'street', 'ward',

        $data = [
            'user_id' => $request->input('user_id'),
            'price' => $request->input('price'),
            'area' => $request->input('area'),
            'amenity' => $request->input('decripstion'),
            'image_album_url' => $request->input('image_album_url'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'district' => $request->input('district'),
            'street' => $request->input('street'),
            'ward' => $request->input('ward'),
            'bed' => $request->input('bed'),
        ];


        $room_add = new RoomAddress([
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'district' => $data['district'],
            'street' => $data['street'],
            'ward' => $data['ward']
        ]);

        $room_add->save();

        $room = new Room([
            'user_id' => $data['user_id'],
            'price' => $data['price'],
            'area' => $data['area'],
            'bed' => $data['bed'],
            'amenity' => $data['decripstion'],
            'room_add_id' => $room_add->id,
            'image_album_url' => $data['image_album_url'],
        ]);

        $room->save();

        return response()->json([
            'status' => true
        ]);
    }

    /**
     * Get room by id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($id)
    {

        $room = Room::find($id);

        // if room  not found

        if ($room == null) {
            return response()->json([
                'status' => false,
            ]);
        }

        // user room

        return response()->json([
            'status' => true,
            'data' => [
                'room' => $room,
                'room_address' => $room->address()
            ]
        ]);
    }

//    public function searchNear(Request $request)
//    {
//        $data = [
//            'minPrice' => $request->input('minPrice'),
//            'maxPrice' => $request->input('maxPrice'),
//            'minArea' => $request->input('minArea'),
//            'maxArea' => $request->input('maxArea'),
//            'curLat' => $request->input('latitude'),
//            'curLng' => $request->input('longitude'),
//            'minBed' => $request->input('minBed'),
//            'maxBed' => $request->input('maxBed'),
//            'radius' => $request->input('radius'),
//        ];
//
//        $room = Room::with('room_addresses')
//    }

//    private static function getDistance($lat1, $lng1, $lat2, $lng2, $unit = 'km')
//    {
//        // radius of earth; @note: the earth is not perfectly spherical, but this is considered the 'mean radius'
//        if ($unit == 'km') $radius = 6371.009; // in kilometers
//        elseif ($unit == 'mi') $radius = 3958.761; // in miles
//
//        // convert degrees to radians
//        $lat1 = deg2rad((float)$lat1);
//        $lng1 = deg2rad((float)$lng1);
//        $lat2 = deg2rad((float)$lat2);
//        $lng2 = deg2rad((float)$lng2);
//
//        // great circle distance formula
//        return $radius * acos(sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($lng1 - $lng2));
//    }
}
