<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timelines extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'user_id',
        'comment',
        'status'
    ];

    public function candidate(){
        return $this->belongsTo(Candidates::class, 'candidate_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
