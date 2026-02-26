<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Biodata extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'biodata';

    protected $fillable = [
        'user_id',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'jenis_kelamin',
        'agama',
        'rt_rw',
        'kode_pos',
        'kecamatan',
        'desa_kelurahan',
        'status_perkawinan',
        'tinggi_badan',
        'berat_badan',
        'disabilitas',
        'pendidikan',
        'tahun_lulus',
        'institusi_pendidikan',
        'jurusan',
        'keahlian',
        'pengalaman',
        'tujuan_lamaran',
        'status_verifikasi',
        'tanggal_verifikasi',
        'verifikator_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
