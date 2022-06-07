<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidates extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'position',
        'salary_range',
        'skills',
        'linkedin',
        'cv',
        'status'
    ];

    public function status(){
        return $this->belongsTo(Statuses::class, 'status', 'id');
    }

    public function timelines(){
        return $this->hasMany(Timelnes::class, 'candidate_id', 'id');
    }
}
