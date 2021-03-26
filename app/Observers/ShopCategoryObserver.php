<?php

namespace App\Observers;

use App\Models\ShopCategory;
use App\Http\Repositories\ShopCategoryRepository;
use Illuminate\Support\Facades\Storage;
class ShopCategoryObserver
{
    private $repository;

    private $fileManager;

    public function __construct()
    {
        $this->repository=app(ShopCategoryRepository::class);
        $this->fileManager=app('FileManagerService');

    }



    public function creating(ShopCategory $shopCategory)
    {
        $item=$this->repository->getNodeById($shopCategory->parent_id);
        $shopCategory->_lvl=(!empty($item))?$item->_lvl+1:1;
        $rightPosition=$this->repository->getNewPosition($shopCategory,$item);
        $shopCategory->_lft=$rightPosition+1;
        $shopCategory->_rgt=$rightPosition+2;
        $this->repository->attract($rightPosition,2);

        if(!empty(request()->file('logo'))){
            $shopCategory->logoPath=$this->fileManager->upload(request()->file('logo'),config('my.category.folderName'));
        }

    }

    /**
     * Handle the ShopCategory "created" event.
     *
     * @param  \App\Models\ShopCategory  $shopCategory
     * @return void
     */
    public function created(ShopCategory $shopCategory)
    {
    }

    /**
     * Handle the ShopCategory "updated" event.
     *
     * @param  \App\Models\ShopCategory  $shopCategory
     * @return void
     */
    public function updating(ShopCategory $shopCategory)
    {

        if($shopCategory->isDirty('parent_id')){
            $item=$this->repository->getNodeById($shopCategory->parent_id)??null;
            $this->repository->move($shopCategory,$item);
        }

        if(!empty(request()->file('logo'))){
            $this->fileManager->deleteFile(config('my.category.filePath').$shopCategory->logoPath);
            $shopCategory->logoPath=$this->fileManager->upload(request()->file('logo'),config('my.category.folderName'));
        }

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
        $this->fileManager->deleteFile(config('my.category.filePath').$shopCategory->logoPath);
    }


}
