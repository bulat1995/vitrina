<?php
/*
    Контроллер сообщений с администратором сайта
 */
namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Repositories\MessageRepository;
use App\Http\Requests\MessageRequest;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class ShopMessageController extends Controller
{
    //Репозиторий сообщений
    private $repository;

    public function __construct()
    {
        $this->middleware('auth');
        $this->repository = new MessageRepository();
    }

    /**
     * Отображение страницы сообщений 
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id  = auth()->user()->id;
        $messages = $this->repository->getMessagesByUserId($user_id);
        $this->repository->setReadedMessage($user_id);
        $editMessage = new Message();
        $user        = User::findOrFail(1);
        return view('shop.message.show', compact('messages', 'user', 'editMessage'));
    }

    /**
     * Формирование нового сообщения.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MessageRequest $request)
    {
        
        $message            = new Message();
        $message->message   = $request->input('message');
        $message->sender    = auth()->user()->id;
        $message->readed    = 0;
        $message->recepient = 1;
        $message->save();
        return redirect()->route('shop.messages.index');
    }

    /*
     *   Вывод формы редактирования сообщения
     */
    public function edit($id)
    {
        $editMessage = Message::whereId($id)->
            whereSender(auth()->user()->id)->
            whereReaded(0)->
            first();

        if (!empty($editMessage)) {
            $user     = User::findOrFail($editMessage->recepient);
            $messages = $this->repository->getMessagesByUserId($editMessage->recepient);
            $users    = $this->repository->getPartners();
            return view('shop.message.show', compact('editMessage', 'user', 'messages', 'users'));
        } else {
            return redirect()->back();
        }
    }

    /**
    * Обновление сообщения
     */
    public function update(MessageRequest $request, $id)
    {


        $message = Message::whereId($id)->
            whereSender(auth()->user()->id)->
            where('readed', 0)->first();

        if (!empty($message)) {
            $message->message = $request->input('message');
            $message->save();
            return redirect()->route('shop.messages.index', $message->recepient);
        } else {
            return redirect()->back();
        }
    }


    /**
     * Удаление сообщения
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $messageId)
    {

        $recepient = $request->input('recepient');
        $messageId = $request->input('id');
        $message   = Message::where('sender', '=', auth()->user()->id)->
            where('recepient', '=', (int) $recepient)->
            where('id', '=', (int) $messageId)->
            first();
        if (!empty($message)) {
            $message->delete();
        }
        return redirect()->back();
    }
}
