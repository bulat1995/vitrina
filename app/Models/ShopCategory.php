<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ShopParameter;

class ShopCategory extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=[
        'name',
        'parent_id',
        'is_public',
        'parameters',
        'logoPath',
    ];

    public function parameters()
    {
        return $this->belongsToMany('App\Models\ShopParameter','shop_category_shop_parameter','category_id','parameter_id');
    }

    public function products()
    {
        return $this->hasMany(ShopProduct::class,'category_id');
    }

    public function setParametersAttribute($value)
    {
        $this->parameters()->detach();
        $this->parameters()->attach($value);
    }
}
