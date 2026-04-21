@extends('layouts.app')

@section('content')
    <style>
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .anim-fade-up {
            animation: fadeUp 0.5s ease forwards;
        }

        .anim-fade-up-delay {
            animation: fadeUp 0.5s ease 0.1s forwards;
            opacity: 0;
        }

        .anim-fade-right {
            animation: fadeRight 0.5s ease forwards;
        }

        .anim-fade-right-delay {
            animation: fadeRight 0.5s ease 0.1s forwards;
            opacity: 0;
        }
    </style>

    <div class="flex min-h-screen font-sans bg-background selection:bg-secondary/30">
        @include('partials.sidebar', ['activePage' => 'formulir'])

    <main class="ml-65 flex-1">
            @include('partials.topbar', ['pageTitle' => 'Formulir Pendaftaran'])

            <div class="p-10 max-w-6xl mx-auto">
                <div class="mb-12">
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col items-center gap-2 group">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center transition-all {{ $currentStep >= 1 ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-surface-container text-slate-400' }}">
                                <i class="bi bi-check-lg text-lg"></i>
                            </div>
                            <span class="text-xs font-bold {{ $currentStep >= 1 ? 'text-primary' : 'text-slate-400 opacity-60' }}">Data Pribadi</span>
                        </div>
                        <div class="flex-1 h-1 mx-4 bg-primary/20 rounded-full overflow-hidden">
                            <div class="h-full bg-primary" style="width:100%"></div>
                        </div>
                        <div class="flex flex-col items-center gap-2 group">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center transition-all {{ $currentStep >= 2 ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-surface-container text-slate-400' }}">
                                <i class="bi bi-check-lg text-lg"></i>
                            </div>
                            <span class="text-xs font-bold {{ $currentStep >= 2 ? 'text-primary' : 'text-slate-400 opacity-60' }}">Dokumen</span>
                        </div>
                        <div class="flex-1 h-1 mx-4 bg-secondary/20 rounded-full overflow-hidden">
                            <div class="h-full bg-secondary" style="width:50%"></div>
                        </div>
                        <div class="flex flex-col items-center gap-2 group">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center transition-all {{ $currentStep === 3 ? 'bg-secondary text-primary font-black ring-4 ring-secondary/20' : 'bg-surface-container text-slate-400' }}">
                                <span class="text-sm font-black">3</span>
                            </div>
                            <span class="text-xs font-bold {{ $currentStep === 3 ? 'text-primary' : 'text-slate-400 opacity-60' }}">Konfirmasi</span>
                        </div>
                    </div>
                </div>

                <div class="mb-10">
                    <h2 class="text-4xl font-extrabold text-primary mb-3 tracking-tight font-plus-jakarta leading-tight">Konfirmasi Pendaftaran</h2>
                    <p class="text-on-surface-variant text-lg">Silakan tinjau kembali seluruh informasi Anda sebelum mengirim pendaftaran akhir.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-8">
                        <div class="bg-white rounded-xl p-8 shadow-premium anim-fade-up">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-primary/5 rounded-lg flex items-center justify-center text-primary">
                                        <i class="bi bi-person text-lg"></i>
                                    </div>
                                    <h3 class="text-xl font-bold text-primary font-plus-jakarta">Data Pribadi</h3>
                                </div>
                                <button class="text-primary font-bold text-sm flex items-center gap-1 hover:underline transition-all">
                                    <i class="bi bi-pencil text-xs"></i>
                                    Ubah
                                </button>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-12 mt-8 text-sm">
                                <div>
                                    <label class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold mb-1 block">Nama Lengkap</label>
                                    <p class="text-primary font-semibold">{{ $pendaftaran->nama_lengkap }}</p>
                                </div>
                                <div>
                                    <label class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold mb-1 block">NIK</label>
                                    <p class="text-primary font-semibold">{{ $pendaftaran->nik }}</p>
                                </div>
                                <div>
                                    <label class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold mb-1 block">Tempat, Tanggal Lahir</label>
                                    <p class="text-primary font-semibold">{{ $pendaftaran->tempat_lahir }}, {{ \Carbon\Carbon::parse($pendaftaran->tanggal_lahir)->translatedFormat('d F Y') }}</p>
                                </div>
                                <div>
                                    <label class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold mb-1 block">Email</label>
                                    <p class="text-primary font-semibold">{{ $pendaftaran->email }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold mb-1 block">Alamat Sesuai KTP</label>
                                    <p class="text-primary font-semibold">{{ $pendaftaran->alamat_ktp }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl p-8 shadow-premium anim-fade-up-delay">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-primary/5 rounded-lg flex items-center justify-center text-primary">
                                        <i class="bi bi-mortarboard-fill text-lg"></i>
                                    </div>
                                    <h3 class="text-xl font-bold text-primary font-plus-jakarta">Akademi</h3>
                                </div>
                                <button class="text-primary font-bold text-sm flex items-center gap-1 hover:underline transition-all">
                                    <i class="bi bi-pencil text-xs"></i>
                                    Ubah
                                </button>
                            </div>
                            <div class="space-y-6 mt-8">
                                <div class="p-5 bg-surface-container-low rounded-lg flex items-center justify-between border border-transparent hover:border-secondary/20 transition-all">
                                    <div>
                                        <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold mb-1">Pilihan Program Studi 1</p>
                                        <p class="text-primary font-extrabold text-lg">{{ $pendaftaran->prodi_pilihan_1 }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="px-3 py-1 bg-secondary/10 text-secondary text-[10px] font-black rounded-full uppercase tracking-tighter italic">Pilihan Utama</span>
                                    </div>
                                </div>
                                <div class="p-5 bg-surface-container-low rounded-lg flex items-center justify-between opacity-80">
                                    <div>
                                        <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold mb-1">Pilihan Program Studi 2</p>
                                        <p class="text-primary font-bold">{{ $pendaftaran->prodi_pilihan_2 }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <div class="bg-white rounded-xl p-8 shadow-premium anim-fade-right">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-10 h-10 bg-primary/5 rounded-lg flex items-center justify-center text-primary">
                                    <i class="bi bi-folder2-open text-lg"></i>
                                </div>
                                <h3 class="text-xl font-bold text-primary font-plus-jakarta">Dokumen</h3>
                            </div>
                            <div class="space-y-3">
                                @foreach ($dokumen as $doc)
                                    <div class="flex items-center gap-3 p-3 bg-surface-container-low rounded-lg border border-transparent hover:border-primary/5 transition-all group">
                                        <i class="bi bi-check-circle-fill text-green-600 text-lg"></i>
                                        <div class="flex-1">
                                            <p class="text-xs font-bold text-primary">{{ $doc['name'] }}</p>
                                            <p class="text-[10px] text-on-surface-variant group-hover:text-primary transition-colors">{{ $doc['filename'] }} ({{ $doc['size'] }})</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button class="w-full mt-6 py-2 text-primary font-bold text-sm hover:underline transition-all">Lihat Semua Dokumen</button>
                        </div>

                        <div class="bg-primary rounded-xl p-8 text-white shadow-2xl relative overflow-hidden anim-fade-right-delay">
                            <div class="absolute -top-10 -right-10 w-32 h-32 bg-secondary blur-3xl opacity-20"></div>
                            <h3 class="text-lg font-extrabold mb-4 relative z-10 font-plus-jakarta">Pernyataan Keaslian Data</h3>
                            <form method="POST" action="{{ route('mahasiswa.konfirmasi.kirim') }}">
                                @csrf
                                <div class="flex gap-4 mb-8 relative z-10">
                                    <div class="pt-1">
                                        <input
                                            id="declaration"
                                            type="checkbox"
                                            name="pernyataan"
                                            required
                                            class="w-5 h-5 rounded border-white/20 bg-white/10 text-secondary focus:ring-secondary cursor-pointer transition-all"
                                        />
                                    </div>
                                    <label for="declaration" class="text-sm text-slate-300 leading-relaxed cursor-pointer select-none">
                                        Saya menyatakan bahwa seluruh data yang saya masukkan adalah benar dan dapat dipertanggungjawabkan sesuai dengan hukum yang berlaku di Indonesia.
                                    </label>
                                </div>
                                <button type="submit" class="w-full py-4 bg-secondary text-primary font-black text-lg rounded-lg shadow-lg hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-3 relative z-10 group">
                                    Kirim Pendaftaran
                                    <i class="bi bi-send-fill group-hover:translate-x-1 transition-transform text-lg"></i>
                                </button>
                                <p class="text-center text-[10px] text-slate-400 mt-4 italic">Pendaftaran tidak dapat diubah setelah dikirim.</p>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="mt-12 flex flex-col md:flex-row items-center justify-between gap-6 pb-20">
                    <a href="{{ route('form.step2') }}" class="flex items-center gap-2 text-slate-500 font-bold hover:text-primary transition-all group">
                        <i class="bi bi-arrow-left group-hover:-translate-x-1 transition-transform text-lg"></i>
                        Kembali ke Langkah 2
                    </a>
                    <div class="flex items-center gap-4 p-4 bg-surface-container rounded-xl shadow-premium">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-primary shadow-sm">
                            <i class="bi bi-headphones text-lg"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-primary leading-none">Butuh Bantuan?</p>
                            <p class="text-xs text-on-surface-variant mt-1">Hubungi sekretariat melalui WhatsApp (08:00 - 16:00)</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
