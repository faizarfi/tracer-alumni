<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    use HasFactory;
    protected $fillable = ['name','type','url','sort_order','active'];

    protected $casts = [
        'active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
