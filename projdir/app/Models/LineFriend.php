<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LineFriend extends Model
{
    use HasFactory;

    protected $table = 'line_friends';

    protected $fillable = [
        'line_id', 'line_name', 'line_icon_url', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
