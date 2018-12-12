@extends('layouts.adm')
@section('content')
    <div class="container">
        <form id="form_ins" method="POST" action="{{route('settings.store')}}">
            @csrf
            <input id="input_ins_key" type="hidden" name="key" value=""/>
        </form>
        <button title="Adicionar" class="btn btn-primary" onclick="inputInsPrompt()"><i class="fa fa-plus-square"></i> Adicionar</button>
        @if(app('request')->input('page') != null)
            <h4>Mostrando página {{app('request')->input('page')}} de {{$settings->lastPage()}}</h4>
        @else
            <p>&nbsp;</p>
        @endif
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th scope="col" style="width:60%">Chave</th>
                <th scope="col" style="width:20%">Valor</th>
                <th scope="col" style="width:10%"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($settings as $setting)
                <tr>
                    <td scope="row">
                        {{$setting->key}}
                    </td>
                    <td scope="row">
                        {{$setting->value}}
                    </td>
                    <td>
                        <form id="form_edt_{{$setting->key}}" method="POST" action="{{route('settings.update',['key'=>$setting->key])}}">
                            @csrf
                            <input type="hidden" name="_method" value="PUT" />
                            <input id="input_edt_value_{{$setting->key}}" type="hidden" name="value" value="{{$setting->value}}"/>
                        </form>
                        <form id="form_rem_{{$setting->key}}" method="POST" action="{{route('settings.destroy',['key'=>$setting->key])}}">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE" />
                        </form>
                        <button title="Editar" class="btn btn-primary" onclick="inputEdtPrompt('{{$setting->key}}')"><i class="fa fa-edit"></i></button>
                        <button title="Excluir" class="btn btn-danger" onclick="confirmPrompt('{{$setting->key}}')"><i class="fa fa-trash-alt"></i></button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$settings->links()}}
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        function inputInsPrompt(){
            var newValue = prompt("Chave:", "");
            document.getElementById("input_ins_key").value = newValue;
            document.getElementById("form_ins").submit();
        }
        function confirmPrompt(key){
            if (confirm("Confirma exclusão?")) {
                document.getElementById("form_rem_"+key).submit();
            }
        }
        function inputEdtPrompt(key){
            var oldValue = document.getElementById("input_edt_value_"+key).value;
            var newValue = prompt("Valor:", oldValue);
            if (newValue != oldValue){
                document.getElementById("input_edt_value_"+key).value = newValue;
                document.getElementById("form_edt_"+key).submit();
            }
        }

    </script>
@endpush
