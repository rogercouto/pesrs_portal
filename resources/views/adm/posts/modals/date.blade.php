<!--
    Modal for banner limit date
-->

<div class="modal fade" id="modal_date" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Data limite</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="form_date" method="POST" enctype="multipart/form-data" action="{{route('posts.banner.setdate',['id'=>$post->id])}}">
                    @csrf
                    <div class="form-group">
                        <label for="input_date">Mostrar até:</label>
                        <input id="input_date" type="date" name="banner_limit" class="form-control"
                               @isset($post->banner_limit)value="{{$post->banner_limit}}"@endisset>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnSubmitBanner" type="button" class="btn btn-default" data-dismiss="modal"
                        onclick="document.getElementById('form_date').submit()">
                    Salvar
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>