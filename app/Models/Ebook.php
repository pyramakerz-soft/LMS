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
        if ($val !== null) {
            // Construct the correct S3 path for the eBook index.html
            $filePath = rtrim($val, '/') . '/index.html';

            // Return the full S3 URL
            return Storage::disk('s3')->url($filePath);
        }

        return "";
    }
}
