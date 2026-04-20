<x-app-layout title="Unduh Bukti PDF">
    <div class="flex">
        @include('partials.sidebar', ['activePage' => 'unduh-bukti'])

        <div class="ml-65 flex-1 min-h-screen">
            @include('partials.topbar', [
                'pageLabel' => 'Unduh Bukti PDF',
                'userName' => $applicant->full_name,
                'userRole' => 'Calon Mahasiswa',
                'userAvatar' => 'https://ui-avatars.com/api/?name=' . urlencode($applicant->full_name),
            ])

            <section class="p-10 max-w-6xl mx-auto">
                <div class="mb-12">
                    <h1 class="text-4xl font-extrabold text-primary mb-2 tracking-tight">Bukti Pendaftaran Resmi</h1>
                    <p class="text-on-surface-variant text-lg">Silakan unduh dan simpan kartu bukti pendaftaran Anda sebagai syarat verifikasi dokumen fisik.</p>
                </div>

                <div class="grid grid-cols-12 gap-8">
                    <div class="col-span-12 lg:col-span-5 space-y-6">
                        <div class="bg-surface-container-lowest p-8 rounded-2xl shadow-[0_4px_20px_rgba(30,58,95,0.04)] relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-primary/5 rounded-bl-full -mr-10 -mt-10"></div>
                            <h3 class="text-xl font-bold text-primary mb-6 flex items-center gap-2">
                                <x-lucide-icon name="info" class="text-secondary w-5 h-5" /> Panduan Penting
                            </h3>
                            <ul class="space-y-6">
                                @foreach ([
                                    'Pastikan seluruh data yang tertera pada kartu bukti pendaftaran sudah <strong>benar dan valid</strong>.',
                                    'Cetak kartu ini menggunakan kertas <strong>HVS A4 minimal 80 gram</strong> untuk kualitas terbaik.',
                                    'Bawa kartu ini beserta dokumen pendukung saat melakukan <strong>verifikasi luring</strong> di kampus.'
                                ] as $idx => $txt)
                                    <li class="flex gap-4">
                                        <div class="shrink-0 w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm">{{ $idx + 1 }}</div>
                                        <p class="text-on-surface-variant text-sm leading-relaxed">{!! $txt !!}</p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="bg-primary p-8 rounded-2xl text-white shadow-xl flex flex-col items-center text-center">
                            <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mb-6">
                                <x-lucide-icon name="file-down" class="w-8 h-8 text-secondary" />
                            </div>
                            <h3 class="text-xl font-bold mb-3">Siap untuk diunduh</h3>
                            <p class="text-white/70 text-sm mb-8">Format file PDF (2.4 MB). Dokumen ini telah ditandatangani secara elektronik oleh Bagian Admisi.</p>
                            <button class="w-full py-4 bg-secondary hover:bg-secondary/90 text-white font-bold rounded-xl transition-all flex items-center justify-center gap-3 active:scale-95 shadow-lg">
                                <x-lucide-icon name="download" class="w-5 h-5" /> Unduh Bukti Pendaftaran (PDF)
                            </button>
                        </div>
                    </div>

                    <div class="col-span-12 lg:col-span-7">
                        <div class="bg-surface-container p-4 rounded-2xl border border-outline-variant/20">
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col aspect-[1/1.414] max-w-full">
                                <div class="bg-primary p-8 text-white flex justify-between items-center">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center">
                                            <x-lucide-icon name="school" class="text-primary w-7 h-7" />
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-lg leading-tight uppercase tracking-wide">Kartu Tanda Peserta</h4>
                                            <p class="text-xs text-white/70 font-medium">Penerimaan Mahasiswa Baru TA 2024/2025</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[10px] uppercase font-bold tracking-widest text-secondary">No. Pendaftaran</p>
                                        <p class="text-xl font-mono font-bold">PMB-2024-00128</p>
                                    </div>
                                </div>
                                <div class="p-10 flex-1 flex flex-col">
                                    <div class="flex gap-10 mb-10">
                                        <div class="w-40 h-52 bg-slate-100 border-2 border-dashed border-slate-300 rounded flex flex-col items-center justify-center text-slate-400 relative overflow-hidden">
                                            <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuC_B7RC7AHKW1B5BbjBZYux5Qabxq_jh6eYLKacg_2BD3S69KtLsAVmwaDYOqJuPuHoc--4dPTQI6VgSwsB7-7c4xTPZIxh4kQTaG8eU9Rq-2VcBZpDDxiOieesXXhiYCAHUFkW7SI3CUBVl8bzyfVGjxyPDER0E6wcQW4b5KRtWxX2SYZha56RvRgX10nRylB0WXuu7JaTSHe2paxEqUQVnrpgxLkMzhlpUZ7jK27k87prDQLo-5HALcE0kdpm5QxHSLOcGOZ1Py4" alt="Photo" class="absolute inset-0 w-full h-full object-cover" />
                                            <p class="text-[8px] absolute bottom-2 bg-black/50 text-white px-2 py-1 rounded">Pas Foto 3x4</p>
                                        </div>
                                        <div class="flex-1 space-y-6">
                                            <div>
                                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wide mb-1">Nama Lengkap</p>
                                                <p class="text-lg font-bold text-primary">{{ $applicant->full_name }}</p>
                                            </div>
                                            <div>
                                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wide mb-1">Program Studi Pilihan</p>
                                                <p class="text-md font-semibold text-primary">Teknik Informatika (S1)</p>
                                            </div>
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wide mb-1">Asal Sekolah</p>
                                                    <p class="text-sm font-semibold text-primary">SMAN 1 Jakarta</p>
                                                </div>
                                                <div>
                                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wide mb-1">Lokasi Ujian</p>
                                                    <p class="text-sm font-semibold text-primary">Gedung Rektorat Lt. 2</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-auto flex justify-between items-end">
                                        <div class="space-y-4">
                                            <div class="p-2 border bg-slate-50 rounded-lg inline-block">
                                                <div class="w-24 h-24 bg-slate-200 flex items-center justify-center rounded">
                                                    <span class="text-[8px] text-slate-400">QR CODE VERIFICATION</span>
                                                </div>
                                            </div>
                                            <p class="text-[10px] text-slate-400 max-w-50">Scan kode di atas untuk memverifikasi keaslian dokumen secara online melalui portal resmi kami.</p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-[10px] text-slate-500 mb-12">Jakarta, 15 Juli 2024</p>
                                            <div class="w-32 h-px border-t border-slate-300 mx-auto mb-2 relative">
                                                <div class="absolute inset-0 -top-6 flex items-center justify-center">
                                                    <span class="text-primary/20 font-serif italic text-2xl rotate-[-5deg]">Panitia PMB</span>
                                                </div>
                                            </div>
                                            <p class="text-[10px] font-bold text-primary">Panitia Admisi Akademi PMB</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-slate-50 py-4 px-8 border-t border-slate-100 flex justify-between items-center text-[8px] text-slate-400 uppercase tracking-widest font-bold">
                                    <span>Dokumen Sah & Berlaku Selama Masa Pendaftaran</span>
                                    <span>Halaman 1 dari 1</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>