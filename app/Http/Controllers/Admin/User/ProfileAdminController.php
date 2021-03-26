<?php
/*
    Контроллер работы с пользователями
*/
namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Repositories\RoleRepository;
use App\Http\Repositories\PermissionRepository;

use App\Http\Requests\ProfileAdminRequest;
use Illuminate\Support\Facades\Storage;

class ProfileAdminController extends Controller
{

    //Репозиторий ролей
    private $roleRepository;
    //Репозиторий ключей доступа
    private $permissionRepository;

    public function __construct()
    {
        $this->roleRepository=app(RoleRepository::class);
        $this->permissionRepository=app(PermissionRepository::class);
    }

    /**
     * Список пользователей
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::with('roles')->get()->toArray();
        return view('admin.user.profile.index',compact('users'));
    }


    /**
     * Профиль пользователя
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id=null)
    {
        $user=($id==null)?auth()->user() :User::whereId($id)->with(['roles','permissions'])->first();
        if(empty($user))
        {
            abort(404);
        }
        return view('admin.user.profile.show',compact('user'));
    }



    /**
     * Форма редактирования пользователя системы
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user,$id)
    {
        $user=User::findOrFail($id);
        $roles=$this->roleRepository->getRolesWithMarks($user->id);

        $permissions=$this->permissionRepository->getPermissionListForUser($user->id);
        return view('admin.user.profile.form',compact('user','roles','permissions'));
    }

    /**
     * ОБновление данных пользователя
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileAdminRequest $request, $id)
    {
        $user=User::findOrFail($id);
        $data=$request->input();
        $user->fill($data);
        //dd($user);
        $result=$user->save();
        if($result)
        {
            return redirect()->route('admin.profiles.edit',$user->id)->
            with(['success'=>"Данные успешно сохранены"]);
        }
        else{
            return redirect()->back()->withInput()->
                withErrors(['msg'=>'Ошибка сохранения пользователя']);
        }
    
    }


    /**
     * Удаление пользователя из системы
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user,$id)
    {
        $user=User::findOrFail($id);
        if($user->delete())
        {
            return redirect()->
                    route('admin.profiles.index')->
                    with(['success'=>"Пользователь  $user->username успешно удален"]);
        }
        return redirect()->back();
    }

    /*
        Удаление фотографии пользователя
    */
    public function deleteAvatar($user_id)
    {
        $user=User::findOrFail($user_id);
        if(Storage::delete($user->avatar))
        {
            $user->avatar=null;
            $user->save();
        }
        return redirect()->
            route('admin.profiles.edit',$user->id);
    }
}
