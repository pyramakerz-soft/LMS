<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Ebook extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
    public function getImageAttribute($val)
    {
        return $val ? Storage::disk('s3')->url("pyra-public/$val") : "";
    }
    public function getFilePathAttribute($val)
    {
        return ($val !== null) ? asset('public/storage/ebooks/' . basename($val) . '/index.html') : "";

    }
}
