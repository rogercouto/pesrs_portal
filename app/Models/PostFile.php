<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class PostFile extends Model
{

    protected $table = 'post_files';

    protected $fillable = ['path','description','post_id'];

    public $timestamps = false;

    public function post()
    {
        return $this->belongsTo('\App\Models\Post');
    }

    public function url()
    {
        if (!isset($this->path)||strlen($this->path)==0)
            return null;
        return Storage::url($this->path);
    }

    public function fileName()
    {
        if (!isset($this->path)||strlen($this->path)==0)
            return null;
        $array = explode('/',$this->path);
        $index = sizeof($array)-1;
        return $array[$index];
    }

}
