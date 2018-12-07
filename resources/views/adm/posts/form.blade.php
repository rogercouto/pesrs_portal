@extends('layouts.adm')
@section('content')
    <div class="container" style="padding: 25px 50px 25px 50px;">
        <form method="POST" enctype="multipart/form-data"
              action="{{isset($post->id)? route('posts.update',['id' => $post->id]) : route('posts.store')}}">
            @csrf
            @if(isset($post->id))
                <input type="hidden" name="_method" value="put" />
            @endif
            <div class="form-group">
                <label for="inputTitle">Título:</label>
                <input id="inputTitle" type="text" name="title" maxlength="50"
                       @if(isset($post->title))
                            value="{{$post->title }}"
                       @endif
                       class="form-control"/>
                <span>{{$errors->first('title')}}</span>
            </div>
            <div class="form-group">
                <label for="inputContent">Texto:</label>
                <textarea rows="5" id="inputContent" name="content" class="form-control">{{isset($post->content)?$post->content:""}}</textarea>
            </div>
            <!-- Tags -->
            <div class="form-group">
                <label>Tags</label>
                <textarea id="tagEditor" name="selTags" class="form-control">{{isset($post->id)?$post->stringTags():""}}</textarea>
            </div>
            <!-- Image -->
            <div class="form-group">
                <label for="inputFile">Imagem:</label>
                <input id="inputFile" type="file" name="imgFile" accept="image/*" class="form-control" />
            </div>
            <!-- Draft -->
            <div class="form-group">
                <label for="inputDraft">Rascunho:</label>
                <input id="inputDraft" type="checkbox" name="isDraft"
                        @if((isset($post)&&isset($post->draft)&&$post->draft)||(!isset($post)))
                            checked="checked"
                        @endif>
            </div>
            <!-- Submit -->
            <div class="form-group" style="float: right;">
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                <button id="btnSubmit" type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;Salvar</button>
            </div>
        </form>
    </div>
@endsection
@push('libs')
    <link rel="stylesheet" href="{{asset('css/jquery.tag-editor.css')}}">
    <style type="text/css">
        .tag-editor {
            background: #fafafa;
            border: 0.1px solid lightgray;
            font-size: 14px;
        }
        .tag-editor .tag-editor-tag {
            color: #fff; background: #007bff;
            border-radius: 0px;
        }
        .tag-editor .tag-editor-delete {
            color: #fff; background: #007bff;
        }
    </style>
@endpush
@push('scripts')
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/jquery.caret.min.js')}}"></script>
    <script src="{{asset('js/jquery.tag-editor.js')}}"></script>
    <script src="{{asset('ckeditor/ckeditor.js')}}"></script>
    <script type="text/javascript">
        $('#tagEditor').tagEditor({
            delimiter: '; ',
            autocomplete: {
                delay: 0, // show suggestions immediately
                position: { collision: 'flip' }, // automatic menu position up/down
                source: [
                    @foreach($tags as $tag)
                        @if($loop->index > 0)
                            ,
                        @endif
                        '{{$tag->name}}'
                    @endforeach
                ]
            },
            forceLowercase: false,
            placeholder: 'Tags ...'
        });
        CKEDITOR.replace( 'inputContent', {
            language: 'pt-br',
            title: ''
        });
    </script>
@endpush