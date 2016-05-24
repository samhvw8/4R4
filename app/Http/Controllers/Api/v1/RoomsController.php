<?php

namespace r4r\Http\Controllers\Api\v1;

use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Input;
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
        $limit = Input::get('limit') ?: 10;
        $rooms = Room::orderBy('created_at', 'desc')->paginate($limit);

        return response()->json([
            'status' => true,
            'data' => [
                'total_count' => $rooms->total(),
                'total_pages' => $rooms->lastPage(),
                'current_page' => $rooms->currentPage(),
                'per_page' => $rooms->perPage(),
                'url_next' => $rooms->nextPageUrl(),
                'url_prev' => $rooms->previousPageUrl(),
                'rooms' => $rooms->items(),
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
            'price' => $request->input('price'),
            'area' => $request->input('area'),
            'description' => $request->input('description'),
            'image_album_url' => $request->input('image_album_url'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'district' => $request->input('district'),
            'street' => $request->input('street'),
            'ward' => $request->input('ward'),
            'city' => $request->input('city'),
        ];

        $user = \Auth::user();


        if (!$user) {
            return response()->json([
                'status' => false,
                'data' => [
                    'msg' => 'user id not found'
                ]
            ], 404);
        }

        $room = new Room($data);

        $address = implode(' ', [$room['street'], $room['district'], $room['ward'], $room['city']]);
        $address = urlencode($address);
        $url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";

        $response = file_get_contents($url);

        $output = json_decode($response);
        if($output->status != "ZERO_RESULTS") {
            $latitude = $output->results[0]->geometry->location->lat;
            $longitude = $output->results[0]->geometry->location->lng;

            $room['latitude'] = $latitude;
            $room['longitude'] = $longitude;
        }
        try {
            $user->rooms()->save($room);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status' => false,
                'data' => [
                    'code' => $e->getCode(),
                    'msg' => $e->errorInfo[2]
                ]
            ], 500);
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
            ], 404);
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


        if (\Auth::user()->isAdmin() != true  && \Auth::user()->id != $room->user_id) {

            return response()->json([
                'status' => false,
                'data' => [
                    'msg' => 'Don\'t have permisson'
                ]
            ], 403);
        }

        // if room not found

        if ($room == null) {
            return response()->json([
                'status' => false,
                'data' => [
                    'msg' => 'room id not found'
                ]
            ], 404);
        }

        $data = [
            'price' => $request->input('price'),
            'area' => $request->input('area'),
            'description' => $request->input('description'),
            'image_album_url' => $request->input('image_album_url'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'district' => $request->input('district'),
            'street' => $request->input('street'),
            'ward' => $request->input('ward'),
            'city' => $request->input('city'),
        ];

        $data = array_filter($data, function ($var) {
            if ($var == NULL || $var == '')
                return false;
            return true;
        });

        try {
            $room->update($data);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status' => false,
                'data' => [
                    'code' => $e->getCode(),
                    'msg' => $e->errorInfo[2]
                ]
            ], 500);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'room' => $room
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
            ], 404);
        }

        if (\Auth::user()->isAdmin() != true && \Auth::user()->id != $room->user_id) {

            return response()->json([
                'status' => false,
                'data' => [
                    'msg' => 'Don\'t have permisson'
                ]
            ], 403);
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
            ], 500);
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

        //Room::chunk(500, functioncallback());


        $rooms = Room::query();
        $rooms = $rooms->distance($data['curLat'], $data['curLng'], $data['radius']);


        if ($data['minPrice'] != null && $data['minPrice'] != '') {
            $rooms = $rooms->where('price', '>=', $data['minPrice']);
        }

        if ($data['maxPrice'] != null && $data['maxPrice'] != '') {
            $rooms = $rooms->where('price', '<=', $data['maxPrice']);
        }

        if ($data['minArea'] != null && $data['minArea'] != '') {
            $rooms = $rooms->where('area', '>=', $data['minArea']);
        }

        if ($data['maxArea'] != null && $data['maxArea'] != '') {
            $rooms = $rooms->where('area', '<=', $data['maxArea']);
        }
        if ($data['limit'] != null && $data['limit'] != '') {
            $rooms = $rooms->take($data['limit']);
        }

//        dd($rooms);

        return response()->json([
            'status' => true,
            'data' => [
                'room' => $rooms->get()
            ]
        ]);
    }

    /**
     * return list of rooms has address like input
     * @param Request $request
     * @return mixed
     */
    public function searchRealestate(Request $request)
    {
        $datas = [
            'district' => $request->input('district'),
            'street' => $request->input('street'),
            'ward' => $request->input('ward'),
            'city' => $request->input('city')
        ];

        $priceArea = [
            'minPrice' => $request->input('minPrice'),
            'maxPrice' => $request->input('maxPrice'),
            'minArea' => $request->input('minArea'),
            'maxArea' => $request->input('maxArea')
        ];

        $datas = array_filter($datas, function ($var) {
            if ($var == NULL || $var == '')
                return false;
            return true;
        });


        $room = Room::query();
        $flag = 0;


        try {
            foreach ($datas as $key => $value) {
                if ($flag == 0) {
                    $room = Room::where($key, 'ilike', '%' . $value . '%');
                    $flag = 1;
                } else {
                    $room = $room->where($key, 'ilike', '%' . $value . '%');
                }
            }


            if ($priceArea['minPrice'] != null && $priceArea['minPrice'] != '') {
                $room = $room->where('price', '>=', $priceArea['minPrice']);
            }
            if ($priceArea['maxPrice'] != null && $priceArea['maxPrice'] != '') {
                $room = $room->where('price', '<=', $priceArea['maxPrice']);
            }
            if ($priceArea['minArea'] != null && $priceArea['minArea'] != '') {
                $room = $room->where('area', '>=', $priceArea['minArea']);
            }
            if ($priceArea['maxArea'] != null && $priceArea['maxArea'] != '') {
                $room = $room->where('area', '<=', $priceArea['maxArea']);
            }

        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status' => false,
                'data' => [
                    'code' => $e->getCode(),
                    'msg' => $e->errorInfo[2]
                ]
            ], 500);
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
//        $count = 0;
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
//            $count = $count + 1;
        }
        echo "Done Update address - ";
//        echo $count;
    }
}
