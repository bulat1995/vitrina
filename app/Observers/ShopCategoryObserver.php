<?php

namespace App\Observers;

use App\Models\ShopCategory;
use App\Http\Repositories\ShopCategoryRepository;
use Illuminate\Support\Facades\Storage;
class ShopCategoryObserver
{
    private $repository;

    public function __construct()
    {
        $this->repository=app(ShopCategoryRepository::class);
    }



    public function creating(ShopCategory $shopCategory)
    {
        $item=$this->repository->getNodeById($shopCategory->parent_id);
        $shopCategory->_lvl=(!empty($item))?$item->_lvl+1:1;
        $rightPosition=$this->repository->getNewPosition($shopCategory,$item);
        $shopCategory->_lft=$rightPosition+1;
        $shopCategory->_rgt=$rightPosition+2;
        $this->repository->attract($rightPosition,2);

        $shopCategory=$this->logoAndParametersUpdate($shopCategory);
        //dd(__METHOD__,$shopCategory);
    }

    /**
     * Handle the ShopCategory "created" event.
     *
     * @param  \App\Models\ShopCategory  $shopCategory
     * @return void
     */
    public function created(ShopCategory $shopCategory)
    {
        $shopCategory=$this->logoAndParametersUpdate($shopCategory);
    }

    /**
     * Handle the ShopCategory "updated" event.
     *
     * @param  \App\Models\ShopCategory  $shopCategory
     * @return void
     */
    public function updating(ShopCategory $shopCategory)
    {
        $this->deleteLogo($shopCategory);
        if($shopCategory->isDirty('parent_id')){
            $item=$this->repository->getNodeById($shopCategory->parent_id)??null;
            $this->repository->move($shopCategory,$item);
        }
        $shopCategory=$this->logoAndParametersUpdate($shopCategory);
        dd(__METHOD__);
    }


    /**
     * Handle the ShopCategory "deleted" event.
     *
     * @param  \App\Models\ShopCategory  $shopCategory
     * @return void
     */
    public function deleted(ShopCategory $shopCategory)
    {
        //
    }



    public function forceDeleting(ShopCategory $shopCategory)
    {
        $this->deleteLogo($shopCategory,true);
    }


    /*
        Удаление изображения из хранилища
        $removeForce - принудительно
    */
    private function deleteLogo(ShopCategory $shopCategory, $removeForce=false)
    {
        //Удаление старого изображения
        if($shopCategory->isDirty('logoPath') || $removeForce)
        {
            $path=$shopCategory->getOriginal('logoPath');
            if(!empty($path)){
                Storage::delete($shopCategory->getOriginal('logoPath'));
            }
        }
    }

    /*
        Обновление Логотипа и Параметров Категорий
    */
    private function logoAndParametersUpdate(ShopCategory $shopCategory)
    {
        $file=request()->file('logo');
        if(!empty($file)){
            $shopCategory->logoPath=$file->store('category','public');
        }
        unset($shopCategory->parametersId);
        if(!empty($shopCategory->id))
        {
            $shopCategory->parameters()->detach();
            $shopCategory->parameters()->attach(request()->route()->parametersId);
        }
        return $shopCategory;
    }


}
