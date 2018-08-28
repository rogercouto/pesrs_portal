<!--
    Modal for file upload
-->
<div class="modal fade" id="modal_file" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Anexar documento</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="form_file" method="POST" enctype="multipart/form-data" action="{{route('posts.file.upload',['id'=>$post->id])}}">
                    @csrf
                    <div class="form-group">
                        <label for="postFile">Arquivo:</label>
                        <input id="postFile" type="file" name="postFile" class="form-control" onchange="validateFile()">
                    </div>
                    <div class="form-group">
                        <label for="inputDescr">Descrição:</label>
                        <input id="inputDescr" type="text" name="description" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnSubmitFile" disabled="disabled" type="button" class="btn btn-default" data-dismiss="modal"
                        onclick="document.getElementById('form_file').submit()">
                    Enviar
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<script>

</script>