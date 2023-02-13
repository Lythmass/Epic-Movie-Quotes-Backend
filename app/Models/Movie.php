<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Movie extends Model
{
    use HasFactory;
    use HasTranslations;
    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'year',
        'director',
        'budget'
    ];

    public $translatable = [
        'title',
        'description',
        'director',
    ];

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
}
