<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ShopProduct extends Model
{
    use HasFactory;

    protected $fillable=[
            'name',
            'price',
            'category_id',
            'parameters',
            'images'
    ];


    public function parameters()
    {
        return $this->belongsToMany('App\Models\ShopParameter','product_parameters','product_id','parameter_id')->withPivot('value');
    }


    public function photos()
    {
        return $this->hasMany('App\Models\ShopProductPhoto','product_id');
    }



    //ПЕРЕДЕЛАЙ !!!!
    public function cart()
    {
        return $this->hasOne('App\Models\ShopCart','product_id');
    }


    public function setParametersAttribute($param)
    {
        if(!empty($param)){
            $this->parameters()->detach();
            foreach($param as $charact=>$value){
                $newCharacteristics[$charact]=['value'=>$value];
            }
            $this->parameters()->attach($newCharacteristics);
        }

    }


}
