<?php

namespace App\Http\Controllers\Adm;

use App\Services\TagService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class TagController extends Controller
{

    private $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Tags';
        $data['tags'] = $this->tagService->getPageList();
        return view('adm.tags.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd("ue");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        dd($request);
        /*
        $this->validate($request, [
            'name' => 'required'
        ]);
        $this->tagService->store($request);
        return Redirect::route('tags.index')
            ->with("message","Tag criada com sucesso!")
            ->with("message-type","success");
        */
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
            'name' => 'required'
        ]);
        $this->tagService->update($request, $id);
        return Redirect::route('tags.index')
            ->with("message","Tag atualizada com sucesso!")
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
        $this->tagService->destroy($id);
        return Redirect::route('tags.index')
            ->with("message","Tag excluida com sucesso!")
            ->with("message-type","success");
    }
}
