@extends('layouts.adm')
@section('content')
    <div class="container" style="padding: 25px 50px 25px 50px;">
        <form id="form_menu_item" method="POST" action="{{$route}}">
            @csrf
            @isset($menuItem->id)
                <input type="hidden" name="_method" value="put" />
            @endisset
            <div class="form-group">
                <label for="input_name">Nome:</label>
                <input id="input_name" type="text" name="name" class="form-control"
                @isset($menuItem->name) value="{{$menuItem->name}}" @endisset/>
            </div>
            <div class="form-group">
                <label for="input_name">Url:</label>
                <input type="text" name="url" list="pages" class="form-control"
                    @isset($menuItem->url) value="{{$menuItem->url}}" @endisset/>
                <datalist id="pages">
                    @foreach($pages as $page)
                        <option value="{{$page->getRoute()}}">{{$page->title}}</option>
                    @endforeach
                </datalist>
            </div>
            <div class="form-group">
                <label for="input_name">Aninhar em:</label>
                <select name="parent_id" class="form-control" @if(isset($menuItem->id) && $menuItem->children()->count() > 0) disabled="disabled"@endif>
                    <option value="" @isset($menuItem->parent_id) selected="selected" @endisset>-</option>
                    @foreach($parents as $parent)
                        <option value="{{$parent->id}}"
                                @if(isset($menuItem->parent_id) && $menuItem->parent_id == $parent->id) selected="selected" @endif
                        >{{$parent->name}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary" style="float: right;"><i class="fa fa-save"></i>&nbsp;Salvar</button>
        </form>
    </div>
@endsection