<div class="modal fade" id="modal_del_page" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Atenção</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir a página?</p>
            </div>
            <div class="modal-footer">
                <form id="form_del_page" action="{{route('pages.destroy',['id'=>$page->id])}}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE" />
                    <button type="button" class="btn btn-default" data-dismiss="modal"
                            onclick="document.getElementById('form_del_page').submit()">Sim
                    </button>
                </form>
                <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
            </div>
        </div>
    </div>
</div>