<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function stages()
    {
        return $this->belongsToMany(Stage::class, 'teacher_stage');
    }
}