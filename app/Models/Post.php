<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model 
{

    protected $table = 'posts';
    public $timestamps = true;
    protected $fillable = array('title', 'cotent', 'image','post_category_id');

    public function postCategory()
    {
        return $this->belongsTo('App\Models\PostCategory');
    }

    public function clients()
    {
        return $this->belongsToMany('App\Models\Client');
    }

}