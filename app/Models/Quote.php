<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Quote extends Model
{
    use HasFactory;
    use HasTranslations;
    protected $fillable = [
        'quote',
        'thumbnail',
        'movie_id',
        'user_id'
    ];

    public $translatable = [
        'quote',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
