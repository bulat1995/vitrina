<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable=[
        'category',
        'title',
        'describe',
        'image',
        'buttonText',
        'href',
        'blank',
        'show',
        'rating',
        'show_until',
    ];
}
