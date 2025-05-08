<?php

namespace App\Models;

use App\Enums\RecapStatus;
use Illuminate\Database\Eloquent\Model;

class LightLog extends Model
{

    protected $table = "light_logs";
    protected $fillable = [
        'status'
    ];
}
