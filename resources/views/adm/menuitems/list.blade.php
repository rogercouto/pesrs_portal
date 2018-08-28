@extends('layouts.adm')
@section('content')
    <div class="container">
        <p><a class="btn btn-primary" href="{{route('menus.create')}}"><i class="fa fa-plus-square"></i>&nbsp;Criar item</a></p><br/>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th scope="col" style="width:40%">Nome</th>
                <th scope="col" style="width:45%">URL</th>
                <th scope="col" style="width:15%"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($menuItems as $menuItem)
                <tr style="background-color: {{isset($menuItem->color)?$menuItem->color:'#FFFFFF'}};">
                    <td scope="row">
                        @if($menuItem->parent_id != null)
                            &emsp;<i class="fa fa-ellipsis-v"></i>
                        @else
                            <i class="fa fa-ellipsis-h"></i>
                        @endif
                        {{$menuItem->name}}
                    </td>
                    <td>
                        <a target="_blank" href="{{$menuItem->url}}">{{$menuItem->url}}</a>
                    </td>
                    <td>
                        <form id="form_up_{{$menuItem->id}}" method="POST" action="{{route('menus.up',['id'=>$menuItem->id])}}">
                            @csrf
                            <input type="hidden" name="_method" value="PUT" />
                        </form>
                        <form id="form_down_{{$menuItem->id}}" method="POST" action="{{route('menus.down',['id'=>$menuItem->id])}}">
                            @csrf
                            <input type="hidden" name="_method" value="PUT" />
                        </form>
                        <button type="submit" form="form_up_{{$menuItem->id}}" class="btn btn-light"><i class="fa fa-arrow-up"></i></button>
                        <button type="submit" form="form_down_{{$menuItem->id}}" class="btn btn-light"><i class="fa fa-arrow-down"></i></button>
                        <a class="btn btn-primary" title="Editar" href="{{route('menus.edit',$menuItem->id)}}">
                            <i class="fa fa-edit"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
