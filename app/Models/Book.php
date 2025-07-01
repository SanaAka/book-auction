<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- 1. ADD THIS LINE
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory; // <-- 2. ADD THIS LINE

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'author',
        'cover_image',
        'start_price',
        'status',
    ];
}