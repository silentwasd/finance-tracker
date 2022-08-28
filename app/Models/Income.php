<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    public $timestamps = false;

    protected $casts = [
        'completed_at' => 'datetime'
    ];
}
