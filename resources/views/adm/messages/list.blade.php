@extends('layouts.adm')
@section('content')
    <div class="container">
        @if(app('request')->input('page') && app('request')->input('page') > 1)
            <h4>Mostrando página {{app('request')->input('page')}} de {{$messages->lastPage()}}</h4>
        @else
            <h4>Mostrando as últimas {{sizeof($messages)}} mensagens</h4>
        @endif
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th scope="col" style="width:20%">De</th>
                <th scope="col" style="width:72%">Assunto</th>
                <th scope="col" style="width:18%"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($messages as $message)
                <tr @if(!$message->readed) style="background-color: #9fcdff;"@endif>
                    <td>
                        <span @if(!$message->readed) style="font-size: 14px;font-weight: bold;"@endif>{{$message->email}}</span>
                    </td>
                    <td>
                        <span @if(!$message->readed) style="font-size: 14px;font-weight: bold;"@endif>
                            {{$message->subject}}
                        </span>
                    </td>
                    <td>
                        <a class="btn btn-primary" title="Visualizar" href="{{route('messages.read',['id'=>$message->id])}}">
                            <i class="fa fa-eye"></i>
                        </a>
                        @if($message->answered != null)
                            <i class="fa fa-reply"></i>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$messages->links()}}
    </div>
@endsection