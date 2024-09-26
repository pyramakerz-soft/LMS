<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_classes');
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_classes');
    }
}
