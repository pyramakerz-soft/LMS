<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'material_school');
    }

    public function stages()
    {
        return $this->belongsToMany(Stage::class, 'school_stage');
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'lesson_school');
    }

    public function units()
    {
        return $this->belongsToMany(Unit::class, 'unit_school');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function admins()
    {
        return $this->hasMany(Admin::class);
    }

}