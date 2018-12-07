@extends('layouts.adm')
@section('content')
    <div class="container" style="padding: 25px 50px 25px 50px;">
        <form method="POST"
              action="{{isset($page->id)? route('pages.update',['id' => $page->id]) : route('pages.store')}}">
            @csrf
            @if(isset($page->id))
                <input type="hidden" name="_method" value="put" />
            @endif
            <div class="form-group">
                <label for="inputTitle">Título:</label>
                <input id="inputTitle" type="text" name="title" maxlength="50"
                       @if(isset($page->title))
                            value="{{$page->title }}"
                       @endif
                       class="form-control"/>
                <span>{{$errors->first('title')}}</span>
            </div>
            <div class="form-group">
                <label for="inputContent">Conteúdo:</label>
                <textarea rows="5" id="inputContent" name="content" class="form-control">{{isset($page->content)?$page->content:""}}</textarea>
            </div>
            <!-- Submit -->
            <div class="form-group" style="float: right;">
                <button id="btnSubmit" type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;Salvar</button>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/jquery.caret.min.js')}}"></script>
    <script src="{{asset('js/jquery.tag-editor.js')}}"></script>
    <script src="{{asset('ckeditor/ckeditor.js')}}"></script>
    <script type="text/javascript">
        CKEDITOR.replace( 'inputContent', {
            language: 'pt-br',
            title: ''
        });
    </script>
@endpush