<?php

namespace App\Services;

use App\Models\Page;
use App\Models\PageFile;
use App\Models\PagePhoto;
use Illuminate\Http\Request;

class PageService
{

    private $uploadService;

    private const PAGE_SIZE = 5;

    private const FILE_FOLDER = 'page-files';

    private const PHOTOS_FOLDER = 'page-photos';
    private const THUMBS_FOLDER = 'page-thumbnails';

    private const PHOTOS_WIDTH = 1280;
    private const PHOTOS_HEIGTH = 720;

    private const THUMB_WIDTH = 400;
    private const THUMB_HEIGHT = 250;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    public function store(Request $request)
    {
        $page = new Page();
        $page->fill($request->all());
        $page->save();
        return $page;
    }

    public function update(Request $request,int $id)
    {
        $updatedFields = $request->all();
        $page = $this->get($id);
        $page->update($updatedFields);
        return $page;
    }

    public function destroy(int $id)
    {
        $page = $this->get($id);
        foreach ($page->photos as $pagePhoto)
        {
             $this->uploadService->delete($pagePhoto->path);
            $this->uploadService->delete($pagePhoto->thumb_path);
             PagePhoto::destroy($pagePhoto->id);
        }
        foreach ($page->files as $pageFile)
        {
            $this->uploadService->delete($pageFile->path);
            PageFile::destroy($pageFile->id);
        }
        Page::destroy($id);
    }

    public function uploadFile(Request $request, $id)
    {
        $page = $this->get($id);
        $file = $request->file('pageFile');
        $pageFile = new PageFile();
        $pageFile->path = $this->uploadService->storeFile($file, self::FILE_FOLDER);
        $pageFile->description = $request->input('description') != null ?
            $request->input('description'):
            'Anexo';
        $pageFile->page_id = $page->id;
        $pageFile->save();
        return $pageFile;
    }

    public function uploadPhoto(Request $request, $id){
        $page = $this->get($id);
        $file = $request->file('pagePhoto');
        $pagePhoto = new PagePhoto();
        $uploaded = $this->uploadService->storePhoto($file,
            self::PHOTOS_FOLDER,
            self::THUMBS_FOLDER,
            self::PHOTOS_WIDTH,
            self::PHOTOS_HEIGTH,
            self::THUMB_WIDTH,
            self::THUMB_HEIGHT);
        $pagePhoto->path = $uploaded['path'];
        $pagePhoto->thumb_path = $uploaded['thumb_path'];
        $pagePhoto->description = $request->input('description') != null ?
            $request->input('description'):
            'Foto';
        $pagePhoto->page_id = $page->id;
        $pagePhoto->save();
        return $pagePhoto;
    }

    public function deleteFile(int $id)
    {
        $file = PageFile::where('id',$id)->firstOrFail();
        $page_id = $file->page_id;
        $this->uploadService->delete($file->path);
        $file->delete();
        return $page_id;
    }

    public function deletePhoto(int $id)
    {
        $foto = PagePhoto::where('id',$id)->firstOrFail();
        $page_id = $foto->page_id;
        $this->uploadService->delete($foto->path);
        $this->uploadService->delete($foto->thumb_path);
        $foto->delete();
        return $page_id;
    }

    public function get(int $id)
    {
        return Page::where('id', $id)->firstOrFail();
    }

    public function getAll()
    {
        return Page::all();
    }

    public function getPageList()
    {
        return Page::orderBy('id', 'DESC')->paginate(self::PAGE_SIZE);
    }

}