<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function schools()
    {
        return $this->belongsToMany(School::class, 'material_school');
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }
}
