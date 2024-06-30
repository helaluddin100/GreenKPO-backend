<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'small_description',
        'description',
        'image',
        'feature_list',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'status',
        'view_count'
    ];

    protected $casts = [
        'feature_list' => 'array',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
