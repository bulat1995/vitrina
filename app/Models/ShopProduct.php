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
            'param',
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
}
