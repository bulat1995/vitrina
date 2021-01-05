<?php
/*
    Работа с фотографиями продукта
*/
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopProductPhoto;

use Illuminate\Support\Facades\Storage;

class ShopProductPhotoController extends Controller
{
    /**
     * Отображение списка фотографий продукта
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Удаление фотографии по идентификатору
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $photo=ShopProductPhoto::findOrFail($id);
        Storage::delete($photo->path);
        if($photo->delete()){
            return redirect()->back()->with(['success'=>'Фотография успешно удалена']);
        }
    }
}
