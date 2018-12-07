@extends('layouts.adm')
@section('content')
    <div class="container" style="padding: 25px 75px 25px 75px;">
        <table>
            <tr>
                <td class="label-td">De:</td>
                <td class="text-td">{{$message->email}}</td>
            </tr>
            <tr>
                <td class="label-td">Assunto:</td>
                <td class="text-td">{{$message->subject}}</td>
            </tr>
            <tr>
                <td class="label-td">Mensagem:</td>
                <td class="text-td">{{$message->content}}</td>
            </tr>
            <tr>
                <td class="label-td"></td>
                <td class="text-td">
                    <form id="form_message_readed" method="POST" action="{{route('messages.setreaded',['id'=>$message->id])}}">
                       @csrf
                        <input type="hidden" name="_method" value="PUT" />
                        <input type="hidden" name="readed" value="Mensagem: {{$message->readed?'0':'1'}}" />
                    </form>
                    <form id="form_message_answered" method="POST" action="{{route('messages.setanswered',['id'=>$message->id])}}">
                        @csrf
                        <input type="hidden" name="_method" value="PUT" />
                        <input type="hidden" name="answered" value="{{$message->answered?'0':'1'}}" />
                    </form>
                    @if($message->readed)
                        @if($message->answered == null)
                            <button form="form_message_readed" type="submit" title="Marcar como não lida" class="btn btn-secondary"><i class="fa fa-eye-slash"></i></button>
                        @endif
                    @else
                        <button form="form_message_readed" type="submit" title="Marcar como lida" class="btn btn-secondary"><i class="fa fa-eye"></i></button>
                    @endif
                    @if($message->answered == null)
                        <button form="form_message_answered" type="submit" title="Marcar como respondida" class="btn btn-secondary"><i class="fa fa-check"></i></button>
                    @else
                        <button form="form_message_answered" type="submit" title="Marcar como não respondida" class="btn btn-secondary"><i class="fa fa-file-excel"></i></button>
                    @endif
                    <button id="btn_message" type="submit" title="Responder" class="btn btn-secondary"><i class="fa fa-reply"></i></button>
                </td>
            </tr>
        </table>
    </div>
    <div class="container">
        <a href="{{route('messages')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i>&nbsp;Voltar</a>
    </div>
    <div class="modal fade" id="modal_message" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Responder</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>{{$message->content}}</p>
                    <form id="form_message" method="POST" enctype="multipart/form-data" action="{{route('messages.answer',['id'=>$message->id])}}">
                        @csrf
                        <div class="form-group">
                            <label for="input_subject">Assunto:</label>
                            <input id="input_subject" type="text" name="subject" value="RE: {{$message->subject}}" onkeyup="verifyForm(this.id)" onfocusout="verifySubject()" class="form-control">
                            <span id="span_subject_empty" style="color: red;display: none;">Assunto deve ser informado!</span>
                        </div>
                        <div class="form-group">
                            <label for="input_content">Resposta:</label>
                            <textarea id="input_content" rows="5" name="content" onkeyup="verifyForm(this.id)" onfocusout="verifyContent()" class="form-control"></textarea>
                            <span id="span_content_empty" style="color: red;display: none;">Conteúdo da resposta não pode ficar em branco!</span>
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
@endsection
@push('libs')
    <style type="text/css">
        .label-td{
            text-align: right;
            padding: 10px 5px 10px 15px;
            vertical-align: top;
            font-size: 14px;
            font-weight: bold;
        }
        .text-td{
            vertical-align: top;
            padding: 10px 15px 10px 5px;
            font-size: 14px;
        }
    </style>
@endpush
@push('scripts')
    <script type="text/javascript">
        function verifyForm(id){
            switch (id){
                case "input_subject": verifySubject(); break;
                case "input_content": verifyContent(); break;
            }
            var subject = document.getElementById("input_subject").value;
            if (subject == ""){
                document.getElementById("btn_send").disabled = true;
                return;
            }
            var content = document.getElementById("input_content").value;
            if (content == ""){
                document.getElementById("btn_send").disabled = true;
                return;
            }
            document.getElementById("btn_send").disabled = false;
        }
        function verifySubject(){
            var subject = document.getElementById("input_subject").value;
            if (subject == ""){
                document.getElementById("span_subject_empty").style.display = "block";
            }else{
                document.getElementById("span_subject_empty").style.display = "none";
            }
        }
        function verifyContent(){
            var content = document.getElementById("input_content").value;
            if (content == ""){
                document.getElementById("span_content_empty").style.display = "block";
            }else{
                document.getElementById("span_content_empty").style.display = "none";
            }
        }
        $(document).ready(function(){
            $("#btn_message").click(function(){
                $("#modal_message").modal();
            });
        });
    </script>
@endpush