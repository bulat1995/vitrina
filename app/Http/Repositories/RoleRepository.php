<?php
namespace App\Http\Repositories;

use App\Http\Repositories\CoreRepository;
use App\Models\Role as Model;


class RoleRepository extends CoreRepository
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

    public function getRolesWithMarks($user_id=0)
    {
        $columns=array(
                'roles.id',
                'roles.name',
                \DB::raw("users_roles.user_id=$user_id as has")
        );
        $result=$this->startConditions()->
            select($columns)->
            leftJoin('users_roles',function($join){
                $join->on('users_roles.role_id','=','roles.id');
            })->
            //where('users_roles.id',$user_id)->
            toBase()->
            get();

        return $result;
    }


}
