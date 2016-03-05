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
        'user_id', 'price', 'area', 'decripstion', 'room_add_id', 'image_album_url', 'bed'
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
    public function user(){
        return $this->belongsTo('User', 'user_id');
    }

    /**
     * Get address of room
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function address() {
        return $this->hasOne('RoomAddress'. 'room_add_id');
    }
}
