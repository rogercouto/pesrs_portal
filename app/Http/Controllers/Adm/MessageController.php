<?php

namespace App\Http\Controllers\Adm;

use App\Services\MessageService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class MessageController extends Controller
{

    private $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function send(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'subject' => 'required',
            'content' => 'required'
        ]);
        //ver como valida e-mail posteriormente
        $this->messageService->send($request);
        return Redirect::route('main')
            ->with("message","Mensagem enviada! Em breve entraremos em contato.")
            ->with("message-type","success");
    }

    public function index()
    {
        $data['title'] = 'Mensagens recebidas';
        $data['messages'] = $this->messageService->getPageList();
        return view('adm.messages.list', $data);
    }

    public function show(int $id)
    {
        $data['title'] = "Detalhes mensagem Nº: $id";
        $data['message'] = $this->messageService->get($id);
        return view('adm.messages.details', $data);
    }

    public function read(int $id)
    {
        $data['title'] = "Detalhes mensagem Nº: $id";
        $data['message'] = $this->messageService->get($id);
        $this->messageService->setReaded($data['message'], true);
        return view('adm.messages.details', $data);
    }

    public function setReaded(Request $request, int $id)
    {
        $readed = $request->input('readed');
        $message = $this->messageService->get($id);
        $this->messageService->setReaded($message, $readed);
        return Redirect::route('messages.show',['id'=>$id])
            ->with("message","Concluído!")
            ->with("message-type","success");
    }

    public function setAnswered(Request $request, int $id)
    {
        $answered = $request->input('answered');
        $message = $this->messageService->get($id);
        $this->messageService->setAnswered($message, $answered);
        return Redirect::route('messages.show',['id'=>$id])
            ->with("message","Concluído!")
            ->with("message-type","success");
    }

}
