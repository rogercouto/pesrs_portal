<?php

namespace App\Http\Controllers;

use App\Services\PageService;
use App\Services\PostService;
use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PortalController extends Controller
{

    private $postService;
    private $tagService;
    private $pageService;

    public function __construct(PostService $postService,
                                TagService $tagService,
                                PageService $pageService)
    {
        $this->postService = $postService;
        $this->tagService = $tagService;
        $this->pageService = $pageService;
    }

    public function index()
    {
        $data['posts'] = $this->postService->getPortalList();
        $data['tags'] = $this->tagService->getAll();
        return view('main', $data);
    }

    public function showPage(int $id){
        $data['page'] = $this->pageService->get($id);
        return view('page', $data);
    }

    public function showPost(int $id){
        $data['post'] = $this->postService->get($id);
        return view('post', $data);
    }

    public function findPost(Request $request)
    {
        $text = $request->input('text');
        return Redirect::route('results',$text);
    }

    public function showResults(string $text)
    {
        $data['posts'] = $this->postService->findPortalList($text);
        $data['findMessage'] = (sizeof($data['posts']) > 0) ?
            "Resultado da busca por: \"$text\"" :
            "Nenhuma postagem contendo \"$text\"";
        $data['tags'] = $this->tagService->getAll();
        return view('main', $data);
    }

    public function findTag(Request $request)
    {
        $id = $request->input('id');
        return Redirect::route('tag',$id);
    }

    public function showTag(int $id)
    {
        $tag = $this->tagService->get($id);
        $data['posts'] = $tag->posts()->paginate(PostService::PORTAL_PAGE_SIZE);
        $data['findMessage'] = (sizeof($data['posts']) > 0) ?
            "Postagens com a tag: \"$tag->name\"" :
            "Nenhuma com a tag \"$tag->name\"";
        $data['tags'] = $this->tagService->getAll();
        return view('main', $data);
    }

}
