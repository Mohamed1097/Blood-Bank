<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Client extends Authenticatable 
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'password', 'phone', 'last_donation_date', 'd_o_b', 'blood_type_id', 'city_id','allowed_governorates_ids','allowed_blood_types_ids');
    protected $hidden = array('password', 'api_token');

    public function bloodType()
    {
        return $this->belongsTo('App\Models\BloodType');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function donationRequest()
    {
        return $this->hasMany('App\Models\DonationRequest');
    }

    public function posts()
    {
        return $this->belongsToMany('App\Models\Post');
    }

    public function notifications()
    {
        return $this->belongsToMany('App\Models\Notification');
    }
    public function contacts()
    {
        return $this->hasMany('App\Models\Contact');
    }
    public function tokens()
    {
        return $this->hasMany('App\Models\Token');
    }

}