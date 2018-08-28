@extends('layouts.adm')
@section('content')
    <div class="container">
        <p><a class="btn btn-primary" href="{{route('pages.create')}}"><i class="fa fa-plus-square"></i>&nbsp;Criar</a></p><br/>
        @if(app('request')->input('page') && app('request')->input('page') > 1)
            <h4>Mostrando página {{app('request')->input('page')}} de {{$pages->lastPage()}}</h4>
        @else
            <h4>Mostrando as últimas {{sizeof($pages)}} páginas</h4>
        @endif
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th scope="col" style="width:80%">Título</th>
                <th scope="col" style="width:20%">Detalhes</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pages as $page)
                <tr>
                    <td scope="row">
                        {{$page->title}}
                    </td>
                    <td>
                        <a class="btn btn-primary" title="Visualizar" href="{{route('pages.show',$page->id)}}">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$pages->links()}}
    </div>
@endsection