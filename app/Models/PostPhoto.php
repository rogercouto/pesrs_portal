<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class PostPhoto extends Model
{

    protected $table = 'post_photos';

    protected $fillable = ['path','thumb_path','description','post_id'];

    public $timestamps = false;

    public function post()
    {
        return $this->belongsTo('\App\Models\Post');
    }

    public function url(){
        if (!isset($this->path)||strlen($this->path)==0)
            return null;
        return Storage::url($this->path);
    }

    public function thumbUrl(){
        if (!isset($this->thumb_path)||strlen($this->thumb_path)==0)
            return null;
        return Storage::url($this->thumb_path);
    }

    public function fileName(){
        if (!isset($this->path)||strlen($this->path)==0)
            return null;
        $array = explode('/',$this->path);
        $index = sizeof($array)-1;
        return $array[$index];
    }

}
