<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Chapter extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
    public function material()
    {
        return $this->belongsTo(Material::class);
    }
    public function schools()
    {
        return $this->belongsToMany(School::class, 'chapter_school');
    }
    //  public function getImageAttribute($val)
    // {
    //     return ($val !== null) ? asset( $val) : "";
    // }
    public function getImageAttribute($val)
    {
        return $val ? Storage::disk('s3')->url("pyra-public/$val") : "";
    }

}
