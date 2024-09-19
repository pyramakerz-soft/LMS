<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function schools()
    {
        return $this->belongsToMany(School::class, 'unit_school');
    }


    public function units()
    {
        return $this->hasMany(Unit::class);
    }
}
