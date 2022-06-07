<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statuses extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function candidates(){
        return $this->hasMany(Candidates::class, 'status', 'id');
    }
}
