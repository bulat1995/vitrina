<?php
/*
    Сервис используемый в шаблонизаторе через inject
    main.admin

*/

namespace App\Services;

use App\Http\Repositories\MessageRepository;

class MessageDataService
{
    private $repository;

    public function __construct()
    {
        $this->repository=new MessageRepository();
    }

    /*
        Количество новых сообщений
    */
    public function getCountNewMessages()
    {
        return $this->repository->getNewCountMessages();
    }

    /*
        Список пользователей с кем ведется беседа
    */
    public function partnersBlock()
    {
        return $this->repository->getPartners();
    }
}
