<?php
/*
Контроллер для работы с сообщениями пользователей

 */
namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Repositories\MessageRepository;
use App\Http\Requests\MessageRequest;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageAdminController extends Controller
{

    private $repository;

    public function __construct()
    {
        $this->repository = new MessageRepository();
    }

    /**
     * Отображение сообщений отправленных самому себе (Заметки)
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->show();
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
        $message->recepient = $request->input('user');
        $message->save();
        return redirect()->back();
    }

    /**
     * Отображение страницы
     * переписки с пользователем по его идентификатору.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
        $id          = ($id == null) ? auth()->user()->id : $id;
        $editMessage = new Message();
        $user        = User::findOrFail($id);

        $users    = $this->repository->getPartners();
        $messages = $this->repository->getMessagesByUserId($id);
        $this->repository->setReadedMessage($id);
        return view('admin.user.message.show', compact('messages', 'user', 'users', 'editMessage'));
    }

    /*
    Форма редактирования сообщения
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
            return view('admin.user.message.show', compact('editMessage', 'user', 'messages', 'users'));
        } else {
            return redirect()->back();
        }
    }

    /*
    Обновление сообщения
     */
    public function update(MessageRequest $request, $id)
    {
        $message = Message::whereId($id)->
            whereSender(auth()->user()->id)->
            where('readed', 0)->first();

        if (!empty($message)) {
            $message->message = $request->input('message');
            $message->save();
            return redirect()->route('admin.messages.show', $message->recepient);
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
