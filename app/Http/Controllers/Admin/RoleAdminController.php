<?php
/*
*   Контроллер управления ролями
*/
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\Role;
use App\Models\Permission;
use App\Http\Repositories\PermissionRepository;

class RoleAdminController extends Controller
{
    private $permissionRepository;

    public function __construct()
    {
        $this->permissionRepository=new PermissionRepository;
    }

     /**
     * Отображение списка ролей
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items=Role::toBase()->get();
        return view('admin.role.index',compact('items'));
    }

    /**
     * Отображение формы создания роли
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role=new Role();
        $permissions=$this->permissionRepository->getAllPermissionWithMarks();
        return view('admin.role.form',compact('role','permissions'));
    }

    /**
     * Формирование новой роли
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $data=$request->input();
        $role=new Role($data);
        $role->save();
        return redirect()->route('admin.roles.index')->with([
            'success'=>'Роль "'.$role->name.'" успешно добавлена'
        ]);
    }

    /**
     * Страница просмотра роли
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role=Role::whereId($id)->with(['users','permissions'])->first();
        return view('admin.role.show',compact('role'));
    }

    /**
     * Отображение формы редактирования роли
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role=Role::findOrFail($id);
        $permissions=$this->permissionRepository->getAllPermissionWithMarks($id);
        return view('admin.role.form',compact('role','permissions'));
    }

    /**
     * Обновление данных роли
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        $role=Role::findOrFail($id);
        $data=$request->all();
        $role->fill($data);
        $role->save();
        if($role)
        {
            return redirect()->route('admin.roles.index')->with([
                'success'=>'Роль "'.$role->name.'" успешно отредактирована'
            ]);
        }
    }

    /**
     * Удаление роли
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role=Role::findOrFail($id);
        if($role->delete())
        {
            return redirect()->route('admin.roles.index')->with([
                'success'=>'Роль "'.$role->name.'" успешно удалена'
            ]);
        }
    }
}
