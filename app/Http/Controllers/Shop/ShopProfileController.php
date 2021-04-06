<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShopProfileRequest;

class ShopProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Отображение профиля пользователя
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=auth()->user();
        return view('shop.profile.show',compact('user'));
    }

    /**
     * ОТображение формы редактирования профиля пользователя
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {  
        $user=auth()->user();
        $user->password=null;
        return view('shop.profile.form',compact('user'));
    }

    /**
     * Обновление данных пользователя
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShopProfileRequest $request, $id=null)
    {
        if($id!=auth()->user()->id){
            return redirect()->back();
        }

        $user=User::findOrFail(auth()->user()->id);
        $user->fill($request->except(['password']));
        $user->touch();
        if($user->save()){
            return redirect()->route('shop.profile.index')->with([
                'success'=>'Профиль успешно отредактирован'
            ]);
        }
        return redirect()->back();
    }

    /**
    *   Удаление аватарки пользователя
    *
    *
    */
    public function deleteAvatar(Request $request)
    {
        $user=User::findOrFail(auth()->user()->id);
        $fileManager=app('FileManagerService');
        if(!empty($user->avatar)){
            if($fileManager->deleteFile(config('my.user.folder').$user->avatar)){
                $user->avatar=null;
                $user->save();
            }
            return redirect()->route('shop.profile.index')->with([
                    'success'=>'Профиль успешно отредактирован'
                ]);
        }
        return redirect()->back();
    }
}
