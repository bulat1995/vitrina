<?php
/*
    Класс обработки загруженных файлов
*/

namespace App\Services;
use Illuminate\Support\Facades\Storage;

class FileManagerService extends Storage
{

    //Диск используемый по умолчанию
    private $defaultDisc;


    public function __construct()
    {
        $this->defaultDisc='public';
    }


    /*
        Смена диска
    */
    public function changeDisc($newPath)
    {
        $this->defaultDisc=$newPath;
    }


    /*
        Загрузка файла в папку
        @return string filePath
    */
    public function upload($file,$folder)
    {
        $fileName=pathinfo($file->store($folder,$this->defaultDisc))['basename'];
        return $fileName;
    }


    /*
        Удаление файла
    */
    public function deleteFile($filePath)
    {
        $deleted=Storage::delete($filePath);
        
        if($deleted){
            return true;
        }
        else{
            return false;
        }

    }

}
