<?php
/*
    Работа с фотографиями продукта
*/
namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopProductPhoto;

use Illuminate\Support\Facades\Storage;

class ShopProductPhotoAdminController extends Controller
{

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
