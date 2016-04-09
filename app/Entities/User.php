<?php

namespace r4r\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The table used by the model.
     * @var string
     */
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get all User's room
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rooms()
    {
        return $this->hasMany('r4r\Entities\Room');
    }

    public function admin(){
        return $this->hasOne('r4r\Entities\Admin');
    }

    public function isAdmin(){
        return ($this->admin()->get()->count() == 0)? false:true;
    }
    
    // this is a recommended way to declare event handlers
    protected static function boot() {
        parent::boot();

        static::deleting(function($user) { // before delete() method call this
            $user->rooms()->delete();
            $user->admin()->delete();
            // do the rest of the cleanup...
        });
    }
}
