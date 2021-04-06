<?php
/*
    Конфигурационный файл проекта

*/
return array(
    //Основные проекта проекта
    'global'=>array(
        'path'=>array(
                'image_not_available'=>'/images/no_image_available.png'
        ),
        //Список существуюих локализаций
        'language'=>array(
            'default'=>'ru',
            'list'=>array('ru'=>'Русский','en'=>'English','it'=>'Italian'),
        ),
    ),
    //Категория
    'category'=>array(
        'folderName'=>'category',
        'filePath'=>'public/storage/category/',
        'filePathWeb'=>'/storage/category/',
        'itemsCountInPage'=>20,
    ),
    //Товары
    'product'=>array(
        'folderName'=>'product',
        'filePath'=>'public/storage/product/',
        'filePathWeb'=>'/storage/product/',
        'itemsCountInPage'=>20,
        'photo'=>array(
            'filePath'=>'public/storage/product/',
            'filePathWeb'=>'/storage/product/',
        ),
    ),
    //Слайдеры
    'slider'=>array(
        'folderName'=>'slider',
        'filePath'=>'public/storage/slider/',
        'filePathWeb'=>'/storage/slider/',
        'itemsCountInPage'=>20,
    ),
    'user'=>array(
        'folderName'=>'user',
        'folder'=>'/user/',
        'filePath'=>'public/storage/user/',
        'filePathWeb'=>'/storage/user/',
        'itemsCountInPage'=>20,
    ),
);
