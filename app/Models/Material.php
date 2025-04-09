<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Material extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function schools()
    {
        return $this->belongsToMany(School::class);
    }
    public function materialSchools()
    {
        return $this->hasMany(MaterialSchool::class);
    }
    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
    public function units()
    {
        return $this->hasMany(Unit::class);
    }
    //  public function getImageAttribute($val)
    // {
    //     return ($val !== null) ? asset($val) : "";
    // }
    public function getImageAttribute($val)
    {
        return $val ? Storage::disk('s3')->url("pyra-public/$val") : "";
    }
    //  public function getLearningAttribute($val)
    // {
    //     return ($val !== null) ? asset('ebooks/'.$val) : "";
    // }
    // public function getHowToUseAttribute($val)
    // {
    //     return ($val !== null) ? asset('ebooks/' . $val) : "";
    // }
    // public function getFilePathAttribute($val)
    // {
    //     return ($val !== null) ? asset('ebooks/' . $val) : "";
    // }
    public function getLearningAttribute($val)
    {
        return $val ? Storage::disk('s3')->url("pyra-public/ebooks/$val/index.html") : "";
    }
    public function getHowToUseAttribute($val)
    {
        return $val ? Storage::disk('s3')->url("pyra-public/ebooks/$val/index.html") : "";
    }
    public function getFilePathAttribute($val)
    {
        return $val ? Storage::disk('s3')->url("pyra-public/ebooks/$val/index.html") : "";
    }

}
