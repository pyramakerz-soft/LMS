<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function schools()
    {
        return $this->belongsToMany(School::class, 'lesson_school');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }
}
