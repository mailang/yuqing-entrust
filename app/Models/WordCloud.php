<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordCloud extends Model
{
    protected $table = "wordcloud";
    protected $fillable = [
        'id',
        "words"
    ];
}