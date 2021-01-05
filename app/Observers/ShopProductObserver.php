<?php

namespace App\Observers;

use App\Models\ShopProduct;
use App\Models\ShopProductPhoto;
use Illuminate\Support\Facades\Storage;

class ShopProductObserver
{

    /**
     * Обработка модели перед созданием
     *
     * @param  \App\Models\ShopProduct  $shopProduct
     * @return void
     */
    public function creating(ShopProduct $shopProduct)
    {
        unset($shopProduct->param,$shopProduct->images);
        $shopProduct->user=auth()->user()->id;
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
        $shopProduct=$this->refreshParameters($shopProduct);
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
        $shopProduct=$this->refreshParameters($shopProduct);
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
        Обновление параметров продукта
    */
    private function refreshParameters(ShopProduct $shopProduct)
    {
        $parameters=request()->param;
        if(!empty($parameters))
        {
            $shopProduct->parameters()->detach();
            foreach($parameters as $charact=>$value){
                $newCharacteristics[$charact]=['value'=>$value];
            }
            $shopProduct->parameters()->attach($newCharacteristics);
        }
        return $shopProduct;
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
                $image->path=$photo->store('category','public');
                $photos[]=$image;
            }
            $shopProduct->photos()->saveMany($photos);
        }
        return $shopProduct;
    }

}
