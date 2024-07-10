<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $attributes = [
        'banner_description' => "Carbon Accounting is easy, it's meant for businesses of all sizes and with GreenKPO it takes only a few steps to understand how to assess, manage and take action about your business's Carbon emission.",
    ];
}