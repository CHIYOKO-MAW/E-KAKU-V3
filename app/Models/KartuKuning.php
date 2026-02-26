<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class KartuKuning extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kartu_kuning';

    protected $fillable = [
        'user_id',
        'nomor_ak1',
        'tanggal_cetak',
        'qr_code_path',
        'status',
        'qr_token',
        'qr_issued_at',
        'scan_count',
    ];

    protected $dates = [
        'tanggal_cetak',
        'qr_issued_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
