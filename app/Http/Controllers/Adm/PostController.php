<?php

namespace App\Http\Controllers\Adm;

use App\Services\UploadService;
use App\Services\PostService;
use App\Services\TagService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class PostController extends Controller
{

    private $postService;
    private $tagService;
    private $imageService;

    public function __construct(PostService $postService, TagService $tagService, UploadService $imageService)
    {
        $this->postService = $postService;
        $this->tagService = $tagService;
        $this->imageService = $imageService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Postagens';
        $data['posts'] = $this->postService->getPageList();
        return view('adm.posts.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Inserir postagem';
        $data['action'] = route('posts.store');
        $data['tags'] = $this->tagService->getAll();
        return view('adm.posts.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'min: 1 | max: 50 | required'
        ]);
        $post = $this->postService->store($request);
        return Redirect::route('posts.show',$post->id)
            ->with("message","Postagem criada com sucesso!")
            ->with("message-type","success");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['title'] = "Detalhes postagem Nº $id";
        $data['post'] = $this->postService->get($id);
        return view('adm.posts.details', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['post'] = $this->postService->get($id);
        $data['title'] = 'Editar postagem';
        $data['tags'] = $this->tagService->getAll();
        return view('adm.posts.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'min: 1 | max: 50 | required'
        ]);
        $this->postService->update($request, $id);
        return Redirect::route('posts.show',$id)
            ->with("message","Postagem alterada com sucesso!")
            ->with("message-type","success");
    }

    public function publish($id)
    {
        $this->postService->publish($id);
        return Redirect::route('posts.show',$id)
            ->with("message","Postagem publicada com sucesso!")
            ->with("message-type","success");
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->postService->destroy($id);
        return Redirect::route('posts.index')
            ->with("message","Postagem excluida com sucesso!")
            ->with("message-type","success");
    }


    public function destroyImage($id)
    {
        $post = $this->postService->get($id);
        $this->imageService->delete($post->img_path);
        $post->img_path = null;
        $post->update();
        return Redirect::route('posts.show',$id)
            ->with("message","Imagem removida com sucesso!")
            ->with("message-type","success");
    }

    public function uploadBanner($id)
    {
        $data['post'] = $this->postService->get($id);
        $data['formTitle'] =  'Enviar banner';
        $data['formAction'] = route('posts.banner.upload',$id);
        $data['isBanner'] = true;
        return view('adm.posts.upload', $data);
    }

    public function storeBanner(Request $request, $id)
    {
        $this->validate($request, [
            'postBanner' => 'required'
        ]);
        $this->postService->uploadBanner($request, $id);
        return Redirect::route('posts.show',$id)
            ->with("message","Banner enviado com sucesso!")
            ->with("message-type","success");
    }

    public function destroyBanner($id)
    {
        $this->postService->deleteBanner($id);
        return Redirect::route('posts.show',$id)
            ->with("message","Banner removido com sucesso!")
            ->with("message-type","success");
    }

    public function setBannerDate(Request $request, int $id)
    {
        $this->postService->setBannerLimit($request, $id);
        return Redirect::route('posts.show',$id)
            ->with("message","Data limite alterada!")
            ->with("message-type","success");
    }

    public function uploadFile(Request $request, int $id)
    {
        $this->postService->uploadFile($request,$id);
        return Redirect::route('posts.show',$id)
            ->with("message","Arquivo anexado!")
            ->with("message-type","success");
    }

    public function uploadPhoto(Request $request, int $id)
    {
        $this->postService->uploadPhoto($request, $id);
        return Redirect::route('posts.show',$id)
            ->with("message","Foto anexada!")
            ->with("message-type","success");
    }

    public function deleteFile(Request $request, int $id)
    {
        $postId = $this->postService->deleteFile($id);
        return Redirect::route('posts.show',$postId)
            ->with("message","Anexo excluído!")
            ->with("message-type","success");
    }

    public function deletePhoto(Request $request, int $id)
    {
        $postId = $this->postService->deletePhoto($id);
        return Redirect::route('posts.show',$postId)
            ->with("message","Foto excluída!")
            ->with("message-type","success");
    }

}
