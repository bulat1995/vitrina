<?php
/*
    Сообщения пользователя
*/
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Message extends Model
{
    use HasFactory;

    /*
        Отправитель сообщения
    */
    public function sender()
    {
        return $this->hasOne(User::class,'id');
    }
    /*
        Получатель сообщения
    */
    public function recepient()
    {
        return $this->hasOne(User::class,'id');
    }
}
