<!--
    Modal for photo upload
-->
<div class="modal fade" id="modal_photo" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Anexar foto</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="form_photo" method="POST" enctype="multipart/form-data" action="{{route('posts.photo.upload',['id'=>$post->id])}}">
                    @csrf
                    <div class="form-group">
                        <label for="postPhoto">Arquivo:</label>
                        <input id="postPhoto" type="file" accept="image/*" name="postPhoto" class="form-control" onchange="validatePhoto()">
                    </div>
                    <div class="form-group">
                        <label for="inputDescr">Descrição:</label>
                        <input id="inputDescr" type="text" name="description" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnSubmitPhoto" disabled="disabled" type="button" class="btn btn-default" data-dismiss="modal"
                        onclick="document.getElementById('form_photo').submit()">
                    Enviar
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>