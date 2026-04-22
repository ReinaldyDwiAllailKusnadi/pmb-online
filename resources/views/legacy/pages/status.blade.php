<x-app-layout title="Status Pendaftaran">
    <div class="flex min-h-screen">
        @include('partials.sidebar', ['activePage' => 'status'])

        <main class="ml-65 flex-1 bg-bg-light">
            @include('partials.topbar', [
                'pageLabel' => 'Status Pendaftaran',
                'userName' => $applicant->full_name,
                'userRole' => 'Calon Mahasiswa',
                'userAvatar' => 'https://ui-avatars.com/api/?name=' . urlencode($applicant->full_name),
            ])

            <div class="p-8 max-w-6xl mx-auto space-y-10">
                <section class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 bg-white rounded-2xl p-8 shadow-soft relative overflow-hidden flex flex-col md:flex-row items-center gap-6">
                        <div class="absolute top-0 right-0 w-48 h-48 bg-secondary/5 rounded-full -mr-16 -mt-16 pointer-events-none"></div>
                        <div class="relative z-10 w-24 h-24 shrink-0 flex items-center justify-center rounded-full bg-secondary/10 text-secondary ring-8 ring-secondary/5">
                            <x-lucide-icon name="hourglass" class="w-9 h-9 animate-[spin_8s_linear_infinite]" />
                        </div>
                        <div class="relative z-10 flex-1 space-y-4 text-center md:text-left">
                            <div>
                                <h3 class="text-slate-500 text-[10px] font-bold uppercase tracking-widest mb-1">Status Saat Ini</h3>
                                <div class="flex flex-col md:flex-row md:items-center gap-4">
                                    <span class="text-3xl font-extrabold text-primary tracking-tight">Menunggu Verifikasi</span>
                                    <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-secondary text-white text-[10px] font-extrabold uppercase tracking-widest shadow-sm">
                                        In Review
                                    </span>
                                </div>
                            </div>
                            <p class="text-slate-600 leading-relaxed max-w-md text-sm">
                                Tim admisi kami sedang meninjau dokumen pendaftaran Anda. Proses ini biasanya memakan waktu 2-3 hari kerja.
                            </p>
                        </div>
                    </div>

                    <div class="bg-primary rounded-2xl p-8 text-white flex flex-col justify-between shadow-soft relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -mr-8 -mt-8 pointer-events-none"></div>
                        <div>
                            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mb-4">Program Pilihan</p>
                            <h4 class="text-xl font-bold mb-1 tracking-tight">S1 Teknik Informatika</h4>
                            <p class="text-slate-300 text-sm">Fakultas Teknologi Informasi</p>
                        </div>
                        <div class="mt-8 pt-6 border-t border-white/10 flex justify-between items-center text-sm">
                            <span class="text-slate-400">Gelombang</span>
                            <span class="font-bold text-secondary">Gelombang 2 (Mei - Juli)</span>
                        </div>
                    </div>
                </section>

                <section>
                    <div class="flex items-center gap-4 mb-8">
                        <h3 class="text-2xl font-bold text-primary tracking-tight">Perjalanan Pendaftaran</h3>
                        <div class="h-px flex-1 bg-slate-200"></div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        @foreach ([
                            ['id' => '01', 'title' => 'Akun Dibuat', 'date' => '12 Mei 2024', 'status' => 'completed'],
                            ['id' => '02', 'title' => 'Formulir Selesai', 'date' => '14 Mei 2024', 'status' => 'completed'],
                            ['id' => '03', 'title' => 'Verifikasi Berkas', 'date' => 'Sedang Berlangsung', 'status' => 'current', 'subtitle' => 'Menunggu Antrian'],
                            ['id' => '04', 'title' => 'Tes Seleksi', 'date' => 'Belum Terjadwal', 'status' => 'upcoming'],
                        ] as $step)
                            <div class="p-6 rounded-2xl relative transition-all duration-300 border-b-4 shadow-soft {{ $step['status'] === 'completed' ? 'bg-white border-primary' : ($step['status'] === 'current' ? 'bg-white border-secondary shadow-lg shadow-secondary/10' : 'bg-slate-50 border-slate-200 opacity-70') }}">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center {{ $step['status'] === 'completed' ? 'bg-primary text-white' : ($step['status'] === 'current' ? 'bg-secondary text-white' : 'bg-slate-200 text-slate-500') }}">
                                        @if ($step['status'] === 'completed')
                                            <x-lucide-icon name="check" class="w-5 h-5" />
                                        @elseif ($step['status'] === 'current')
                                            <x-lucide-icon name="refresh-cw" class="w-5 h-5 animate-spin duration-[1.5s]" />
                                        @else
                                            <x-lucide-icon name="clock" class="w-5 h-5" />
                                        @endif
                                    </div>
                                    <span class="text-[10px] font-black uppercase {{ $step['status'] === 'current' ? 'text-secondary' : 'text-slate-400' }}">
                                        {{ $step['status'] === 'current' ? 'Sedang Berlangsung' : $step['id'] }}
                                    </span>
                                </div>
                                <h5 class="font-bold text-primary text-sm mb-1">{{ $step['title'] }}</h5>
                                <p class="text-xs {{ $step['status'] === 'current' ? 'text-slate-600 font-medium italic' : 'text-slate-500' }}">
                                    {{ $step['status'] === 'current' ? $step['subtitle'] : $step['date'] }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </section>

                <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                    <div class="xl:col-span-2 space-y-6">
                        <div class="flex justify-between items-end">
                            <h3 class="text-xl font-bold text-primary tracking-tight">Riwayat Aktivitas</h3>
                            <button class="text-[10px] font-bold text-primary hover:text-secondary group transition-colors flex items-center gap-1.5 px-2 py-1 uppercase tracking-widest">
                                Lihat Detail <x-lucide-icon name="arrow-right" class="w-3 h-3 group-hover:translate-x-1 transition-transform" />
                            </button>
                        </div>
                        <div class="bg-white rounded-2xl overflow-hidden shadow-soft border border-slate-100">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-slate-50/50 border-b border-slate-100">
                                            <th class="px-5 py-3 text-[10px] font-bold uppercase tracking-widest text-slate-500">Tanggal & Waktu</th>
                                            <th class="px-5 py-3 text-[10px] font-bold uppercase tracking-widest text-slate-500">Aktivitas</th>
                                            <th class="px-5 py-3 text-[10px] font-bold uppercase tracking-widest text-slate-500">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @foreach ([
                                            ['date' => '15 Mei 2024, 09:42', 'activity' => 'Berkas Diterima', 'description' => 'Sistem telah menerima unggahan berkas lengkap.', 'color' => 'bg-secondary'],
                                            ['date' => '14 Mei 2024, 16:20', 'activity' => 'Finalisasi Data', 'description' => 'Peserta melakukan konfirmasi akhir formulir.', 'color' => 'bg-green-500'],
                                            ['date' => '12 Mei 2024, 11:05', 'activity' => 'Registrasi Akun', 'description' => 'Akun portal PMB berhasil diaktifkan.', 'color' => 'bg-green-500'],
                                        ] as $item)
                                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                                <td class="px-5 py-4 text-sm font-medium text-slate-700">{{ $item['date'] }}</td>
                                                <td class="px-5 py-4">
                                                    <div class="flex items-center gap-2">
                                                        <span class="w-2 h-2 rounded-full {{ $item['color'] }} group-hover:scale-125 transition-transform"></span>
                                                        <span class="text-sm font-bold text-primary">{{ $item['activity'] }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-5 py-4 text-sm text-slate-600 leading-relaxed">{{ $item['description'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <h3 class="text-xl font-bold text-primary tracking-tight">Langkah Selanjutnya</h3>
                        <div class="space-y-4">
                            <div class="bg-white rounded-2xl p-6 border-l-4 border-secondary shadow-soft space-y-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-secondary/10 flex items-center justify-center text-secondary">
                                        <x-lucide-icon name="alert-circle" class="w-5 h-5" />
                                    </div>
                                    <h5 class="font-bold text-primary text-sm">Cek Email Berkala</h5>
                                </div>
                                <p class="text-[10px] text-slate-600 leading-relaxed">
                                    Pengumuman hasil verifikasi akan dikirimkan melalui email resmi dan notifikasi portal ini secara otomatis.
                                </p>
                            </div>

                            <div class="bg-white rounded-2xl p-6 shadow-soft space-y-4 border border-slate-100 hover:border-slate-200 transition-colors group">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-primary/5 flex items-center justify-center text-primary group-hover:bg-primary/10 transition-colors">
                                        <x-lucide-icon name="graduation-cap" class="w-5 h-5" />
                                    </div>
                                    <h5 class="font-bold text-primary text-sm">Persiapan Materi Ujian</h5>
                                </div>
                                <p class="text-[10px] text-slate-600 leading-relaxed">
                                    Sambil menunggu, pelajari materi Tes Potensi Akademik dan Bahasa Inggris untuk tahap seleksi mendatang.
                                </p>
                                <button type="button" disabled aria-disabled="true" class="flex cursor-not-allowed items-center gap-1 text-[10px] font-black uppercase tracking-widest text-slate-400 opacity-70">
                                    Kisi-Kisi Segera Tersedia <x-lucide-icon name="lock" class="w-3 h-3" />
                                </button>
                            </div>

                            <div class="relative bg-linear-to-br from-primary to-[#0f2a4a] rounded-2xl p-8 text-white overflow-hidden shadow-xl">
                                <div class="absolute -bottom-6 -right-6 opacity-10">
                                    <x-lucide-icon name="message-circle" class="w-32 h-32" />
                                </div>
                                <div class="relative z-10">
                                    <h5 class="font-bold text-base mb-2">Punya Pertanyaan?</h5>
                                    <p class="text-[10px] text-slate-300 mb-6 leading-relaxed">Tim Customer Service kami siap membantu Anda selama jam operasional kerja.</p>
                                    <button type="button" disabled aria-disabled="true" class="w-full cursor-not-allowed rounded-xl bg-white/10 py-3 text-[10px] font-bold uppercase tracking-widest text-white/60 shadow-lg">
                                        WhatsApp Segera Tersedia
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <footer class="pt-12 border-t border-slate-200/60 flex flex-col md:flex-row justify-between items-center gap-6 text-slate-400 pb-8">
                    <div class="flex items-center gap-6 opacity-40 hover:opacity-60 transition-opacity">
                        <img
                            class="h-8 grayscale"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCS00hUvsSPZG6iN8RqgUbupQEmHA4OpHs5RGiDOtJkBoUfJ-kcVqyVd4KJM3Leq-3cyOOsqqJyKrl-v8OQwjd7pHa1btq5wR4pdHqx1XgdeLfSP_iVICdIxtjccKJ6n5iA_vgddWa5XS7CZ7M8aW0htNpJDmi163Ymek0QV66igDTK8B1QN9jxIvP6ubp5R49Dy8oS58TLvhgpXLw68ew1rLCgQJ8qIrerL7LccWsUyjufuHxnhIiD7XrzloB2g0rnSg8BTc0X8eA"
                            alt="Accreditation"
                            referrerpolicy="no-referrer"
                        />
                    </div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">
                        © 2024 Akademi PMB - Direktorat Sistem Informasi
                    </p>
                </footer>
            </div>
        </main>
    </div>
</x-app-layout>
