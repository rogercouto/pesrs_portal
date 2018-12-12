<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    public $incrementing = false;

    protected $primaryKey = 'key';

    protected $table = 'settings';

    protected $fillable = ['key','value'];

    public $timestamps = false;

}
