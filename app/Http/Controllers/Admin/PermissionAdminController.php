<?php
/*
*    Контроллер работы с ключами доступа
*/

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Http\Requests\PermissionRequest;


class PermissionAdminController extends Controller
{
    /**
     * Отображение всех ключей
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items=Permission::orderBy('name','ASC')->toBase()->get();
        return view('admin.permission.index',compact('items'));
    }

    /**
     * Отображение формы создания ключа
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission=new Permission();
        return view('admin.permission.form',compact('permission'));
    }

    /**
     * Формирование нового ключа
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        $permission=new Permission();
        $data=$request->input();
        $result=$permission->create($data);
        if($result)
        {
            return redirect()->route('admin.permissions.edit',$result->id)->with([
                'success'=>'Данные сохранены'
            ]);
        }
        else{
            return redirect()->back()->withErrors([
                'msg'=>'Ошибка сохранения'
            ])
            ->withInput();
        }
    }


    /**
     * Отображение формы редактирования
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission=Permission::findOrFail($id);
        if(!$permission->changeable){
            abort(403,'system value ');
        }
        return view('admin.permission.form',compact('permission'));
    }

    /**
     * Обновление данных
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, $id)
    {
        $permission=Permission::findOrFail($id);
        if(!$permission->changeable){
            abort(403,'system value ');
        }
        $data=$request->input();
        $permission->fill($data);
        if($permission->save())
        {
            return redirect()->route('admin.permissions.edit',$id)->with([
                'success'=>'Данные сохранены'
            ]);
        }
        else{
            return redirect()->back()->withErrors([
                'msg'=>'Ошибка сохранения'
            ])
            ->withInput();
        }
    }

    /**
     * Удаление ключа
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission=Permission::findOrFail($id);
        if(!$permission->changeable){
            redirect()->route('admin.permissions.index')->withErrors(['msg'=>'Невозможно удалить данный ключ']);
        }
        if($permission->delete()){
            return redirect()->route('admin.permissions.index');
        }
    }
}
