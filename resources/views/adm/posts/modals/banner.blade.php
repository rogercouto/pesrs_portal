<!--
    Modal for banner file upload
-->
<div class="modal fade" id="modal_banner" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Enviar arquivo</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="form_banner" method="POST" enctype="multipart/form-data" action="{{route('posts.banner.upload',['id'=>$post->id])}}">
                    @csrf
                    <div class="form-group">
                        <label for="input_banner">Arquivo:</label>
                        <input id="input_banner" type="file" accept="image/*" name="postBanner" class="form-control" onchange="validateBanner()">
                    </div>
                    <div class="form-group">
                        <label for="input_date">Mostrar até:</label>
                        <input id="input_date" type="date" name="banner_limit" class="form-control"
                               @isset($post->banner_limit)value="{{$post->banner_limit}}"@endisset>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btn_send_banner" disabled="disabled" type="button" class="btn btn-default" data-dismiss="modal"
                        onclick="document.getElementById('form_banner').submit()">
                    Enviar
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>