@extends('layouts.adm')
@section('content')
    <div class="container" style="padding: 30px;">
        <div class="card col-sm-12" style="background-color: #EEEEEE;">
            <div class="card-body row">
                <div class="col-sm-3">
                    <div class="btn-group" role="group">
                        <a class="btn btn-secondary" href="{{route('pages.edit',['id'=>$page->id])}}"><i class="fa fa-edit"></i>&nbsp;Editar</a>
                        <button id="btn_del_page" class="btn btn-danger"><i class="fa fa-trash-alt"></i>Excluir</button>
                    </div>
                </div>
                <div class="col-sm-3">
                    &nbsp;Anexos:
                    <div class="btn-group" role="group">
                        <button id="btn_add_photo" class="btn btn-secondary" title="Anexar foto"><i class="fa fa-camera"></i></button>
                        <button id="btn_add_file" class="btn btn-secondary" title="Anexar documento"><i class="fa fa-file"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin: 30px;">
            <!-- Post title and content -->
            <div class="col-sm-9">
                <h2>{{$page->title}}</h2><hr/>
                <p><?=$page->content?></p>
            </div>
        </div>
    </div>
    <!-- Gallery  -->
    <div class="container card">
        <div class="card-header" style="background-color: #FFFFFF;"><h4>Fotos</h4></div>
        <div class="card-body">
            @if(sizeof($page->photos) > 0)
                <div class="row justify-content-left">
                    @foreach($page->photos as $pagePhoto)
                        <div class="col-md-4">
                            <form id="form_rem_photo_{{$pagePhoto->id}}" method="POST" action="{{route('pages.photo.delete',['id'=>$pagePhoto->id])}}"
                                  onsubmit="return confirm('Remover foto?');">
                                @csrf
                                <input type="hidden" name="_method" value="DELETE" />
                            </form>
                            <button form="form_rem_photo_{{$pagePhoto->id}}" class="btn btn-light" title="Remover foto" style="float: right;"><i class="fa fa-times"></i></button>
                            <br />
                            <a href="{{asset($pagePhoto->url())}}"
                               data-toggle="lightbox" data-gallery="example-gallery" class="col-sm-4">
                                <img style="height: 150px" src="{{asset($pagePhoto->thumbUrl())}}"  />
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <div class="container">
        <br />
        <h4>Anexos</h4>
        <!-- Post attachments  -->
        <table class="table table-bordered table-striped">
            <tr>
                <th style="width: 30%">Descrição</th>
                <th style="width: 60%">Arquivo</th>
            </tr>
            @forelse($page->files as $pageFile)
                <tr>
                    <td>{{$pageFile->description}}</td>
                    <td>
                        <a target="_blank" href="{{$pageFile->url()}}">{{$pageFile->fileName()}}</a>
                        <button form="form_rem_file_{{$pageFile->id}}" class="btn btn-light" title="Remover documento"><i class="fa fa-times"></i></button>
                        <form id="form_rem_file_{{$pageFile->id}}" method="POST" action="{{route('pages.file.delete',['id'=>$pageFile->id])}}"
                              onsubmit="return confirm('Remover documento?');">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE" />
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" style="text-align: center;">Nenhum anexo</td></tr>
            @endforelse
        </table>
    </div>
    <!-- Modals -->
    @include('adm.pages.modals.delete')
    @include('adm.pages.modals.photo')
    @include('adm.pages.modals.file')
@endsection
@push('libs')
    <link href="{{asset('css/ekko-lightbox.css')}}" rel="stylesheet">
@endpush
@push('scripts')
    <script src="{{asset('js/tether.min.js')}}"></script>
    <script src="{{asset('js/ekko-lightbox.min.js')}}"></script>
    <script type="text/javascript">
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
        $(document).ready(function(){
            $("#btn_del_page").click(function(){
                $("#modal_del_page").modal();
            });
        });
        $(document).ready(function(){
            $("#btn_add_photo").click(function(){
                $("#modal_photo").modal();
            });
        });
        $(document).ready(function(){
            $("#btn_add_file").click(function(){
                $("#modal_file").modal();
            });
        });
        function validatePhoto() {
            var photo = document.getElementById("pagePhoto").value;
            document.getElementById("btnSubmitPhoto").disabled = (photo == "");
        }
        function validateFile() {
            var file = document.getElementById("pageFile").value;
            document.getElementById("btnSubmitFile").disabled = (file == "");
        }
    </script>
@endpush