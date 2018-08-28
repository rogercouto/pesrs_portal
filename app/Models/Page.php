<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{

    protected $table = 'pages';

    protected $fillable = ['title','content'];

    public $timestamps = false;

    public function files()
    {
        return $this->hasMany('\App\Models\PageFile');
    }

    public function photos()
    {
        return $this->hasMany('\App\Models\PagePhoto');
    }

    public function getRoute()
    {
        return route('page',['id'=>$this->id]);
    }

}
