<?php

namespace Wingi\Entities;

use Illuminate\Database\Eloquent\Model;

class RoomAddress extends Model
{

    /**
     * The table used by the model.
     * @var string
     */
    protected $table = 'room_addresses';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'latitude', 'longitude', 'district', 'street', 'ward',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * Get Room from address
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room()
    {
        return $this->belongsTo('Room');
    }
}
