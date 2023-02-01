<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Email extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'email',
        'email_verified_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
