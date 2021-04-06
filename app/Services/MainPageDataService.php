<?php
/*
    Сервис формирования главной страницы проекта
    home.main
*/
namespace App\Services;
use App\Models\StaticPage;
use App\Models\ShopCategory;

use App\Models\SiteParameter;

class MainPageDataService
{

    //Параметры сайта
    private $parameters;

    //Последние новости
    private $lastNews;

    public function __construct()
    {
        //dd(__METHOD__);
    }

    /*
        Формирование верхнего меню
    */
    public function getTopMenu()
    {
        $menuItem=StaticPage::where('in_menu',true)->
        orderBy('rating','ASC')->
        toBase()->
        get();
        return $menuItem;
    }

    /*
        Последние 5 новостей для главной страницы
    */
    public function getLastNews()
    {
        if(empty($this->lastNews))
        {
            $this->lastNews=StaticPage::where('in_menu',true)->orderBy('created_at','DESC')->
            limit(5)->
            toBase()->
            get();
        }
        return $this->lastNews;
    }

    /*
    Получить список категорий
    */
    public function getCategoryList()
    {
        return ShopCategory::orderBy('_lft','ASC')->
        toBase()->
        orderBy('_lft','ASC')->
        get();
    }


    /*
        Получить значение параметра сайта
    */
    public function get($attr)
    {
        if(empty($this->parameters))
        {
            $par=SiteParameter::toBase()->get();
            foreach($par as $key){
                $this->parameters[$key->slug]=$key;
            }
        }
        return $this->parameters[$attr]->value??'SlugName:'.$attr;
    }

}
