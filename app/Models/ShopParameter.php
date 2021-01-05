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
        'required',
    ];

    public $timestamps=false;


    public const inputTypes=[
        'digits',
        'input',
        'textarea',
        'time',
        'date',
        'datetime',
        'site',
        'email',
        'phone',
    ];
}
