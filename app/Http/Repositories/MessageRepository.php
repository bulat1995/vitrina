<?php
/*
    Репозиторий сообщений
*/
namespace App\Http\Repositories;

use App\Http\Repositories\CoreRepository;
use App\Models\Message as Model;


class MessageRepository extends CoreRepository
{
    protected $model;

    public function __construct()
    {
        parent::__construct();
    }

    protected function getModelClass()
    {
        return Model::class;
    }


    /*
        Сообщения между текущим пользователем
        и пользователем с идентификатором $userId
        return Message[]
    */
    public function getMessagesByUserId($userId)
    {
        $result=$this->startConditions()->
                where(function ($where) use($userId){
                    $where->where('sender',auth()->user()->id);
                    $where->where('recepient',$userId);
                })->
                orWhere(function ($where) use($userId){
                    $where->where('sender',$userId);
                    $where->where('recepient',auth()->user()->id);
                })->
                orderBy('created_at','ASC')->
                toBase()->
                get();
        return $result;
    }

    /*
        Установка метки "сообщение прочитано"
        по идентификатору пользователя
        return void
    */
    public function setReadedMessage($userId)
    {
        return $this->startConditions()->
            where('recepient',auth()->user()->id)->
            where('sender',$userId)->
            toBase()->
            update(['readed'=>1]);
    }

    /*
        Список пользователей
        с которым текущий пользователь переписывался
    */
    public function getPartners(){
        $userId=auth()->user()->id;

        $columns=array(
            'users.id',
            'users.name',
            'users.firstName',
            'users.secondName',
            'users.avatar',
            'messages.message',
            \DB::raw('COUNT(readed=0) as unread'),
            \DB::raw('messages.created_at as last_message'),
        );

        $result=\DB::table('users')->
                select($columns)->
                leftJoin('messages',function($where) use($userId){
                    $where->on('sender','=','users.id');
                    $where->where('recepient','=',$userId);
                    $where->where('readed','=',0);
                })->

                where('users.id','<>',$userId)->
                groupBy('users.id')->
                orderBy('messages.created_at','DESC')->
                get();
        return $result;
    }

    /*
        Общее количество новых сообщений
    */
    public function getNewCountMessages()
    {
        return $this->startConditions()->
            where('recepient',auth()->user()->id)->
            where('readed',0)->
            toBase()->
            get()->count();
    }

    /*
        Поиск сообщения по ключевому слову
    */
    public function findByKeyword($key)
    {
        $columns=array(
            \DB::raw('users2.name AS recepient'),
            \DB::raw('users2.id AS recepient_id'),
            \DB::raw('users2.avatar AS recepient_avatar'),
            \DB::raw('users.avatar AS sender_avatar'),
            \DB::raw('users.name AS sender'),
            \DB::raw('users.id AS sender_id'),
            \DB::raw('message AS message'),
            \DB::raw('messages.created_at AS created_at'),
        );

        $result=$this->startConditions()->
            select($columns)->
            leftJoin('users',function($join){
                $join->on('users.id','=','sender');
            })->
            leftJoin(\DB::raw('users as users2'),function($join){
                $join->on('users2.id','=','recepient');
            })->
            where('message','like',$key)->
            where(function($where){
                $where->where('sender',auth()->user()->id);
                $where->orWhere('recepient',auth()->user()->id);
            })->
            get();
        return $result;
    }

}
