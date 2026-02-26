<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int,string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // relasi
    public function biodata()
    {
        return $this->hasOne(Biodata::class);
    }

    public function uploads()
    {
        return $this->hasMany(Upload::class);
    }

    public function kartuKuning()
    {
        return $this->hasOne(KartuKuning::class);
    }

    public function notificationsE()
    {
        return $this->hasMany(NotificationE::class);
    }

    public function statusPekerjaan()
{
    return $this->hasOne(\App\Models\StatusPekerjaan::class);
}

    /**
     * Check if the user has completed their profile.
     *
     * @return bool
     */
    public function hasCompletedProfile()
    {
        return $this->biodata && $this->biodata->nik && $this->biodata->tempat_lahir && $this->biodata->tanggal_lahir && $this->biodata->alamat && $this->biodata->pendidikan;
    }

    /**
     * Generate QR code (URL + HMAC Token) untuk Kartu Kuning.
     * Token dihasilkan dari HMAC-SHA256 sehingga tidak bisa dipalsukan.
     *
     * @return void
     */
    public function generateQrCode()
    {
        if (! $this->kartuKuning) {
            $this->kartuKuning()->create();
            $this->refresh();
        }

        $nomor_ak1 = $this->kartuKuning->nomor_ak1;
        $issuedAt  = now()->timestamp;

        // Buat HMAC token — tidak bisa dipalsukan tanpa APP_KEY
        $hmacPayload = $this->id . ':' . $nomor_ak1 . ':' . $issuedAt;
        $token = hash_hmac('sha256', $hmacPayload, config('app.key'));

        // Simpan token ke database
        $this->kartuKuning->update([
            'qr_token'     => $token,
            'qr_issued_at' => now(),
        ]);

        // URL verifikasi publik yang akan di-encode ke QR
        $verifyUrl = url('/verify/' . urlencode($nomor_ak1) . '?token=' . $token);

        // Simpan URL sebagai qr_code_path agar bisa diakses oleh getQrCodeAttribute()
        $this->kartuKuning->update(['qr_code_path' => $verifyUrl]);
    }

    /**
     * Get the QR code URL — URL verifikasi publik yang di-encode ke QR.
     *
     * @return string|null
     */
    public function getQrCodeAttribute()
    {
        if (! $this->kartuKuning || ! $this->kartuKuning->qr_code_path) {
            return null;
        }

        // Jika qr_code_path sudah berupa URL (baru), kembalikan langsung
        if (str_starts_with($this->kartuKuning->qr_code_path, 'http')) {
            return $this->kartuKuning->qr_code_path;
        }

        // Backward compat: path lama berupa file path — regenerasi otomatis
        return null;
    }

    public function getProfilePhotoUrlAttribute(): ?string
    {
        if (! $this->profile_photo_path) {
            return null;
        }

        return route('profile.photo', $this);
    }

}
