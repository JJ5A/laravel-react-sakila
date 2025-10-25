<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    protected $table = 'actor';
    protected $primaryKey = 'actor_id';
    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'last_update',
    ];
}
