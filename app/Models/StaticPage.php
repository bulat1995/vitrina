<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaticPage extends Model
{
    use HasFactory;

    protected $fillable=[
            'title',
            'slug',
            'content',
            'describe',
            'rating',
            'in_menu',
            'show_user',
            'can_comment',
            'can_index',
            'category',
    ];

    public function user()
    {
        return $this->belongsTo('App\User','id','id');
    }
}
