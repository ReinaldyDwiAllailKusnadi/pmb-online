<x-app-layout title="Konfirmasi Pendaftaran">
    <div class="flex">
    @include('partials.sidebar', ['activePage' => 'formulir'])

        <div class="ml-65 flex-1 flex flex-col min-h-screen">
            @include('partials.topbar', [
                'pageLabel' => 'Konfirmasi Pendaftaran',
                'userName' => $applicant->full_name,
                'userRole' => 'Calon Mahasiswa',
                'userAvatar' => 'https://ui-avatars.com/api/?name=' . urlencode($applicant->full_name),
            ])

            <div class="p-10 max-w-6xl mx-auto">
                <div class="mb-12">
                    <div class="flex items-center justify-between">
                        @foreach ([
                            ['label' => 'Data Pribadi', 'done' => true],
                            ['label' => 'Dokumen', 'done' => true],
                            ['label' => 'Konfirmasi', 'active' => true],
                        ] as $index => $step)
                            <div class="flex flex-col items-center gap-2">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center shadow-lg {{ ($step['done'] ?? false) ? 'bg-primary text-white' : (($step['active'] ?? false) ? 'bg-secondary text-white ring-4 ring-secondary/20' : 'bg-surface-container text-on-surface-variant') }}">
                                    @if ($step['done'] ?? false)
                                        <x-lucide-icon name="check-circle" class="w-5 h-5" />
                                    @else
                                        <span class="font-bold text-sm">3</span>
                                    @endif
                                </div>
                                <span class="text-xs font-bold {{ ($step['active'] ?? false) ? 'text-secondary' : 'text-primary' }}">{{ $step['label'] }}</span>
                            </div>
                            @if ($index < 2)
                                <div class="flex-1 h-1 mx-4 rounded-full opacity-20 {{ $index === 0 ? 'bg-primary' : 'bg-secondary' }}"></div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="mb-10">
                    <h1 class="text-4xl font-extrabold text-primary mb-3 tracking-tight">Konfirmasi Pendaftaran</h1>
                    <p class="text-on-surface-variant text-lg">Silakan tinjau kembali seluruh informasi Anda sebelum mengirim pendaftaran akhir.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-8">
                        <section class="bg-surface-container-lowest rounded-xl p-8 shadow-[0_2px_12px_rgba(30,58,95,0.08)]">
                            <div class="flex items-center justify-between mb-8">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-primary/5 rounded-lg flex items-center justify-center text-primary">
                                        <x-lucide-icon name="user" class="w-5 h-5" />
                                    </div>
                                    <h3 class="text-xl font-bold text-primary">Data Pribadi</h3>
                                </div>
                                <a href="{{ route('form.step1') }}" class="text-primary font-bold text-sm flex items-center gap-1 hover:underline">
                                    <x-lucide-icon name="file-text" class="w-4 h-4" /> Ubah
                                </a>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-12">
                                @foreach ([
                                    ['label' => 'Nama Lengkap', 'val' => $applicant->full_name],
                                    ['label' => 'NIK', 'val' => '3201234567890001'],
                                    ['label' => 'Tempat, Tanggal Lahir', 'val' => trim(($applicant->birth_place ?? '-') . ($applicant->birth_day ? ', ' . $applicant->birth_day . ' ' . $applicant->birth_month . ' ' . $applicant->birth_year : ''))],
                                    ['label' => 'Email', 'val' => $applicant->email],
                                ] as $item)
                                    <div>
                                        <label class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold mb-1 block">{{ $item['label'] }}</label>
                                        <p class="text-on-surface font-semibold">{{ $item['val'] }}</p>
                                    </div>
                                @endforeach
                                <div class="md:col-span-2">
                                    <label class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold mb-1 block">Alamat Sesuai KTP</label>
                                    <p class="text-on-surface font-semibold leading-relaxed">{{ $applicant->address ?? '-' }}</p>
                                </div>
                            </div>
                        </section>

                        <section class="bg-surface-container-lowest rounded-xl p-8 shadow-[0_2px_12px_rgba(30,58,95,0.08)]">
                            <div class="flex items-center justify-between mb-8">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-primary/5 rounded-lg flex items-center justify-center text-primary">
                                        <x-lucide-icon name="school" class="w-5 h-5" />
                                    </div>
                                    <h3 class="text-xl font-bold text-primary">Akademik</h3>
                                </div>
                                <a href="{{ route('form.step2') }}" class="text-primary font-bold text-sm flex items-center gap-1 hover:underline">
                                    <x-lucide-icon name="file-text" class="w-4 h-4" /> Ubah
                                </a>
                            </div>
                            <div class="space-y-6">
                                <div class="p-5 bg-surface-container-low rounded-lg flex items-center justify-between">
                                    <div>
                                        <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold mb-1">Pilihan Program Studi 1</p>
                                        <p class="text-primary font-extrabold text-lg">S1 Teknik Informatika</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="px-3 py-1 bg-secondary/10 text-secondary text-[10px] font-black rounded-full uppercase tracking-tighter italic">Pilihan Utama</span>
                                    </div>
                                </div>
                                <div class="p-5 bg-surface-container-low rounded-lg flex items-center justify-between opacity-80">
                                    <div>
                                        <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold mb-1">Pilihan Program Studi 2</p>
                                        <p class="text-primary font-bold">S1 Sistem Informasi</p>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <div class="space-y-8">
                        <section class="bg-surface-container-lowest rounded-xl p-8 shadow-[0_2px_12px_rgba(30,58,95,0.08)]">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-primary/5 rounded-lg flex items-center justify-center text-primary">
                                        <x-lucide-icon name="file-text" class="w-5 h-5" />
                                    </div>
                                    <h3 class="text-xl font-bold text-primary">Dokumen</h3>
                                </div>
                            </div>
                            <div class="space-y-3">
                                @foreach ([
                                    ['name' => 'Pas Foto 3x4', 'info' => $applicant->photo_path ? basename($applicant->photo_path) : 'Belum ada file'],
                                    ['name' => 'Scan KTP', 'info' => $applicant->id_card_path ? basename($applicant->id_card_path) : 'Belum ada file'],
                                    ['name' => 'Ijazah / SKL', 'info' => $applicant->diploma_path ? basename($applicant->diploma_path) : 'Belum ada file'],
                                    ['name' => 'Transkrip Nilai', 'info' => $applicant->transcript_path ? basename($applicant->transcript_path) : 'Belum ada file'],
                                ] as $doc)
                                    <div class="flex items-center gap-3 p-3 bg-surface-container-low rounded-lg">
                                        <x-lucide-icon name="check-circle" class="text-green-600 w-5 h-5" />
                                        <div class="flex-1">
                                            <p class="text-xs font-bold text-primary">{{ $doc['name'] }}</p>
                                            <p class="text-[10px] text-on-surface-variant font-medium">{{ $doc['info'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <a href="{{ route('form.step2') }}" class="w-full mt-4 inline-flex justify-center py-2 text-primary font-bold text-sm hover:underline">Lihat Semua Dokumen</a>
                        </section>

                        <section class="bg-primary rounded-xl p-8 text-white shadow-2xl relative overflow-hidden">
                            <div class="absolute -top-10 -right-10 w-32 h-32 bg-secondary blur-3xl opacity-20"></div>
                            <h3 class="text-lg font-extrabold mb-4 relative z-10">Pernyataan Keaslian Data</h3>
                            <div class="flex gap-4 mb-8 relative z-10">
                                <div class="pt-1">
                                    <input type="checkbox" id="declaration" class="w-5 h-5 rounded border-white/20 bg-white/10 text-secondary focus:ring-secondary transition-all" />
                                </div>
                                <label for="declaration" class="text-sm text-slate-300 leading-relaxed cursor-pointer select-none">
                                    Saya menyatakan bahwa seluruh data yang saya masukkan adalah benar dan dapat dipertanggungjawabkan sesuai dengan hukum yang berlaku di Indonesia.
                                </label>
                            </div>
                            <button class="w-full py-4 bg-secondary text-white font-black text-lg rounded-xl shadow-lg hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-3 relative z-10 group">
                                Kirim Pendaftaran
                                <x-lucide-icon name="send" class="w-5 h-5 group-hover:translate-x-1 transition-transform" />
                            </button>
                            <p class="text-center text-[10px] text-slate-400 mt-4 italic">Pendaftaran tidak dapat diubah setelah dikirim.</p>
                        </section>
                    </div>
                </div>

                <div class="mt-12 flex flex-col md:flex-row items-center justify-between gap-6 pb-20">
                    <a href="{{ route('form.step2') }}" class="flex items-center gap-2 text-slate-500 font-bold hover:text-primary transition-colors">
                        <x-lucide-icon name="arrow-left" class="w-5 h-5" /> Kembali ke Langkah 2
                    </a>
                    <div class="flex items-center gap-4 p-4 bg-surface-container rounded-xl">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-primary shadow-sm">
                            <x-lucide-icon name="message-circle" class="w-5 h-5" />
                        </div>
                        <div>
                            <p class="text-sm font-bold text-primary leading-none">Butuh Bantuan?</p>
                            <p class="text-xs text-on-surface-variant mt-1">Hubungi sekretariat melalui WhatsApp (08:00 - 16:00)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
