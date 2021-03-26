<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopParameter extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'inputType',
        'regular',
        'rating',
        'required',
    ];

    public $timestamps=false;


    public const inputTypes=[
        'digit',
        'text',
        'date',
        'url',
        'option',
        // 'groups',
    ];

    public function categories()
    {
            return $this->belongsToMany('App\Models\ShopCategory','shop_category_shop_parameter','parameter_id','category_id');
    }
}
