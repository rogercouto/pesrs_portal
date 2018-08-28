<?php
/**
 * Created by PhpStorm.
 * User: roger
 * Date: 20/08/18
 * Time: 14:28
 */

namespace App\Helpers;

use App\Models\MenuItem;
use App\Models\Post;

class PageHelper
{

    public static function getMenuItems()
    {
        return MenuItem::whereNull('parent_id')->get()->sortBy('order');
    }

    public static function isActive(MenuItem $parent, string $currentUrl)
    {
        foreach ($parent->children as $menuItem)
        {
            if ($menuItem->url == $currentUrl)
                return ' active';
        }
        return '';
    }

    public static function getPostsWithBanners(){
        return Post::whereRaw('banner_path is not null and (banner_limit is null or banner_limit >= now())')->get()->sortByDesc('id');
    }


}