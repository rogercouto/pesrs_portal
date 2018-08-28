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
                        <input type="hidden" name="readed" value="{{$message->readed?'0':'1'}}" />
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
                        <button form="form_message_answered" type="submit" title="Marcar como respondida" class="btn btn-secondary"><i class="fa fa-reply"></i></button>
                    @else
                        <button form="form_message_answered" type="submit" title="Marcar como não respondida" class="btn btn-secondary"><i class="fa fa-file-excel"></i></button>
                    @endif
                </td>
            </tr>
        </table>
    </div>
    <div class="container">
        <a href="{{route('messages')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i>&nbsp;Voltar</a>
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