<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteParameter extends Model
{
    use HasFactory;

    protected $fillable=[
        'slug',
        'name',
        'value',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
