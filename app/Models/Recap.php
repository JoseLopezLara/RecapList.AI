<?php

namespace App\Models;

use App\Enums\RecapStatus;
use Illuminate\Database\Eloquent\Model;

class Recap extends Model
{

    protected $table = "recaps";
    protected $fillable = [
        'content',
        'title',
        'date',
        'status'
    ];

    protected $casts = [
        'date' => 'datetime',
        'status' => RecapStatus::class
    ];
}
