<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'author',
        'author_profile_picture',
        'is_comment',
        'is_read',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
