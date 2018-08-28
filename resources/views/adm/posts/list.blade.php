@extends('layouts.adm')
@section('content')
    <div class="container">
        <p><a class="btn btn-primary" href="{{route('posts.create')}}"><i class="fa fa-plus-square"></i>&nbsp;Criar</a></p><br/>
        @if(app('request')->input('page') && app('request')->input('page') > 1)
            <h4>Mostrando página {{app('request')->input('page')}} de {{$posts->lastPage()}}</h4>
        @else
            <h4>Mostrando as últimas {{sizeof($posts)}} postagens</h4>
        @endif
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th scope="col" style="width:75%">Título</th>
                <th scope="col" style="width:20%">Publicação</th>
                <th scope="col" style="width:5%">Detalhes</th>
            </tr>
            </thead>
            <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>
                        @if($post->draft)
                            <b>{{$post->title}} (Rascunho)</b>
                        @else
                            {{$post->title}}
                        @endif
                    </td>
                    <td>
                        @if(!$post->draft)
                            {{$post->updated_at->format('d/m/Y H:i')}}
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-primary" title="Visualizar" href="{{route('posts.show',$post->id)}}">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$posts->links()}}
    </div>
@endsection