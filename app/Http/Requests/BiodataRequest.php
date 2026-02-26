<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BiodataRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        $user = $this->user();
        $biodataId = optional($user->biodata)->id;

        return [
            'nik' => [
                'required',
                'digits_between:8,20',
                'numeric',
                Rule::unique('biodata','nik')->ignore($biodataId),
            ],
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'nullable|in:laki_laki,perempuan',
            'agama' => 'nullable|string|max:50',
            'rt_rw' => 'nullable|string|max:20',
            'kode_pos' => 'nullable|string|max:10',
            'kecamatan' => 'nullable|string|max:120',
            'desa_kelurahan' => 'nullable|string|max:120',
            'status_perkawinan' => 'nullable|in:belum_menikah,menikah,cerai_hidup,cerai_mati',
            'tinggi_badan' => 'nullable|integer|min:50|max:250',
            'berat_badan' => 'nullable|integer|min:20|max:300',
            'disabilitas' => 'nullable|boolean',
            'pendidikan' => 'required|string|max:100',
            'tahun_lulus' => 'nullable|digits:4',
            'institusi_pendidikan' => 'nullable|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'keahlian' => 'nullable|string|max:255',
            'pengalaman' => 'nullable|string',
            'tujuan_lamaran' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'nik.required' => 'NIK wajib diisi.',
            'nik.numeric' => 'NIK hanya boleh berisi angka.',
            'nik.digits_between' => 'Panjang NIK harus antara 8 sampai 20 digit.',
            'nik.unique' => 'NIK sudah terdaftar di sistem.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Tanggal lahir tidak valid.',
            'alamat.required' => 'Alamat wajib diisi.',
            'pendidikan.required' => 'Pendidikan wajib diisi.',
            'jenis_kelamin.in' => 'Pilihan jenis kelamin tidak valid.',
            'status_perkawinan.in' => 'Pilihan status perkawinan tidak valid.',
            'tinggi_badan.integer' => 'Tinggi badan harus berupa angka.',
            'berat_badan.integer' => 'Berat badan harus berupa angka.',
        ];
    }
}
