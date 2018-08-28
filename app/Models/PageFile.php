<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class PageFile extends Model
{

    protected $table = 'page_files';

    protected $fillable = ['path','description','page_id'];

    public $timestamps = false;

    public function page()
    {
        return $this->belongsTo('\App\Models\Page');
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
