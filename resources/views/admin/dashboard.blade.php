<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h2 class="font-bold text-xl leading-tight" style="color:#fff;">📊 Dashboard Manajer</h2>
                <p style="color:#bbf7d0;font-size:.85rem;margin-top:2px;">Selamat datang, {{ Auth::user()->name }}! Hari ini {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">

        <!-- STATS CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">

            <!-- Total Karyawan -->
            <div class="rounded-2xl p-6 text-white relative overflow-hidden shadow-lg"
                 style="background:linear-gradient(135deg,#166534,#16a34a);">
                <div style="position:absolute;top:-20px;right:-20px;width:100px;height:100px;border-radius:50%;background:rgba(255,255,255,.1);"></div>
                <div style="position:absolute;bottom:-30px;left:-10px;width:80px;height:80px;border-radius:50%;background:rgba(255,255,255,.07);"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-3">
                        <span style="font-size:.82rem;font-weight:600;color:#bbf7d0;letter-spacing:.05em;text-transform:uppercase;">Total Karyawan</span>
                        <div style="background:rgba(255,255,255,.2);border-radius:10px;padding:8px;">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-4xl font-black text-white">{{ $totalKaryawan }}</div>
                    <div style="font-size:.82rem;color:#bbf7d0;margin-top:4px;">Orang terdaftar</div>
                </div>
            </div>

            <!-- Hadir Hari Ini -->
            <div class="rounded-2xl p-6 text-white relative overflow-hidden shadow-lg"
                 style="background:linear-gradient(135deg,#065f46,#059669);">
                <div style="position:absolute;top:-20px;right:-20px;width:100px;height:100px;border-radius:50%;background:rgba(255,255,255,.1);"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-3">
                        <span style="font-size:.82rem;font-weight:600;color:#a7f3d0;letter-spacing:.05em;text-transform:uppercase;">Hadir Hari Ini</span>
                        <div style="background:rgba(255,255,255,.2);border-radius:10px;padding:8px;">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-4xl font-black text-white">{{ $hadirHariIni }}</div>
                    <div style="font-size:.82rem;color:#a7f3d0;margin-top:4px;">Sudah absen masuk</div>
                </div>
            </div>

            <!-- Absen Rate -->
            <div class="rounded-2xl p-6 text-white relative overflow-hidden shadow-lg sm:col-span-2 lg:col-span-1"
                 style="background:linear-gradient(135deg,#14532d,#15803d);">
                <div style="position:absolute;top:-20px;right:-20px;width:100px;height:100px;border-radius:50%;background:rgba(255,255,255,.08);"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-3">
                        <span style="font-size:.82rem;font-weight:600;color:#bbf7d0;letter-spacing:.05em;text-transform:uppercase;">Kehadiran</span>
                        <div style="background:rgba(255,255,255,.2);border-radius:10px;padding:8px;">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-4xl font-black text-white">
                        {{ $totalKaryawan > 0 ? round(($hadirHariIni / $totalKaryawan) * 100) : 0 }}%
                    </div>
                    <div style="font-size:.82rem;color:#bbf7d0;margin-top:4px;">Tingkat kehadiran hari ini</div>
                </div>
            </div>
        </div>

        <!-- QUICK ACCESS MENU -->
        <div class="bg-white rounded-2xl shadow-sm border p-6 mb-6" style="border-color:#dcfce7;">
            <h3 class="font-bold text-lg mb-5" style="color:#14532d;">⚡ Akses Cepat</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <a href="{{ route('admin.karyawan.index') }}"
                   class="flex flex-col items-center gap-3 p-4 rounded-xl border-2 text-center transition group"
                   style="border-color:#dcfce7;background:#f0fdf4;" onmouseover="this.style.borderColor='#16a34a';this.style.background='#dcfce7'" onmouseout="this.style.borderColor='#dcfce7';this.style.background='#f0fdf4'">
                    <div style="background:linear-gradient(135deg,#dcfce7,#bbf7d0);border-radius:14px;padding:14px;font-size:1.4rem;">👥</div>
                    <span style="font-size:.82rem;font-weight:600;color:#166534;">Data Karyawan</span>
                </a>
                <a href="{{ route('admin.gaji.index') }}"
                   class="flex flex-col items-center gap-3 p-4 rounded-xl border-2 text-center transition"
                   style="border-color:#dcfce7;background:#f0fdf4;" onmouseover="this.style.borderColor='#16a34a';this.style.background='#dcfce7'" onmouseout="this.style.borderColor='#dcfce7';this.style.background='#f0fdf4'">
                    <div style="background:linear-gradient(135deg,#fef9c3,#fde68a);border-radius:14px;padding:14px;font-size:1.4rem;">💰</div>
                    <span style="font-size:.82rem;font-weight:600;color:#166534;">Penggajian</span>
                </a>
                <a href="{{ route('admin.izin.index') }}"
                   class="flex flex-col items-center gap-3 p-4 rounded-xl border-2 text-center transition"
                   style="border-color:#dcfce7;background:#f0fdf4;" onmouseover="this.style.borderColor='#16a34a';this.style.background='#dcfce7'" onmouseout="this.style.borderColor='#dcfce7';this.style.background='#f0fdf4'">
                    <div style="background:linear-gradient(135deg,#f3e8ff,#e9d5ff);border-radius:14px;padding:14px;font-size:1.4rem;">📋</div>
                    <span style="font-size:.82rem;font-weight:600;color:#166534;">Persetujuan Izin</span>
                </a>
                <a href="{{ route('admin.pengaturan.index') }}"
                   class="flex flex-col items-center gap-3 p-4 rounded-xl border-2 text-center transition"
                   style="border-color:#dcfce7;background:#f0fdf4;" onmouseover="this.style.borderColor='#16a34a';this.style.background='#dcfce7'" onmouseout="this.style.borderColor='#dcfce7';this.style.background='#f0fdf4'">
                    <div style="background:linear-gradient(135deg,#f1f5f9,#e2e8f0);border-radius:14px;padding:14px;font-size:1.4rem;">⚙️</div>
                    <span style="font-size:.82rem;font-weight:600;color:#166534;">Pengaturan</span>
                </a>
            </div>
        </div>

        <!-- INFO FOOTER -->
        <div class="rounded-2xl p-5 flex items-center gap-4" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);border:1.5px solid #bbf7d0;">
            <div style="font-size:2rem;">🌿</div>
            <div>
                <div style="font-weight:700;color:#14532d;">Sistem HRIS Cafe Teras Bumi</div>
                <div style="font-size:.82rem;color:#166534;">Kelola karyawan, absensi, dan penggajian dengan mudah dan efisien.</div>
            </div>
        </div>

    </div>
</x-app-layout>