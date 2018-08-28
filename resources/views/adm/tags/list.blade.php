@extends('layouts.adm')
@section('content')
    <div class="container">
        @if(app('request')->input('page') != null)
            <h4>Mostrando página {{app('request')->input('page')}} de {{$tags->lastPage()}}</h4>
        @else
            <p>&nbsp;</p>
        @endif
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th scope="col" style="width:60%">Nome</th>
                <th scope="col" style="width:20%">Postagens</th>
                <th scope="col" style="width:10%"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($tags as $tag)
                <tr>
                    <td scope="row">
                        {{$tag->name}}
                    </td>
                    <td scope="row">
                        {{sizeof($tag->posts)}}
                    </td>
                    <td>
                        <form id="form_edt_{{$tag->id}}" method="POST" action="{{route('tags.update',['id'=>$tag->id])}}">
                            @csrf
                            <input type="hidden" name="_method" value="PUT" />
                            <input id="input_name_{{$tag->id}}" type="hidden" name="name" value="{{$tag->name}}"/>
                        </form>
                        <form id="form_rem_{{$tag->id}}" method="POST" action="{{route('tags.destroy',['id'=>$tag->id])}}">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE" />
                        </form>
                        <button title="Editar" class="btn btn-primary" onclick="inputPrompt({{$tag->id}})"><i class="fa fa-edit"></i></button>
                        <button title="Excluir" class="btn btn-danger" onclick="confirmPrompt({{$tag->id}})"><i class="fa fa-trash-alt"></i></button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$tags->links()}}
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        function confirmPrompt(tagId){
            if (confirm("Confirma exclusão?")) {
                document.getElementById("form_rem_"+tagId).submit();
            }
        }
        function inputPrompt(tagId){
            var oldName = document.getElementById("input_name_"+tagId).value;
            var newName = prompt("Nome da tag:", oldName);
            if (newName != null && newName != ""){
                document.getElementById("input_name_"+tagId).value = newName;
                document.getElementById("form_edt_"+tagId).submit();
            }
        }
    </script>
@endpush
