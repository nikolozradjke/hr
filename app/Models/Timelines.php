<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timelines extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id'.
        'user_id',
        'comment',
        'from_to'
    ];
}
