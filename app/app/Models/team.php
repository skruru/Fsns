<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class team extends Model
{
    protected $table = 'teams';
    protected $guarded = [
        'id'
    ];
}
