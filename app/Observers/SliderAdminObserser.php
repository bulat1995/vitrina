<?php

namespace App\Observers;

use App\Models\Slider;

class SliderAdminObserser
{

    private  $fileManager;

    public function __construct()
    {
        $this->fileManager=app('FileManagerService');
    }
    /**
     * Handle the Slider "created" event.
     *
     * @param  \App\Models\Slider  $slider
     * @return void
     */
    public function creating(Slider $slider)
    {

        if(!empty(request()->file('image'))){
            $slider->image=$this->fileManager->upload(request()->file('image'),config('my.slider.folderName'));
        }
    }

    /**
     * Handle the Slider "updated" event.
     *
     * @param  \App\Models\Slider  $slider
     * @return void
     */
    public function updating(Slider $slider)
    {
        if(!empty(request()->file('image'))){
            $this->fileManager->deleteFile($slider->image);
            $slider->image=$this->fileManager->upload(request()->file('image'),config('my.slider.folderName'));
        }
    }

    /**
     * Handle the Slider "deleted" event.
     *
     * @param  \App\Models\Slider  $slider
     * @return void
     */
    public function deleted(Slider $slider)
    {
         $this->fileManager->deleteFile($slider->image);
    }

    /**
     * Handle the Slider "restored" event.
     *
     * @param  \App\Models\Slider  $slider
     * @return void
     */
    public function restored(Slider $slider)
    {
        //
    }

    /**
     * Handle the Slider "force deleted" event.
     *
     * @param  \App\Models\Slider  $slider
     * @return void
     */
    public function forceDeleted(Slider $slider)
    {
         $this->fileManager->deleteFile($slider->image);
    }

}
