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

        @keyframes fadeLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fade-up {
            animation: fadeUp 0.5s ease forwards;
        }

        .animate-fade-left {
            animation: fadeLeft 0.5s ease forwards;
        }

        .animate-scale-in {
            animation: scaleIn 0.5s ease forwards;
        }

        .delay-1 {
            animation-delay: 0.1s;
            opacity: 0;
        }

        .delay-2 {
            animation-delay: 0.2s;
            opacity: 0;
        }

        .delay-3 {
            animation-delay: 0.3s;
            opacity: 0;
        }
    </style>

    <div class="flex min-h-screen bg-background font-sans text-primary">
        @include('partials.sidebar', ['activePage' => 'unduh-bukti'])

        <main class="flex-1 transition-all ml-65">
            @include('partials.topbar', [
                'pageLabel' => 'E-Sertifikat & Bukti',
                'userName' => $student->nama_lengkap,
                'userRole' => 'Calon Mahasiswa',
                'userAvatar' => $student->foto_url,
            ])

            <section class="mx-auto max-w-6xl px-10 py-12">
                <div class="mb-12 animate-fade-up">
                    <h2 class="font-display text-4xl font-extrabold tracking-tight text-primary">Bukti Pendaftaran Resmi</h2>
                    <p class="mt-2 text-lg text-slate-600">Silakan unduh dan simpan kartu bukti pendaftaran Anda sebagai syarat verifikasi dokumen fisik.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
                    <div class="md:col-span-12 lg:col-span-5 space-y-6">
                        <div class="relative overflow-hidden rounded-2xl bg-white p-8 shadow-sm border border-slate-100 animate-fade-left delay-1">
                            <div class="pointer-events-none absolute -right-6 -top-6 h-24 w-24 rounded-full bg-primary/5"></div>
                            <h3 class="mb-6 flex items-center gap-2 text-xl font-bold text-primary">
                                <i class="bi bi-info-circle text-secondary text-xl"></i>
                                Panduan Penting
                            </h3>
                            <ul class="space-y-6">
                                <li class="flex gap-4">
                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-primary text-sm font-bold text-white">1</div>
                                    <p class="text-sm leading-relaxed text-slate-600">Pastikan seluruh data yang tertera pada kartu bukti pendaftaran sudah <span class="font-bold">benar dan valid</span>.</p>
                                </li>
                                <li class="flex gap-4">
                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-primary text-sm font-bold text-white">2</div>
                                    <p class="text-sm leading-relaxed text-slate-600">Cetak kartu ini menggunakan kertas <span class="font-bold">HVS A4 minimal 80 gram</span> untuk kualitas terbaik.</p>
                                </li>
                                <li class="flex gap-4">
                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-primary text-sm font-bold text-white">3</div>
                                    <p class="text-sm leading-relaxed text-slate-600">Bawa kartu ini beserta dokumen pendukung saat melakukan <span class="font-bold">verifikasi luring</span> di kampus.</p>
                                </li>
                            </ul>
                        </div>

                        <div class="flex flex-col items-center rounded-2xl bg-primary p-8 text-center text-white shadow-xl animate-fade-left delay-2">
                            <div class="mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-secondary text-primary shadow-lg shadow-secondary/30">
                                <i class="bi bi-file-text text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold">{{ $student->nomor_resmi ? 'Siap untuk diunduh' : 'PDF belum tersedia' }}</h3>
                            <p class="mb-8 mt-2 text-sm text-white/70">
                                @if ($student->nomor_resmi)
                                    Format file PDF (2.4 MB). Dokumen ini telah ditandatangani secara elektronik oleh Bagian Admisi.
                                @else
                                    Bukti pendaftaran PDF dapat diunduh setelah pendaftaran dikirim dan nomor pendaftaran resmi terbit.
                                @endif
                            </p>
                            @if ($student->nomor_resmi)
                                <a href="{{ route('mahasiswa.unduh-bukti-pdf') }}" class="flex w-full cursor-pointer items-center justify-center gap-3 rounded-xl bg-secondary py-4 font-bold text-primary shadow-lg shadow-secondary/20 transition-all hover:-translate-y-0.5 hover:brightness-110 active:scale-95 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70">
                                    <i class="bi bi-download text-lg"></i>
                                    Unduh Bukti Pendaftaran (PDF)
                                </a>
                            @else
                                <div aria-disabled="true" class="flex w-full cursor-not-allowed items-center justify-center gap-3 rounded-xl bg-white/10 py-4 font-bold text-white/60 opacity-50">
                                    <i class="bi bi-lock-fill text-lg"></i>
                                    PDF Belum Tersedia
                                </div>
                            @endif
                            @if ($errors->has('pdf'))
                                <p class="mt-4 text-xs font-semibold text-white/80">{{ $errors->first('pdf') }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="md:col-span-12 lg:col-span-7">
                        <div class="rounded-2xl bg-slate-200 p-1 md:p-6 animate-scale-in delay-3">
                            <div class="aspect-[1/1.414] w-full overflow-hidden rounded-xl bg-white shadow-2xl">
                                <div class="h-full flex flex-col">
                                    <div class="flex items-center justify-between bg-primary p-8 text-white">
                                        <div class="flex items-center gap-4">
                                            <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-white">
                                                <i class="bi bi-mortarboard-fill text-primary text-lg"></i>
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-bold uppercase tracking-wider leading-tight">Kartu Tanda Peserta</h4>
                                                <p class="text-[10px] font-medium text-white/70">{{ $institution['nama'] }}</p>
                                                @if ($student->tahun_akademik)
                                                    <p class="text-[10px] font-medium text-white/70">Tahun Akademik {{ $student->tahun_akademik }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-[10px] font-bold tracking-widest text-secondary uppercase">No. Pendaftaran</p>
                                            <p class="font-mono text-xl font-bold">{{ $student->no_pendaftaran }}</p>
                                        </div>
                                    </div>

                                    <div class="flex-1 p-10">
                                        <div class="mb-10 flex gap-10">
                                            <div class="relative flex h-52 w-40 flex-col items-center justify-center rounded border-2 border-dashed border-slate-300 bg-slate-50 text-slate-400">
                                                @if ($student->foto_url)
                                                    <img
                                                        src="{{ $student->foto_url }}"
                                                        alt="Student"
                                                        class="absolute h-full w-full object-cover rounded"
                                                    />
                                                @else
                                                    <span class="px-4 text-center text-[10px] font-bold uppercase tracking-widest">Foto belum tersedia</span>
                                                @endif
                                                <div class="absolute bottom-2 rounded bg-black/50 px-2 py-1 text-[10px] text-white">
                                                    Pas Foto 3x4
                                                </div>
                                            </div>

                                            <div class="flex-1 space-y-6">
                                                <div class="border-b border-slate-100 pb-2">
                                                    <p class="text-[10px] font-bold tracking-wide text-slate-400 uppercase">Nama Lengkap</p>
                                                    <p class="text-base font-bold text-primary">{{ $student->nama_lengkap }}</p>
                                                </div>
                                                <div class="border-b border-slate-100 pb-2">
                                                    <p class="text-[10px] font-bold tracking-wide text-slate-400 uppercase">Program Studi Pilihan</p>
                                                    <p class="text-base font-bold text-primary">{{ $student->program_studi ?: 'Belum dipilih' }}</p>
                                                    @if ($student->fakultas)
                                                        <p class="text-xs font-semibold text-slate-500">{{ $student->fakultas }}</p>
                                                    @endif
                                                </div>
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div class="border-b border-slate-100 pb-2">
                                                        <p class="text-[10px] font-bold tracking-wide text-slate-400 uppercase">Asal Sekolah</p>
                                                        <p class="text-base font-bold text-primary">{{ $student->asal_sekolah ?: 'Belum diisi' }}</p>
                                                    </div>
                                                    <div class="border-b border-slate-100 pb-2">
                                                        <p class="text-[10px] font-bold tracking-wide text-slate-400 uppercase">Gelombang</p>
                                                        <p class="text-base font-bold text-primary">{{ $student->gelombang ?: 'Belum ditentukan' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-auto flex items-end justify-between">
                                            <div class="space-y-4">
                                                <div class="inline-block rounded-lg bg-slate-50 p-2">
                                                    <i class="bi bi-qr-code text-slate-800 text-3xl"></i>
                                                </div>
                                                <p class="max-w-50 text-[10px] leading-relaxed text-slate-400">
                                                    Scan kode di atas untuk memverifikasi keaslian dokumen secara online melalui portal resmi kami.
                                                </p>
                                            </div>

                                            <div class="text-center">
                                                <p class="mb-12 text-[10px] text-slate-500">{{ $student->tanggal_cetak }}</p>
                                                <div class="mx-auto mb-2 h-16 w-32 border-b border-slate-300 relative">
                                                    <span class="pointer-events-none absolute inset-0 flex -rotate-6 items-center justify-center font-serif text-2xl italic text-primary/10">Panitia PMB</span>
                                                </div>
                                                <p class="text-[10px] font-bold text-primary uppercase">Panitia Admisi {{ $institution['nama'] }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between border-t border-slate-100 bg-slate-50 px-8 py-4 text-[10px] font-bold tracking-widest text-slate-400 uppercase">
                                        <span>Dokumen Sah & Berlaku Selama Masa Pendaftaran</span>
                                        <span>Halaman 1 dari 1</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 flex items-center justify-center gap-2 text-xs font-medium text-slate-500">
                                <i class="bi bi-eye text-sm"></i>
                                Tampilan Pratinjau Dokumen
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
@endsection
