<?php

namespace App\Http\Controllers\Adm;

use App\Services\PageService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class PageController extends Controller
{

    private $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Páginas';
        $data['pages'] = $this->pageService->getPageList();
        return view('adm.pages.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Inserir página';
        return view('adm.pages.form', $data);
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
        $post = $this->pageService->store($request);
        return Redirect::route('pages.show',$post->id)
            ->with("message","Página criada com sucesso!")
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
        $data['title'] = "Detalhes página Nº $id";
        $data['page'] = $this->pageService->get($id);
        return view('adm.pages.details', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['page'] = $this->pageService->get($id);
        $data['title'] = 'Editar página';
        return view('adm.pages.form', $data);
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
        $this->pageService->update($request, $id);
        return Redirect::route('pages.show',$id)
            ->with("message","Página alterada com sucesso!")
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
        $this->pageService->destroy($id);
        return Redirect::route('pages.index')
            ->with("message","Página excluida com sucesso!")
            ->with("message-type","success");
    }

    public function uploadFile(Request $request, int $id)
    {
        $this->pageService->uploadFile($request,$id);
        return Redirect::route('pages.show',$id)
            ->with("message","Arquivo anexado!")
            ->with("message-type","success");
    }

    public function uploadPhoto(Request $request, int $id)
    {
        $this->pageService->uploadPhoto($request, $id);
        return Redirect::route('pages.show',$id)
            ->with("message","Foto anexada!")
            ->with("message-type","success");
    }

    public function deleteFile(Request $request, int $id)
    {
        $pageId = $this->pageService->deleteFile($id);
        return Redirect::route('pages.show',$pageId)
            ->with("message","Anexo excluído!")
            ->with("message-type","success");
    }

    public function deletePhoto(Request $request, int $id)
    {
        $pageId = $this->pageService->deletePhoto($id);
        return Redirect::route('pages.show',$pageId)
            ->with("message","Foto excluída!")
            ->with("message-type","success");
    }
}
