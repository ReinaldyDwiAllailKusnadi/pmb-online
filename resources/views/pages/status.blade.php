<x-app-layout title="Status Pendaftaran">
    <div class="flex">
        @include('partials.sidebar', ['current' => 'status'])

        <div class="ml-65 flex-1 flex flex-col min-h-screen">
            @include('partials.header', ['title' => 'Status Pendaftaran', 'userName' => $applicant->full_name])

            <div class="p-8 max-w-6xl mx-auto">
                <section class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
                    <div class="lg:col-span-2 bg-surface-container-lowest rounded-xl p-8 shadow-[0_2px_12px_rgba(30,58,95,0.08)] flex flex-col md:flex-row items-center gap-8 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-secondary/10 rounded-full -mr-16 -mt-16"></div>
                        <div class="relative z-10 w-24 h-24 shrink-0 flex items-center justify-center rounded-full bg-secondary/20 text-secondary">
                            <x-lucide-icon name="clock" class="w-12 h-12" />
                        </div>
                        <div class="relative z-10 flex-1 text-center md:text-left">
                            <h3 class="text-on-surface-variant text-sm font-medium mb-1">Status Saat Ini</h3>
                            <div class="flex flex-col md:flex-row md:items-center gap-4">
                                <span class="text-3xl font-extrabold text-primary">Menunggu Verifikasi</span>
                                <span class="inline-flex items-center px-4 py-1 rounded-full bg-secondary text-white text-xs font-bold uppercase tracking-widest">In Review</span>
                            </div>
                            <p class="mt-4 text-on-surface-variant leading-relaxed max-w-md">
                                Tim admisi kami sedang meninjau dokumen pendaftaran Anda. Proses ini biasanya memakan waktu 2-3 hari kerja.
                            </p>
                        </div>
                    </div>

                    <div class="bg-primary-container rounded-xl p-8 text-white flex flex-col justify-between">
                        <div>
                            <p class="text-on-primary-container text-xs font-bold uppercase tracking-widest mb-4">Program Pilihan</p>
                            <h4 class="text-xl font-bold mb-1">S1 Teknik Informatika</h4>
                            <p class="text-on-primary-container text-sm">Fakultas Teknologi Informasi</p>
                        </div>
                        <div class="mt-8 pt-6 border-t border-white/10">
                            <div class="flex justify-between items-center text-sm">
                                <span class="opacity-70">Gelombang</span>
                                <span class="font-bold">Gelombang 2 (Mei - Juli)</span>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="mb-12">
                    <div class="flex items-center gap-4 mb-8">
                        <h3 class="text-2xl font-bold text-primary">Perjalanan Pendaftaran</h3>
                        <div class="h-px flex-1 bg-surface-container-high"></div>
                    </div>
                    <div class="relative grid grid-cols-1 md:grid-cols-4 gap-4">
                        @foreach ([
                            ['id' => '01', 'title' => 'Akun Dibuat', 'date' => '12 Mei 2024', 'status' => 'done'],
                            ['id' => '02', 'title' => 'Formulir Selesai', 'date' => '14 Mei 2024', 'status' => 'done'],
                            ['id' => '03', 'title' => 'Verifikasi Berkas', 'date' => 'Menunggu Antrian', 'status' => 'pending'],
                            ['id' => '04', 'title' => 'Tes Seleksi', 'date' => 'Belum Terjadwal', 'status' => 'upcoming'],
                        ] as $step)
                            <div class="p-6 rounded-xl relative border-b-4 {{ $step['status'] === 'done' ? 'bg-surface-container-lowest border-primary' : ($step['status'] === 'pending' ? 'bg-secondary/5 border-secondary shadow-lg shadow-secondary/10' : 'bg-surface-container border-transparent opacity-60') }}">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $step['status'] === 'done' ? 'bg-primary text-white' : ($step['status'] === 'pending' ? 'bg-secondary text-white animate-pulse' : 'bg-surface-dim text-on-surface-variant') }}">
                                        @if ($step['status'] === 'done')
                                            <x-lucide-icon name="check-circle" class="w-4 h-4" />
                                        @elseif ($step['status'] === 'pending')
                                            <x-lucide-icon name="clock" class="w-4 h-4" />
                                        @else
                                            <x-lucide-icon name="shield-check" class="w-4 h-4" />
                                        @endif
                                    </div>
                                    <span class="text-[10px] font-bold uppercase {{ $step['status'] === 'pending' ? 'text-secondary' : 'text-on-surface-variant/50' }}">
                                        {{ $step['status'] === 'pending' ? 'Sedang Berlangsung' : $step['id'] }}
                                    </span>
                                </div>
                                <h5 class="font-bold text-primary text-sm mb-1">{{ $step['title'] }}</h5>
                                <p class="text-xs {{ $step['status'] === 'pending' ? 'italic text-on-surface-variant' : 'text-on-surface-variant' }}">{{ $step['date'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>

                <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                    <div class="xl:col-span-2 space-y-6">
                        <div class="flex justify-between items-end">
                            <h3 class="text-xl font-bold text-primary">Riwayat Aktivitas</h3>
                            <button class="text-sm font-semibold text-primary-container flex items-center gap-1 hover:underline">
                                Lihat Detail <x-lucide-icon name="arrow-right" class="w-4 h-4" />
                            </button>
                        </div>
                        <div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-[0_2px_12px_rgba(30,58,95,0.08)]">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-surface-container-low border-b border-surface-container-high">
                                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Tanggal & Waktu</th>
                                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Aktivitas</th>
                                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-surface-container-low">
                                    @foreach ([
                                        ['time' => '15 Mei 2024, 09:42', 'activity' => 'Berkas Diterima', 'desc' => 'Sistem telah menerima unggahan berkas lengkap.', 'color' => 'bg-secondary'],
                                        ['time' => '14 Mei 2024, 16:20', 'activity' => 'Finalisasi Data', 'desc' => 'Peserta melakukan konfirmasi akhir formulir.', 'color' => 'bg-green-500'],
                                        ['time' => '12 Mei 2024, 11:05', 'activity' => 'Registrasi Akun', 'desc' => 'Akun portal PMB berhasil diaktifkan.', 'color' => 'bg-green-500'],
                                    ] as $row)
                                        <tr class="hover:bg-surface-container-low/50 transition-colors">
                                            <td class="px-6 py-5 text-sm font-medium">{{ $row['time'] }}</td>
                                            <td class="px-6 py-5">
                                                <div class="flex items-center gap-2">
                                                    <span class="w-2 h-2 rounded-full {{ $row['color'] }}"></span>
                                                    <span class="text-sm font-bold text-primary">{{ $row['activity'] }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-5 text-sm text-on-surface-variant">{{ $row['desc'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <h3 class="text-xl font-bold text-primary">Langkah Selanjutnya</h3>
                        <div class="space-y-4">
                            <div class="bg-surface-container-high/50 rounded-xl p-6 border-l-4 border-secondary">
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-lg bg-surface-container-lowest flex items-center justify-center shrink-0 text-secondary">
                                        <x-lucide-icon name="bell" class="w-5 h-5" />
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-primary text-sm mb-2">Cek Email Berkala</h5>
                                        <p class="text-xs text-on-surface-variant leading-relaxed">
                                            Pengumuman hasil verifikasi akan dikirimkan melalui email resmi dan notifikasi portal ini.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm">
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center shrink-0 text-primary">
                                        <x-lucide-icon name="graduation-cap" class="w-5 h-5" />
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-primary text-sm mb-2">Persiapan Materi Ujian</h5>
                                        <p class="text-xs text-on-surface-variant leading-relaxed">
                                            Sambil menunggu, pelajari materi Tes Potensi Akademik dan Bahasa Inggris untuk tahap seleksi.
                                        </p>
                                        <a href="#" class="inline-block mt-3 text-[10px] font-bold text-secondary uppercase tracking-wider hover:underline">Unduh Kisi-Kisi</a>
                                    </div>
                                </div>
                            </div>
                            <div class="relative bg-linear-to-br from-[#1E3A5F] to-[#2d486d] rounded-xl p-6 text-white overflow-hidden">
                                <div class="absolute -bottom-8 -right-8 opacity-10">
                                    <x-lucide-icon name="help-circle" class="w-32 h-32" />
                                </div>
                                <h5 class="font-bold text-sm mb-3 relative z-10">Punya Pertanyaan?</h5>
                                <p class="text-xs text-on-primary-container mb-4 relative z-10">Tim Customer Service kami siap membantu Anda selama jam kerja.</p>
                                <button class="relative z-10 w-full py-2 bg-secondary text-white rounded-lg text-xs font-bold uppercase tracking-wider hover:brightness-110 transition-all">
                                    Chat via WhatsApp
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <footer class="mt-16 pt-8 border-t border-surface-container-high flex flex-col md:flex-row justify-between items-center gap-4 text-on-surface-variant text-[10px] font-medium uppercase tracking-[0.2em]">
                    <div class="flex items-center gap-4 opacity-50 grayscale hover:grayscale-0 transition-all">
                        <div class="flex gap-2">
                            <div class="w-6 h-6 bg-slate-300 rounded"></div>
                            <div class="w-6 h-6 bg-slate-400 rounded"></div>
                            <div class="w-6 h-6 bg-slate-300 rounded"></div>
                        </div>
                    </div>
                    <p>© 2024 Akademi PMB - Direktorat Sistem Informasi</p>
                </footer>
            </div>
        </div>
    </div>
</x-app-layout>