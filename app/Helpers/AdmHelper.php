<?php
/**
 * Created by PhpStorm.
 * User: roger
 * Date: 18/08/18
 * Time: 20:32
 */

namespace App\Helpers;


use App\Models\Message;

class AdmHelper
{

    public static function newMessageCount()
    {
        return Message::where('readed',false)->get()->count();
    }




}