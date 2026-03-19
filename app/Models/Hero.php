<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    use HasFactory;

    protected $fillable = [
        'opendota_hero_id',
        'name',
        'localized_name',
        'primary_attr',
        'attack_type',
        'roles',
        'image',
        'icon',
    ];

    protected $casts = [
        'roles' => 'array',
    ];
}
