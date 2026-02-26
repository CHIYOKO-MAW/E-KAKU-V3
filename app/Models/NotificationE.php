<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationE extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'notifications';

    protected $fillable = [
        'user_id',
        'judul',
        'pesan',
        'status_baca',
        'tipe',
    ];

    protected $casts = [
        'status_baca' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

