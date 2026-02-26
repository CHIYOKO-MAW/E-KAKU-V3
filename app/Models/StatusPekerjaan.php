<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusPekerjaan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'status_pekerjaan';

    protected $fillable = [
        'user_id',
        'status_pekerjaan',
        'nama_perusahaan',
        'tanggal_update',
    ];

    protected $casts = [
        'tanggal_update' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
