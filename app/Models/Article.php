<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $guarded = [];

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function comments()
    {
        return $this->hasMany(ArticleComments::class);
    }
}
