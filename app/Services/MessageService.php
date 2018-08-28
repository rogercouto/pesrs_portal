<?php

namespace App\Services;

use DateTime;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageService
{

    private const PAGE_SIZE = 5;

    /**
     * @param Request $request
     * @return Message send
     */
    public function send(Request $request):Message
    {
        return Message::create($request->all());
    }

    public function setReaded(Message $message, bool $readed)
    {
        $message->readed = $readed;
        $message->save();
    }

    public function setAnswered(Message $message, bool $answered)
    {
        $message->answered = ($answered) ? new DateTime() : null;
        $message->save();
    }

    public function get(int $id)
    {
        return Message::where('id',$id)->firstOrFail();
    }

    public function getAll()
    {
        return Message::all();
    }

    public function getPageList()
    {
        return Message::orderBy('readed', 'ASC')->orderBy('id', 'DESC')->paginate(self::PAGE_SIZE);
    }

}