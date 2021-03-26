<?php
/*
    Репозиторий работы с ключами доступа
*/
namespace App\Http\Repositories;

use App\Http\Repositories\CoreRepository;
use App\Models\Permission as Model;


class PermissionRepository extends CoreRepository
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
        Отбор всех ключей доступа с метками для Роли
    */
    public function getAllPermissionWithMarks($role_id=0)
    {
        $columns=['permissions.id','permissions.name','permissions.action_name',\DB::raw("roles_permissions.role_id=$role_id as has")];
        $result=$this->startConditions()->
            leftJoin('roles_permissions',function($join) use($role_id){
                $join->on('permissions.id','=','roles_permissions.permission_id')
                    ->where('roles_permissions.role_id','=',$role_id);
            })->
            select($columns)->
            orderBy('name','ASC')->
            toBase()->
            get();
        return $result;
    }

    /*
        Отбор всех ключей доступа с метками для пользователя
    */
    public function getPermissionListForUser($user_id=0)
    {
        $columns=array(
            'permissions.id',
            'permissions.name',
            'permissions.action_name',
            \DB::raw("users_permissions.user_id= $user_id as has")

        );
        $result=$this->startConditions()->
        select($columns)->
        leftJoin('users_permissions',function($join) use ($user_id){
            $join->on('permissions.id','=','users_permissions.permission_id');
            $join->where('users_permissions.user_id','=',\DB::raw($user_id));
        })->
        toBase()->
        orderBy('name','ASC')->
        get();
        return $result;

    }


}
