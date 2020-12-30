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


}
