<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $table = 'posts';

    protected $fillable = ['title','content','user_id', 'img_path', 'banner_path', 'draft'];

    public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }

    public function tags()
    {
        return $this->belongsToMany('\App\Models\Tag','post_tags');
    }

    public function files()
    {
        return $this->hasMany('\App\Models\PostFile');
    }

    public function photos()
    {
        return $this->hasMany('\App\Models\PostPhoto');
    }

    public function stringTags(){
        $string = "";
        foreach ($this->tags as $tag){
            if (strlen($string) > 0)
                $string .= ';';
            $string .= $tag->name;
        }
        return $string;
    }

    public function imgUrl(){
        if (!isset($this->img_path))
            return null;
        return Storage::url($this->img_path);
    }

    public function bannerUrl(){
        if (!isset($this->banner_path))
            return null;
        return Storage::url($this->banner_path);
    }

    public function bannerFileName(){
        if (!isset($this->banner_path))
            return null;
        $array = explode('/',$this->banner_path);
        $index = sizeof($array)-1;
        return $array[$index];
    }


}
