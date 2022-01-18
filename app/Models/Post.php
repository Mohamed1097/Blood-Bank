<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;


class Post extends Model 
{
    use HasTranslations;

    protected $table = 'posts';
    public $timestamps = true;
    
    protected $fillable = array('post_category_id');
    public $translatable = ['title','content'];


    public function postCategory()
    {
        return $this->belongsTo('App\Models\PostCategory');
    }

    public function clients()
    {
        return $this->belongsToMany('App\Models\Client');
    }

}