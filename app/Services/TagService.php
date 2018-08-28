<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagService
{

    private const PAGE_SIZE = 5;

    public function store($request){
        $tag = new Tag();
        $tag->fill($request->all());
        $tag->save();
        return $tag;
    }

    /**
     * Verify if have some tag
     * @param $tagName - name of a tag
     * @return Tag - If $allTags contains tag with name equals $strTag return it
     */
    private function findByName($allTags, $tagName) {
        foreach($allTags as $tag){
            if ($tag->name == $tagName)
                return $tag;
        }
        return null;
    }

    public function deleteUnusedTags(){
        $tags = $this->getAll();
        foreach ($tags as $tag){
            if (sizeof($tag->posts) == 0)
                $tag->delete();
        }
    }

    /**
    * Save the post tags from string
    * @param $post - The post
    * @param $request - Form request
    */
    public function saveTags(Post $post, Request $request){
        $selTags = explode(';', $request->input('selTags'));
        $allTags = $this->getAll();
        foreach ($selTags as $tagName){
            if ($tagName != ""){
                $tag = $this->findByName($allTags, $tagName);
                if ($tag == null){
                    $tag = new Tag();
                    $tag->name = $tagName;
                    $tag->save();
                }
                $post->tags()->attach($tag);
            }
        }
    }

    /**
     * Save the post tags from string
     * @param $post - The post
     * @param $request - Form request
     */
    public function updateTags(Post $post, Request $request){
        $selTags = explode(';', $request->input('selTags'));
        $allTags = $this->getAll();
        $syncTags = array();
        foreach ($selTags as $tagName){
            if ($tagName != ""){
                $tag = $this->findByName($allTags, $tagName);
                if ($tag == null){
                    $tag = new Tag();
                    $tag->name = $tagName;
                    $tag->save();
                }
                array_push($syncTags, $tag->id);
            }
        }
        $post->tags()->sync($syncTags);
        $this->deleteUnusedTags();
    }

    public function get(int $id)
    {
        return Tag::where('id', $id)->firstOrFail();
    }

    public function getAll()
    {
        return Tag::all();
    }

    public function getPageList()
    {
        return Tag::orderBy('id', 'DESC')->paginate(self::PAGE_SIZE);
    }

}