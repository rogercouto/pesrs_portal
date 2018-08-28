<?php

namespace App\Services;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemService
{

    public function create(Request $request)
    {
        $item = new MenuItem();
        $item->fill($request->all());
        if ($item->parent_id == null){
            $count = $this->getParents()->count();
        }else{
            $count = $this->getLevel($item)->count();
        }
        $item->order = $count;
        $item->save();
        return $item;
    }

    public function update(Request $request, int $id)
    {
        $item = $this->get($id);
        $item->fill($request->all());
        $item->save();
        return $item;
    }

    private function first($items)
    {
        foreach ($items as $item)
            return $item;
        return null;
    }

    private function last($items)
    {
        $last = null;
        foreach ($items as $item)
            $last = $item;
        return $last;
    }

    private function prev(MenuItem $current, $items)
    {
        $prev = null;
        foreach ($items as $item){
            if ($item->id == $current->id)
                return $prev;
            $prev = $item;
        }
        return null;
    }

    private function next(MenuItem  $current, $items)
    {
        $found = false;
        foreach ($items as $item){
            if ($found)
                return $item;
            if ($item->id == $current->id)
                $found = true;
        }
        return null;
    }

    public function up(int $id)
    {
        $item = $this->get($id);
        $level = $this->getLevel($item);
        $first = $this->first($level);
        if ($item->id == $first->id)
            return false;
        $switchItem = $this->prev($item, $level);
        //switch order
        $tmp = $item->order;
        $item->order = $switchItem->order;
        $switchItem->order = $tmp;
        //save
        $item->save();
        $switchItem->save();
        return true;
    }

    public function down(int $id)
    {
        $item = $this->get($id);
        $level = $this->getLevel($item);
        $last = $this->last($level);
        if ($item->id == $last->id)
            return false;
        $switchItem = $this->next($item, $level);
        //switch order
        $tmp = $item->order;
        $item->order = $switchItem->order;
        $switchItem->order = $tmp;
        //save
        $item->save();
        $switchItem->save();
        return true;
    }

    public function get(int $id)
    {
        return MenuItem::where('id',$id)->firstOrFail();
    }

    public function getLevel(MenuItem $item)
    {
        if ($item->parent_id == null)
            return $this->getParents();
        return MenuItem::where('parent_id',$item->parent_id)->get()->sortBy('order');
    }

    public function getParents()
    {
        return MenuItem::whereNull('parent_id')->get()->sortBy('order');
    }

    public function getAll()
    {
        $list = array();
        $parents = $this->getParents();
        $painted = true;
        foreach ($parents as $parent){
            if ($painted)
                $parent->color = '#EEEEEE';
            array_push($list, $parent);
            foreach($parent->children as $child){
                if ($painted)
                    $child->color = '#EEEEEE';
                array_push($list, $child);
            }
            $painted = !$painted;
        }
        return $list;
    }

}