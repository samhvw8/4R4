<?php

namespace r4r\Http\Controllers\Api\v1;

use Illuminate\Http\Request as Request;
use r4r\Entities\Room as Room;
use r4r\Entities\User as User;
use r4r\Http\Controllers\Controller as Controller;


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
                'total' => $rooms->count(),
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
//            'user_id' => $request->input('user_id'),
            'price' => $request->input('price'),
            'area' => $request->input('area'),
            'decripstion' => $request->input('decripstion'),
            'image_album_url' => $request->input('image_album_url'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'district' => $request->input('district'),
            'street' => $request->input('street'),
            'ward' => $request->input('ward'),
            'city' => $request->input('city'),
        ];

        $user = User::find($request->input('user_id'));


        if (!$user) {
            return response()->json([
                'status' => false,
                'data' => [
                    'msg' => 'user id not found'
                ]
            ]);
        }

        $room = new Room($data);

        try {
            $user->rooms()->save($room);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status' => false,
                'data' => [
                    'code' => $e->getCode(),
                    'msg' => $e->errorInfo[2]
                ]
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'room' => $room
            ]
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
                'data' => [
                    'msg' => 'room id not found'
                ]
            ]);
        }

        // user room

        return response()->json([
            'status' => true,
            'data' => [
                'room' => $room,
            ]
        ]);
    }

    /**
     * Update Room by ID
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $room = Room::find($id);

        // if room not found

        if ($room == null) {
            return response()->json([
                'status' => false,
                'data' => [
                    'msg' => 'room id not found'
                ]
            ]);
        }

        $data = [
//           'user_id' => $request->input('user_id'),
            'price' => $request->input('price'),
            'area' => $request->input('area'),
            'decripstion' => $request->input('decripstion'),
            'image_album_url' => $request->input('image_album_url'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'district' => $request->input('district'),
            'street' => $request->input('street'),
            'ward' => $request->input('ward'),
            'city' => $request->input('city'),
        ];

        if ($room['user_id'] != $request->input('user_id')) {
            $user = User::find($request->input('user_id'));

            try {
                $user->rooms()->save($room)->save();
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json([
                    'status' => false,
                    'data' => [
                        'code' => $e->getCode(),
                        'msg' => $e->errorInfo[2]
                    ]
                ]);
            }
        }

        try {
            $room->update($data);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status' => false,
                'data' => [
                    'code' => $e->getCode(),
                    'msg' => $e->errorInfo[2]
                ]
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => [
                room => $room
            ]
        ]);
    }

    /**
     * Delete room by ID
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $room = Room::find($id);

        // if room not found

        if ($room == null) {
            return response()->json([
                'status' => false,
                'data' => [
                    'msg' => 'room id not found'
                ]
            ]);
        }

        try {
            $room->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status' => false,
                'data' => [
                    'code' => $e->getCode(),
                    'msg' => $e->errorInfo[2]
                ]
            ]);
        }


        // delete success
        return response()->json([
            'status' => true,
        ]);
    }

    /**
     * Search rooms nearby
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchNear(Request $request)
    {
        $data = [
            'minPrice' => $request->input('minPrice'),
            'maxPrice' => $request->input('maxPrice'),
            'minArea' => $request->input('minArea'),
            'maxArea' => $request->input('maxArea'),
            'curLat' => $request->input('latitude'),
            'curLng' => $request->input('longitude'),
            'radius' => $request->input('radius'),
            'limit' => $request->input('limit'),
        ];

        $rooms = Room::all();
        //Room::chunk(500, functioncallback());
        $returnRooms = [];
        $returnRoomsNumber = 0;
        foreach ($rooms as $room) {
            $lat = $room['latitude'];
            $lng = $room['longitude'];
            $distance = 6371 * acos(sin($data['curLat']) * sin($lat) + cos($data['curLat']) * cos($lat) * cos($data['curLng'] - $lng));
            if ($distance <= $data['radius']) {
                if (($room['area'] >= $data['minArea']) && ($room['area'] <= $data['maxArea'])) {
                    if (($room['price'] >= $data['minPrice']) && ($room['price'] <= $data['maxPrice'])) {
                        array_push($returnRooms, $room);
                        $returnRoomsNumber += 1;
                    }
                }
            }
            if ($returnRoomsNumber > $data['limit'])
                break;
        }
        //        if ($unit == 'km') $radius = 6371.009; // in kilometers
//        elseif ($unit == 'mi') $radius = 3958.761; // in miles
        //return $radius * acos(sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($lng1 - $lng2));

        return response()->json([
            'status' => true,
            'data' => [
                'total' => $returnRoomsNumber,
                'room' => $returnRooms
            ]
        ]);
    }

    /**
     * return list of rooms has address like input
     * @param Request $request
     * @return mixed
     */
    public function searchAddress(Request $request)
    {
        $datas = [
            'district' => $request->input('district'),
            'street' => $request->input('street'),
            'ward' => $request->input('ward'),
            'city' => $request->input('city'),
        ];

        $datas = array_filter($datas, function ($var) {
            if ($var == NULL || $var == "")
                return false;
            return true;
        });

        $room = [];
        $flag = 0;
        foreach ($datas as $key => $value) {
            if ($flag == 0) {
                $room = Room::where($key, 'LIKE', $value);
                $flag = 1;
            } else {
                $room = $room->where($key, 'LIKE', $value);
            }
        }

        $room = $room->get();

        return response()->json([
            'status' => true,
            'data' => [
                'total' => $room->count(),
                'room' => $room
            ]
        ]);
    }

    public function updateAdress()
    {
        $rooms = Room::all();

        foreach ($rooms as $room) {
            if ($room['latitude'] != null && $room['latitude'] != '')
                continue;
            $address = implode(' ', [$room['street'], $room['district'], $room['ward'], $room['city']]);
            $address = urlencode($address);
            $url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";

            $response = file_get_contents($url);

            $output = json_decode($response);

            $latitude = $output->results[0]->geometry->location->lat;
            $longitude = $output->results[0]->geometry->location->lng;

            $room['latitude'] = $latitude;
            $room['longitude'] = $longitude;
            $room->save();

        }
        echo "Done Update address";
    }
}
