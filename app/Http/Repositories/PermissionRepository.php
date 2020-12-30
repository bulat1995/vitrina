<?php
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
        $columns=['permissions.id','permissions.name',\DB::raw("roles_permissions.role_id=$role_id as has")];
        $result=$this->startConditions()->
            leftJoin('roles_permissions',function($join) use($role_id){
                $join->on('permissions.id','=','roles_permissions.permission_id')
                    ->where('roles_permissions.role_id','=',$role_id);
            })->
            select($columns)->
            orderBy('slug','ASC')->
            toBase()->
            get();
        return $result;
    }


}
