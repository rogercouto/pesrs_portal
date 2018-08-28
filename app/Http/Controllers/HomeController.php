<?php

namespace App\Http\Controllers;

use App\Helpers\AdmHelper;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AdmHelper $admHelper)
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $count = AdmHelper::newMessageCount();
        if ($count > 0){
            return Redirect::route('welcome')
                ->with("info","$count nova(s) mensagen(s)!");
        }
        return Redirect::route('welcome');
    }

}
