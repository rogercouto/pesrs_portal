@extends('layouts.adm')
@section('content')
    <div class="container" style="padding: 30px;">
        <div class="card col-sm-12" style="background-color: #EEEEEE;">
            <div class="card-body row">
                @if($post->draft)
                    <div class="col-sm-2">
                        <form id="form_publish" method="POST" action="{{route('posts.publish',['id'=>$post->id])}}"
                              onsubmit="return confirm('Publicar postagem?');">
                            @csrf
                            <input type="hidden" name="_method" value="PUT" />
                        </form>
                        &nbsp;
                        <button form="form_publish" type="submit" class="btn btn-success" style="float: left;"><i class="fa fa-globe-americas"></i>Publicar</button>
                    </div>
                @endif
                <div class="col-sm-3">
                    <div class="btn-group" role="group">
                        <a class="btn btn-secondary" href="{{route('posts.edit',['id'=>$post->id])}}"><i class="fa fa-edit"></i>&nbsp;Editar</a>
                        <button id="btn_del_post" class="btn btn-danger"><i class="fa fa-trash-alt"></i>Excluir</button>
                    </div>
                </div>
                <div class="col-sm-4">
                    &nbsp;Banner:
                    <div class="btn-group" role="group">
                        <button id="btn_upload_banner" class="btn btn-secondary" title="{{isset($post->banner_path)?'Substituir banner':'Enviar banner'}}">
                            <i class="fa fa-upload"></i>
                        </button>
                        @isset($post->banner_path)
                            <a class="btn btn-secondary" href="{{asset($post->bannerUrl())}}"
                               data-toggle="lightbox" title="Ver banner">
                                <i class="fa fa-eye"></i>
                            </a>
                            <button id="btn_date" class="btn btn-secondary" title="Data limite"><i class="fa fa-calendar-alt"></i></button>
                            <button id="btn_rem_banner" type="submit" class="btn btn-danger" title="Remover banner"><i class="fa fa-trash-alt"></i></button>
                        @endisset
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
        @if($post->draft)
            <div class="container">
                &nbsp;<h4>(Rascunho)</h4>
            </div>
        @endif
        <div class="row" style="margin: 30px;">
            <div class="col-sm-3">
                <!-- Post image -->
                @isset($post->img_path)
                    <p>
                        <form id="form_rem_img_{{$post->id}}" method="POST" action="{{route('posts.image.destroy',['id'=>$post->id])}}"
                              onsubmit="return confirm('Remover imagem?');">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE" />
                        </form>
                        <button form="form_rem_img_{{$post->id}}" type="submit" class="btn btn-light" style="float: right;" title="Remover imagem"><i class="fa fa-times"></i></button>
                    </p>
                    <br />
                    <a href="{{asset($post->imgUrl())}}"
                       data-toggle="lightbox" class="col-sm-4">
                        <img style="height: 200px" src="{{asset($post->imgUrl())}}"  />
                    </a>
                @else
                    <i class="fas fa-image fa-7x"></i>
                @endisset
            </div>
            <!-- Post title and content -->
            <div class="col-sm-9">
                <h2>{{$post->title}}</h2><hr/>
                <p><?=$post->content?></p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <!-- Post tags-->
                Tags:
                @foreach($post->tags as $tag)
                    <span class="badge-primary" style="color: #FFFFFF;padding: 5px;border-radius: 10px;">{{$tag->name}}</span>
                @endforeach
                <br/><br/>
            </div>
        </div>
    </div>
    <!-- Gallery  -->
    <div class="container card">
        <div class="card-header" style="background-color: #FFFFFF;"><h4>Fotos</h4></div>
        <div class="card-body">
            @if(sizeof($post->photos) > 0)
                <div class="row justify-content-left">
                    @foreach($post->photos as $postPhoto)
                        <div class="col-md-4">
                            <form id="form_rem_photo_{{$postPhoto->id}}" method="POST" action="{{route('posts.photo.delete',['id'=>$postPhoto->id])}}"
                                  onsubmit="return confirm('Remover foto?');">
                                @csrf
                                <input type="hidden" name="_method" value="DELETE" />
                            </form>
                            <button form="form_rem_photo_{{$postPhoto->id}}" class="btn btn-light" title="Remover foto" style="float: right;"><i class="fa fa-times"></i></button>
                            <br />
                            <a href="{{asset($postPhoto->url())}}"
                               data-toggle="lightbox" data-gallery="example-gallery" class="col-sm-4">
                                <img style="height: 150px" src="{{asset($postPhoto->thumbUrl())}}"  />
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
            @forelse($post->files as $postFile)
                <tr>
                    <td>{{$postFile->description}}</td>
                    <td>
                        <a target="_blank" href="{{$postFile->url()}}">{{$postFile->fileName()}}</a>
                        <button form="form_rem_file_{{$postFile->id}}" class="btn btn-light" title="Remover documento"><i class="fa fa-times"></i></button>
                        <form id="form_rem_file_{{$postFile->id}}" method="POST" action="{{route('posts.file.delete',['id'=>$postFile->id])}}"
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
    @include('adm.posts.modals.delete')
    @include('adm.posts.modals.banner')
    @isset($post->banner_path)
        @include('adm.posts.modals.date')
        @include('adm.posts.modals.rembanner')
    @endisset
    @include('adm.posts.modals.photo')
    @include('adm.posts.modals.file')
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
            $("#btn_del_post").click(function(){
                $("#modal_del_post").modal();
            });
        });
        $(document).ready(function(){
            $("#btn_upload_banner").click(function(){
                $("#modal_banner").modal();
            });
        });
        $(document).ready(function(){
            $("#btn_rem_banner").click(function(){
                $("#modal_rem_banner").modal();
            });
        });
        $(document).ready(function(){
            $("#btn_date").click(function(){
                $("#modal_date").modal();
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
        function validateBanner() {
            var fileBanner = document.getElementById("input_banner").value;
            document.getElementById("btn_send_banner").disabled = (fileBanner == "");
        }
        function validatePhoto() {
            var photo = document.getElementById("postPhoto").value;
            document.getElementById("btnSubmitPhoto").disabled = (photo == "");
        }
        function validateFile() {
            var file = document.getElementById("postFile").value;
            document.getElementById("btnSubmitFile").disabled = (file == "");
        }
    </script>
@endpush