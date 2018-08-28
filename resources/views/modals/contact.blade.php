<!--
    Modal for banner limit message
-->
<div class="modal fade" id="modal_message" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Fale conosco</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="form_message" method="POST" enctype="multipart/form-data" action="{{route('messages.send')}}">
                    @csrf
                    <div class="form-group">
                        <label for="input_mail">E-mail:</label>
                        <input id="input_email" type="text" name="email" onkeyup="verifyForm(this.id)" onfocusout="verifyEmail()" class="form-control">
                        <span id="span_email_empty" style="color: red;display: none;">E-mail deve ser informado!</span>
                        <span id="span_email_invalid" style="color: red;display: none;">E-mail invalido!</span>
                    </div>
                    <div class="form-group">
                        <label for="input_subject">Assunto:</label>
                        <input id="input_subject" type="text" name="subject" onkeyup="verifyForm(this.id)" onfocusout="verifySubject()" class="form-control">
                        <span id="span_subject_empty" style="color: red;display: none;">Assunto deve ser informado!</span>
                    </div>
                    <div class="form-group">
                        <label for="input_content">Mensagem:</label>
                        <textarea id="input_content" rows="5" name="content" onkeyup="verifyForm(this.id)" onfocusout="verifyContent()" class="form-control"></textarea>
                        <span id="span_content_empty" style="color: red;display: none;">Conteúdo da mensagem não pode ficar em branco!</span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btn_send" type="button" class="btn btn-default" data-dismiss="modal"
                        onclick="document.getElementById('form_message').submit()" disabled="disabled">
                    Enviar
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>