<?php
/**
 * Created by PhpStorm.
 * User: roger
 * Date: 18/08/18
 * Time: 20:32
 */

namespace App\Helpers;


use App\Models\Message;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class AdmHelper
{

    public static function newMessageCount()
    {
        return Message::where('readed',false)->get()->count();
    }

    public static function isAdmin()
    {
        $id = Auth::user()->id;
        $setting = Setting::where('key','admin.id')->first();
        if ($setting != null){
            $adminId = intval($setting->value);
            return ($adminId == 0 || $id == $adminId);
        }
        return true;
    }

}