<?php

namespace App\Observers;

use App\Models\ShopProduct;
use App\Models\ShopProductPhoto;
use Illuminate\Support\Facades\Storage;

class ShopProductObserver
{

    private $fileManager;


    public function __construct()
    {
        $this->fileManager=app('FileManagerService');
    }


    /**
     * Обработка модели перед созданием
     *
     * @param  \App\Models\ShopProduct  $shopProduct
     * @return void
     */
    public function creating(ShopProduct $shopProduct)
    {
        unset($shopProduct->param,$shopProduct->images);
        //$shopProduct->user=auth()->user()->id;
    }

    /**
     * Обработка модели после  создания
     *
     * @param  \App\Models\ShopProduct  $shopProduct
     * @return void
     */
    public function created(ShopProduct $shopProduct)
    {
        $shopProduct=$this->addPhotos($shopProduct);
    }

    /**
     * Обработка модели перед изменением данных
     *
     * @param  \App\Models\ShopProduct  $shopProduct
     * @return void
     */
    public function updating(ShopProduct $shopProduct)
    {
        unset($shopProduct->param,$shopProduct->images);
    }

    /*
    * Обработка модели после обновления
    */
    public function updated(ShopProduct $shopProduct)
    {
        $shopProduct=$this->addPhotos($shopProduct);
    }

    /**
     * Удаление модели вместе с фотографиями
     *
     * @param  \App\Models\ShopProduct  $shopProduct
     * @return void
     */
    public function deleting(ShopProduct $shopProduct)
    {
        foreach($shopProduct->photos as $photo){
            Storage::delete($photo->path);
        }
        $shopProduct->photos()->delete();
    }


    /*
        Добавление фотографий к продукту
    */
    private function addPhotos(ShopProduct $shopProduct)
    {

        $images=request()->images;
        if(!empty($images))
        {
            $photos=[];
            foreach($images as $photo){
                $image=new ShopProductPhoto();
                $image->path=$this->fileManager->upload($photo,config('my.product.folderName'));
                $photos[]=$image;
            }
            $shopProduct->photos()->saveMany($photos);
        }
        return $shopProduct;
    }

}
