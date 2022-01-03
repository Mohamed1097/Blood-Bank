<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model 
{

    protected $table = 'post_categories';
    public $timestamps = true;
    protected $fillable = array('name');

    public function post()
    {
        return $this->hasMany('App\Models\Post');
    }

}