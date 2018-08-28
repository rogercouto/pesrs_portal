<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\String_;

class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = ['name'];

    public $timestamps = false;

    public function posts()
    {
        return $this->belongsToMany('\App\Models\Post','post_tags');
    }

}
