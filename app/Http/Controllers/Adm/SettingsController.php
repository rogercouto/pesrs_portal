<?php

namespace App\Http\Controllers\Adm;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class SettingsController extends Controller
{

    public function index()
    {
        $data['settings'] = Setting::paginate(5);
        return view('adm.settings.list', $data);
    }

    public function store(Request $request)
    {
        $setting = new Setting();
        $setting->fill($request->all());
        $setting->value = '';
        $setting->save();
        return Redirect::route('settings')
            ->with("message","Configuração adicionada com sucesso!")
            ->with("message-type","success");
    }

    public function update(Request $request, $key)
    {
        $setting = Setting::where('key', $key)->firstOrFail();
        $setting->fill($request->all());
        if ($setting->value == null)
            $setting->value = '';
        $setting->update();
        return Redirect::route('settings')
            ->with("message","Configuração atualizada com sucesso!")
            ->with("message-type","success");
    }

    public function destroy($key)
    {
        Setting::destroy($key);
        return Redirect::route('settings')
            ->with("message","Configuração excluida com sucesso!")
            ->with("message-type","success");
    }

}
