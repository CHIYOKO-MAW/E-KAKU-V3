@extends('layouts.app')

@section('navigation')
    @include('layouts.navigation-guest')
@endsection

@section('content')
  <!-- Hero Section -->
<section class="gradient-bg text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold mb-6">
                    e-Kaku V3
                    <span class="block text-2xl md:text-3xl font-normal mt-2">
                        Kartu Kuning Digital Disnaker Pandeglang
                    </span>
                </h1>
                <p class="text-xl mb-8 text-blue-100">
                    Digitalisasi kartu kuning (AK-1) untuk pencari kerja di Kabupaten Pandeglang.
                    Daftar, lengkapi profil, dan dapatkan kartu digital dengan QR code.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('register') }}"
                       class="bg-white text-disnaker-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-semibold text-center transition duration-300">
                        <i class="fas fa-user-plus mr-2"></i> Daftar Sekarang
                    </a>
                    <a href="{{ route('login') }}"
                       class="border-2 border-white text-white hover:bg-white hover:text-disnaker-600 px-8 py-3 rounded-lg font-semibold text-center transition duration-300">
                        <i class="fas fa-sign-in-alt mr-2"></i> Masuk
                    </a>
                </div>
            </div>
            <div class="flex justify-center">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 max-w-md">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-white rounded-full mx-auto mb-4 flex items-center justify-center">
                            <i class="fas fa-id-card text-disnaker-600 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold">Kartu Digital</h3>
                        <p class="text-blue-100 text-sm">Dengan QR Code</p>
                    </div>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-400 mr-3"></i>
                            <span>Berlaku 2 Tahun</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-400 mr-3"></i>
                            <span>Bisa Diverifikasi Online</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-400 mr-3"></i>
                            <span>Update Status Otomatis</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Fitur Unggulan</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Sistem kartu kuning digital dengan teknologi terkini untuk kemudahan pencari kerja dan pengawas Disnaker.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-gray-50 rounded-xl p-6 hover-lift card-shadow">
                <div class="w-12 h-12 bg-disnaker-100 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-user-edit text-disnaker-600 text-xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">Profil Lengkap</h3>
                <p class="text-gray-600 mb-4">
                    Lengkapi data diri, skill, pengalaman kerja, dan preferensi lokasi kerja untuk mendapatkan rekomendasi yang tepat.
                </p>
                <div class="text-sm text-disnaker-600 font-medium">
                    <i class="fas fa-check mr-1"></i> Gamifikasi dengan poin
                </div>
            </div>

            <!-- Feature 2 -->
            <div class="bg-gray-50 rounded-xl p-6 hover-lift card-shadow">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-sync-alt text-green-600 text-xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">Update Status</h3>
                <p class="text-gray-600 mb-4">
                    Update status pekerjaan secara berkala: Belum Bekerja, Sudah Bekerja, atau Sedang Pelatihan.
                </p>
                <div class="text-sm text-green-600 font-medium">
                    <i class="fas fa-bell mr-1"></i> Reminder otomatis 3 bulanan
                </div>
            </div>

            <!-- Feature 3 -->
            <div class="bg-gray-50 rounded-xl p-6 hover-lift card-shadow">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-qrcode text-blue-600 text-xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">Kartu Digital</h3>
                <p class="text-gray-600 mb-4">
                    Dapatkan kartu digital dengan QR code yang bisa diunduh dalam format PDF dan diverifikasi secara online.
                </p>
                <div class="text-sm text-blue-600 font-medium">
                    <i class="fas fa-mobile-alt mr-1"></i> Akses kapan saja
                </div>
            </div>

            <!-- Feature 4 -->
            <div class="bg-gray-50 rounded-xl p-6 hover-lift card-shadow">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">Dashboard Admin</h3>
                <p class="text-gray-600 mb-4">
                    Pantau statistik pencari kerja, tren status pekerjaan, dan kelola data secara efisien.
                </p>
                <div class="text-sm text-purple-600 font-medium">
                    <i class="fas fa-chart-pie mr-1"></i> Visualisasi data lengkap
                </div>
            </div>

            <!-- Feature 5 -->
            <div class="bg-gray-50 rounded-xl p-6 hover-lift card-shadow">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-bell text-yellow-600 text-xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">Notifikasi</h3>
                <p class="text-gray-600 mb-4">
                    Terima notifikasi untuk update status, reminder, dan informasi penting dari Disnaker Pandeglang.
                </p>
                <div class="text-sm text-yellow-600 font-medium">
                    <i class="fas fa-envelope mr-1"></i> Email & in-app notification
                </div>
            </div>

            <!-- Feature 6 -->
            <div class="bg-gray-50 rounded-xl p-6 hover-lift card-shadow">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-file-export text-red-600 text-xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">Export Laporan</h3>
                <p class="text-gray-600 mb-4">
                    Export data pencari kerja dalam format PDF atau CSV untuk keperluan pelaporan dan analisis.
                </p>
                <div class="text-sm text-red-600 font-medium">
                    <i class="fas fa-download mr-1"></i> Multiple format support
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Statistik Sistem</h2>
            <p class="text-xl text-gray-600">
                Data real-time dari sistem e-Kaku V3 Disnaker Pandeglang
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-white rounded-xl p-6 text-center card-shadow hover-lift">
                <div class="w-16 h-16 bg-blue-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-users text-blue-600 text-2xl"></i>
                </div>
                <div class="text-3xl font-bold text-gray-900 mb-2">1,234</div>
                <div class="text-gray-600">Pencari Kerja Terdaftar</div>
            </div>

            <div class="bg-white rounded-xl p-6 text-center card-shadow hover-lift">
                <div class="w-16 h-16 bg-green-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                </div>
                <div class="text-3xl font-bold text-gray-900 mb-2">856</div>
                <div class="text-gray-600">Sudah Bekerja</div>
            </div>

            <div class="bg-white rounded-xl p-6 text-center card-shadow hover-lift">
                <div class="w-16 h-16 bg-yellow-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                </div>
                <div class="text-3xl font-bold text-gray-900 mb-2">378</div>
                <div class="text-gray-600">Belum Bekerja</div>
            </div>

            <div class="bg-white rounded-xl p-6 text-center card-shadow hover-lift">
                <div class="w-16 h-16 bg-purple-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-graduation-cap text-purple-600 text-2xl"></i>
                </div>
                <div class="text-3xl font-bold text-gray-900 mb-2">156</div>
                <div class="text-gray-600">Sedang Pelatihan</div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Tentang e-Kaku V3</h2>
                <div class="space-y-4 text-gray-600">
                    <p>
                        e-Kaku V3 adalah sistem digitalisasi kartu kuning (AK-1) yang dikembangkan oleh
                        Dinas Tenaga Kerja Kabupaten Pandeglang untuk memudahkan pencari kerja dalam
                        mengelola data dan status pekerjaan mereka.
                    </p>
                    <p>
                        Sistem ini dilengkapi dengan teknologi QR code, gamifikasi, dan dashboard admin
                        yang memudahkan monitoring dan pelaporan secara real-time.
                    </p>
                    <p>
                        Dengan e-Kaku V3, pencari kerja dapat dengan mudah mengupdate status pekerjaan,
                        mendapatkan reminder otomatis, dan mengakses kartu digital kapan saja melalui
                        perangkat mobile atau desktop.
                    </p>
                </div>

                <div class="mt-8">
                    <h3 class="text-xl font-semibold mb-4">Manfaat Utama</h3>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            <span>Efisiensi administrasi pencari kerja</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            <span>Monitoring real-time status pekerjaan</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            <span>Reduksi biaya cetak kartu fisik</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            <span>Peningkatan akurasi data statistik</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-center">
                <div class="bg-gray-50 rounded-2xl p-8 max-w-md">
                    <div class="text-center mb-6">
                        <div class="w-24 h-24 bg-disnaker-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <i class="fas fa-building text-white text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold">Dinas Tenaga Kerja</h3>
                        <p class="text-gray-600 text-sm">Kabupaten Pandeglang</p>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-white rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-map-marker-alt text-disnaker-600 mr-2"></i>
                                <span class="font-medium">Alamat</span>
                            </div>
                            <p class="text-sm text-gray-600">
                                Jl. Raya Pandeglang - Serang KM. 5, Pandeglang, Banten
                            </p>
                        </div>

                        <div class="bg-white rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-phone text-disnaker-600 mr-2"></i>
                                <span class="font-medium">Kontak</span>
                            </div>
                            <p class="text-sm text-gray-600">
                                (0253) 201001 / 201002
                            </p>
                        </div>

                        <div class="bg-white rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-envelope text-disnaker-600 mr-2"></i>
                                <span class="font-medium">Email</span>
                            </div>
                            <p class="text-sm text-gray-600">
                                disnaker@pandeglang.go.id
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Hubungi Kami</h2>
            <p class="text-xl text-gray-600">
                Untuk informasi lebih lanjut tentang e-Kaku V3
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white rounded-xl p-6 text-center card-shadow hover-lift">
                <div class="w-16 h-16 bg-blue-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-map-marker-alt text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2">Kantor Disnaker</h3>
                <p class="text-gray-600 text-sm">
                    Jl. Raya Pandeglang - Serang KM. 5<br>
                    Pandeglang, Banten 42218
                </p>
            </div>

            <div class="bg-white rounded-xl p-6 text-center card-shadow hover-lift">
                <div class="w-16 h-16 bg-green-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-phone text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2">Telepon</h3>
                <p class="text-gray-600 text-sm">
                    (0253) 201001<br>
                    (0253) 201002
                </p>
            </div>

            <div class="bg-white rounded-xl p-6 text-center card-shadow hover-lift">
                <div class="w-16 h-16 bg-purple-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-envelope text-purple-600 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2">Email</h3>
                <p class="text-gray-600 text-sm">
                    disnaker@pandeglang.go.id<br>
                    infodisnaker@gmail.com
                </p>
            </div>
        </div>

        <div class="mt-12 text-center">
            <div class="bg-white rounded-xl p-8 max-w-2xl mx-auto card-shadow">
                <h3 class="text-xl font-semibold mb-4">Jam Operasional</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-medium text-gray-900 mb-2">Senin - Kamis</h4>
                        <p class="text-gray-600">08:00 - 16:00 WIB</p>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900 mb-2">Jumat</h4>
                        <p class="text-gray-600">08:00 - 16:30 WIB</p>
                    </div>
                </div>
                <div class="mt-6 p-4 bg-yellow-50 rounded-lg">
                    <p class="text-sm text-yellow-800">
                        <i class="fas fa-info-circle mr-2"></i>
                        Untuk pendaftaran dan bantuan teknis e-Kaku V3, silakan hubungi bagian informasi.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

