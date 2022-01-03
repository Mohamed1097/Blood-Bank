<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DonationRequest extends Model 
{

    protected $table = 'donation_requests';
    public $timestamps = true;
    protected $fillable = array('patient_name', 'city_id', 'age', 'blood_type_id', 'hospital_address', 'bags_num', 'latitude', 'longitude','patient_phone','client_id');

    public function bloodType()
    {
        return $this->belongsTo('App\Models\BloodType');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function notification()
    {
        return $this->hasOne('App\Models\Notification');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

}