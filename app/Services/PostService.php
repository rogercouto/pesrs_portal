<?php

namespace App\Services;

use App\Models\Post;
use App\Models\PostFile;
use App\Models\PostPhoto;
use Illuminate\Http\Request;

class PostService
{

    private $tagService;
    private $uploadService;

    private const PAGE_SIZE = 5;
    public const PORTAL_PAGE_SIZE = 3;

    private const IMG_FOLDER = 'post-images';
    private const IMG_WIDTH = 600;
    private const IMG_HEIGTH = 400;

    private const BANNER_FOLDER = 'post-banners';
    private const BANNER_WIDTH = 1280;
    private const BANNER_HEIGTH = 300;

    private const FILE_FOLDER = 'post-files';

    private const PHOTOS_FOLDER = 'post-photos';
    private const THUMBS_FOLDER = 'post-thumbnails';

    private const PHOTOS_WIDTH = 1280;
    private const PHOTOS_HEIGTH = 720;

    private const THUMB_WIDTH = 400;
    private const THUMB_HEIGHT = 250;

    public function __construct(TagService $tagService, UploadService $uploadService)
    {
        $this->tagService = $tagService;
        $this->uploadService = $uploadService;
    }

    public function store(Request $request)
    {
        $post = new Post();
        $post->fill($request->all());
        $imageFile = $request->file('imgFile');
        if ($imageFile != null){
            $post->img_path = $this->uploadService->storeImage(
                $imageFile,
                self::IMG_FOLDER,
                self::IMG_WIDTH,
                self::IMG_HEIGTH );
        }
        $post->save();
        $this->tagService->saveTags($post, $request);
        return $post;
    }

    public function update(Request $request,int $id)
    {
        $updatedFields = $request->all();
        $updatedFields['draft'] = $request->input('draft')?true:false;
        $post = $this->get($id);
        $imageFile = $request->file('imgFile');
        if ($imageFile != null){
            $updatedFields['img_path'] = $this->uploadService->storeImage(
                $imageFile,
                self::IMG_FOLDER,
                self::IMG_WIDTH,
                self::IMG_HEIGTH );
        }
        $post->update($updatedFields);
        $this->tagService->updateTags($post, $request);
        return $post;
    }

    public function publish(int $id){
        $post = $this->get($id);
        $post->draft = false;
        $post->save();
    }

    public function setBannerLimit(Request $request, int $id)
    {
        $post = $this->get($id);
        $post->banner_limit = $request->input('banner_limit');
        $post->save();
        return $post;
    }

    public function destroy(int $id)
    {
        $post = $this->get($id);
        foreach ($post->tags as $tag){
            $tag->posts()->detach($post->id);
            $tag->save();
        }
        if ($post->img_path != null)
            $this->uploadService->delete($post->img_path);
        if ($post->banner_path != null)
            $this->uploadService->delete($post->banner_path);
        foreach ($post->photos as $postPhoto)
        {
            $this->uploadService->delete($postPhoto->path);
            $this->uploadService->delete($postPhoto->thumb_path);
            PostPhoto::destroy($postPhoto->id);
        }
        foreach ($post->files as $postFile)
        {
            $this->uploadService->delete($postFile->path);
            PostFile::destroy($postFile->id);
        }
        Post::destroy($id);
    }

    public function uploadBanner(Request $request, int $id)
    {
        $post = $this->get($id);
        $post->banner_limit = $request['banner_limit'];
        if ($post->banner_path != null){
            //delete old banner
            $this->uploadService->delete($post->banner_path);
        }
        $bannerFile = $request->file('postBanner');
        $post->banner_path = $this->uploadService->storeImage(
            $bannerFile,
            self::BANNER_FOLDER,
            self::BANNER_WIDTH,
            self::BANNER_HEIGTH,
            false);
        $post->save();
    }

    public function deleteBanner($id)
    {
        $post = $this->get($id);
        if ($post->banner_path != null){
            //delete old banner
            $this->uploadService->delete($post->banner_path);
        }
        $post->banner_path = null;
        $post->save();
    }

    public function uploadFile(Request $request, $id)
    {
        $post = $this->get($id);
        $file = $request->file('postFile');
        $postFile = new PostFile();
        $postFile->path = $this->uploadService->storeFile($file, self::FILE_FOLDER);
        $postFile->description = $request->input('description') != null ?
            $request->input('description'):
            'Anexo';
        $postFile->post_id = $post->id;
        $postFile->save();
        return $postFile;
    }

    public function uploadPhoto(Request $request, $id){
        $post = $this->get($id);
        $file = $request->file('postPhoto');
        $postPhoto = new PostPhoto();
        $uploaded = $this->uploadService->storePhoto($file,
            self::PHOTOS_FOLDER,
            self::THUMBS_FOLDER,
            self::PHOTOS_WIDTH,
            self::PHOTOS_HEIGTH,
            self::THUMB_WIDTH,
            self::THUMB_HEIGHT);
        $postPhoto->path = $uploaded['path'];
        $postPhoto->thumb_path = $uploaded['thumb_path'];
        $postPhoto->description = $request->input('description') != null ?
            $request->input('description'):
            'Foto';
        $postPhoto->post_id = $post->id;
        $postPhoto->save();
        return $postPhoto;
    }

    public function deleteFile(int $id)
    {
        $file = PostFile::where('id',$id)->firstOrFail();
        $post_id = $file->post_id;
        $this->uploadService->delete($file->path);
        $file->delete();
        return $post_id;
    }

    public function deletePhoto(int $id)
    {
        $foto = PostPhoto::where('id',$id)->firstOrFail();
        $post_id = $foto->post_id;
        $this->uploadService->delete($foto->path);
        $this->uploadService->delete($foto->thumb_path);
        $foto->delete();
        return $post_id;
    }

    public function get(int $id)
    {
        return Post::where('id', $id)->firstOrFail();
    }

    public function getAll()
    {
        return Post::all();
    }

    public function getPageList()
    {
        return Post::orderBy('id', 'DESC')->paginate(self::PAGE_SIZE);
    }

    public function getPortalList()
    {
        return Post::where('draft',false)->orderBy('id', 'DESC')->paginate(self::PORTAL_PAGE_SIZE);
    }

    public function findPortalList(string $text)
    {
        return Post::where('title', 'like', "%$text%")->orWhere('content', 'like', "%$text%")->orderBy('id', 'DESC')->paginate(self::PORTAL_PAGE_SIZE);
    }

}