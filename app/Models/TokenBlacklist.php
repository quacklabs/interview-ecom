<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenBlacklist extends Model
{
    use HasFactory;

    protected $table = 'token_blacklist';

    protected $fillable = [
        'token_id', 'revoked_at'
    ];
}
