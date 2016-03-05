<?php

namespace Wingi\Entities;

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
        'user_id', 'price', 'area', 'level', 'amenity', 'room_add_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];


    public function user(){
        return $this->belongsTo('User', 'user_id');
    }

    public function address() {
        return $this->hasOne('RoomAddress'. 'room_add_id');
    }
}
