<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Upload extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "uploads";

    protected $fillable = [
        "user_id",
        "jenis_dokumen",
        "file_path",
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
