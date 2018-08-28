<div class="modal fade" id="modal_rem_banner" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Atenção</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja remover o banner?</p>
            </div>
            <div class="modal-footer">
                <form id="form_rem_banner" action="{{route('posts.banner.destroy',['id'=>$post->id])}}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE" />
                    <button type="button" class="btn btn-default" data-dismiss="modal"
                            onclick="document.getElementById('form_rem_banner').submit()">Sim
                    </button>
                </form>
                <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
            </div>
        </div>
    </div>
</div>