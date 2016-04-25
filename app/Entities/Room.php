<?php

namespace r4r\Entities;

use Illuminate\Database\Eloquent\Model;


class Room extends Model
{
    /**
     * The table used by the model.
     * @var string
     */
    protected $table = 'rooms';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'price', 'area', 'decripstion', 'image_album_url', 'latitude', 'longitude', 'street', 'ward', 'district', 'city'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * Get owner room
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('r4r\Entities\User', 'user_id');
    }

    public function ScopeDistance($query, $from_latitude, $from_longitude, $distance)
    {
//        dd( $from_latitude, $from_longitude, $distance);
        // This will calculate the distance in km
        // if you want in miles use 3959 instead of 6371
        $raw = \DB::raw('( 6371 * acos( cos( radians(' . $from_latitude . ') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $from_longitude . ') ) + sin( radians(' . $from_latitude . ') ) * sin( radians( latitude ) ) ) ) ');
        return $query->select('*')->groupBy('id')->having($raw, '<=', $distance);
    }
}
