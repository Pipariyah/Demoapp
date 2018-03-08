<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//use Illuminate\Notifications\Notifiable;
//use Illuminate\Foundation\Auth\User as Authenticatable;


class Demouser extends Model
{
    //use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function getFirstNameAttribute()
    {
        return ucfirst("{$this->name}");
    }
    public function setNameAttribute($value)
    {
        // \Log::info("this name 123==> ".$value);
        $this->attributes['name']= ucfirst($value);
    }
    public function setSubscribe($days)
    {
        $this->subscribe = $days;
        if ($this->save()) {
            return true;
        }
        return false;
    }
}
