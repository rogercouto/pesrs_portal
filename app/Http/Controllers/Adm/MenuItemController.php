<?php

namespace App\Http\Controllers\Adm;

use App\Services\MenuItemService;
use App\Services\PageService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;


class MenuItemController extends Controller
{

    private $menuItemService;
    private $pageService;

    public function __construct(MenuItemService $menuItemService, PageService $pageService)
    {
        $this->menuItemService = $menuItemService;
        $this->pageService = $pageService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Menu';
        $data['menuItems'] = $this->menuItemService->getAll();
        return view('adm.menuitems.list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Criar item do menu';
        $data['route'] = route('menus.store');
        $data['pages'] = $this->pageService->getAll();
        $data['parents'] = $this->menuItemService->getParents();
        return view('adm.menuitems.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->menuItemService->create($request);
        return Redirect::route('menus.index')
            ->with("message","Item inserido!")
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['title'] = 'Editar item do menu';
        $data['menuItem'] = $this->menuItemService->get($id);
        $data['route'] = route('menus.update',['id'=>$id]);
        $data['pages'] = $this->pageService->getAll();
        $data['parents'] = $this->menuItemService->getParents();
        return view('adm.menuitems.form', $data);
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
        $this->menuItemService->update($request, $id);
        return Redirect::route('menus.index')
            ->with("message","Item alterado!")
            ->with("message-type","success");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function up($id){
        if ($this->menuItemService->up($id)){
            return Redirect::route('menus.index')
                ->with("message","Prioridade alterada!")
                ->with("message-type","success");
        }
        return Redirect::route('menus.index');
    }

    public function down($id){
        if ($this->menuItemService->down($id)){
            return Redirect::route('menus.index')
                ->with("message","Prioridade alterada!")
                ->with("message-type","success");
        }
        return Redirect::route('menus.index');
    }
}
