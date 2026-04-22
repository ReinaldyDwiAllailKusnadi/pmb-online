@extends('layouts.app')

@section('content')
    <style>
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scale-in {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.6s ease-out both;
        }

        .animate-scale-in {
            animation: scale-in 0.4s ease-out both;
        }
    </style>

    <div class="flex min-h-screen">
        @include('partials.sidebar', ['sidebarLinks' => $sidebarLinks])

        <main class="ml-[260px] flex-1 bg-bg-light">
            @include('partials.topbar', ['user' => $user])

            <div class="p-8 max-w-7xl mx-auto space-y-10">
                @if (session('success'))
                    <div class="rounded-2xl border border-green-100 bg-green-50 px-6 py-4 text-sm font-semibold text-green-800 shadow-sm">
                        <i class="bi bi-check-circle-fill mr-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate-fade-in-up">
                    <div class="lg:col-span-2 bg-white rounded-2xl p-8 shadow-soft relative overflow-hidden flex flex-col md:flex-row items-center gap-8">
                        <div class="absolute top-0 right-0 w-48 h-48 bg-secondary/5 rounded-full -mr-16 -mt-16 pointer-events-none"></div>
                        <div class="relative z-10 w-24 h-24 shrink-0 flex items-center justify-center rounded-full bg-secondary/10 text-secondary ring-8 ring-secondary/5">
                            <i class="bi {{ $currentStatus['icon'] }} text-4xl"></i>
                        </div>
                        <div class="relative z-10 flex-1 space-y-4 text-center md:text-left">
                            <div>
                                <h3 class="text-slate-500 text-xs font-bold uppercase tracking-widest mb-1">Status Saat Ini</h3>
                                <div class="flex flex-col md:flex-row md:items-center gap-4">
                                    <span class="text-3xl font-extrabold text-primary tracking-tight">{{ $currentStatus['label'] }}</span>
                                    <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-secondary text-white text-[10px] font-extrabold uppercase tracking-widest shadow-sm">
                                        {{ $currentStatus['badge'] }}
                                    </span>
                                </div>
                            </div>
                            <p class="text-slate-600 leading-relaxed max-w-md text-sm">
                                {{ $currentStatus['description'] }}
                            </p>
                            <div class="rounded-xl border border-slate-100 bg-slate-50 p-4 text-left">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Catatan Admin</p>
                                <p class="mt-2 text-sm font-medium leading-relaxed text-slate-700">
                                    {{ $catatanAdmin ?: 'Belum ada catatan dari admin.' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-primary rounded-2xl p-8 text-white flex flex-col justify-between shadow-soft relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -mr-8 -mt-8 pointer-events-none"></div>
                        <div>
                            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mb-4">Program Pilihan</p>
                            <h4 class="text-xl font-bold mb-1 tracking-tight">{{ $programInfo['program'] }}</h4>
                            <p class="text-slate-300 text-sm">{{ $programInfo['fakultas'] }}</p>
                        </div>
                        <div class="mt-8 pt-6 border-t border-white/10 flex justify-between items-center text-sm">
                            <span class="text-slate-400">Gelombang</span>
                            <span class="font-bold text-secondary">{{ $programInfo['gelombang'] }}</span>
                        </div>
                    </div>
                </div>

                <section>
                    <div class="flex items-center gap-4 mb-8">
                        <h3 class="text-2xl font-bold text-primary tracking-tight">Perjalanan Pendaftaran</h3>
                        <div class="h-px flex-1 bg-slate-200"></div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        @forelse ($timelineSteps as $step)
                            <div
                                class="p-6 rounded-2xl relative transition-all duration-300 border-b-4 animate-scale-in @if ($step['status'] === 'completed') bg-white border-primary @elseif ($step['status'] === 'current') bg-white border-secondary shadow-lg shadow-secondary/5 @else bg-slate-100 border-slate-300 opacity-60 @endif"
                                style="animation-delay: {{ $loop->index * 0.1 }}s;"
                            >
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center @if ($step['status'] === 'completed') bg-primary text-white @elseif ($step['status'] === 'current') bg-secondary text-white @else bg-slate-200 text-slate-500 @endif">
                                        @if ($step['status'] === 'completed')
                                            <i class="bi bi-check-lg w-5 h-5"></i>
                                        @elseif ($step['status'] === 'current')
                                            <i class="bi bi-arrow-repeat w-5 h-5 animate-spin duration-[1.5s]"></i>
                                        @else
                                            <i class="bi bi-clock w-5 h-5"></i>
                                        @endif
                                    </div>
                                    <span class="text-[10px] font-black uppercase @if ($step['status'] === 'current') text-secondary @else text-slate-400 @endif">
                                        @if ($step['status'] === 'current')
                                            Sedang Berlangsung
                                        @else
                                            {{ $step['id'] }}
                                        @endif
                                    </span>
                                </div>
                                <h5 class="font-bold text-primary text-sm mb-1">{{ $step['title'] }}</h5>
                                <p class="text-xs @if ($step['status'] === 'current') text-slate-600 font-medium italic @else text-slate-500 @endif">
                                    @if ($step['status'] === 'current')
                                        {{ $step['subtitle'] }}
                                    @else
                                        {{ $step['date'] }}
                                    @endif
                                </p>
                            </div>
                        @empty
                            <div class="md:col-span-4 rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center shadow-soft">
                                <p class="text-sm font-bold text-primary">Belum ada riwayat status.</p>
                                <p class="mt-2 text-sm text-slate-500">Timeline akan muncul setelah ada perubahan status pendaftaran.</p>
                            </div>
                        @endforelse
                    </div>
                </section>

                <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                    <div class="xl:col-span-2 space-y-6">
                        <div class="flex justify-between items-end">
                            <h3 class="text-xl font-bold text-primary tracking-tight">Riwayat Aktivitas</h3>
                            <button type="button" class="group flex cursor-pointer items-center gap-1.5 rounded-lg px-2 py-1 text-xs font-bold text-primary transition-colors hover:text-secondary active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/60">
                                Lihat Detail <i class="bi bi-arrow-right w-3 h-3 group-hover:translate-x-1 transition-transform"></i>
                            </button>
                        </div>
                        <div class="bg-white rounded-2xl overflow-hidden shadow-soft border border-slate-100">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-slate-50/50 border-b border-slate-100">
                                            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-500">Tanggal & Waktu</th>
                                            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-500">Aktivitas</th>
                                            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-500">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @forelse ($activityLog as $item)
                                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                                <td class="px-6 py-5 text-sm font-medium text-slate-700">{{ $item['date'] }}</td>
                                                <td class="px-6 py-5">
                                                    <div class="flex items-center gap-2.5">
                                                        <span class="w-2 h-2 rounded-full {{ $item['color'] }} group-hover:scale-125 transition-transform"></span>
                                                        <span class="text-sm font-bold text-primary">{{ $item['activity'] }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-5 text-sm text-slate-600 leading-relaxed">{{ $item['description'] }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="px-6 py-8 text-center text-sm font-medium text-slate-500">
                                                    Belum ada riwayat aktivitas status.
                                                </td>
                                            </tr>
                                        @endforelse
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
                                        <i class="bi bi-exclamation-circle w-5 h-5"></i>
                                    </div>
                                    <h5 class="font-bold text-primary text-sm">Cek Email Berkala</h5>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed">
                                    Pengumuman hasil verifikasi akan dikirimkan melalui email resmi dan notifikasi portal ini secara otomatis.
                                </p>
                            </div>

                            <div class="bg-white rounded-2xl p-6 shadow-soft space-y-4 border border-slate-100 hover:border-slate-200 transition-colors group">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-primary/5 flex items-center justify-center text-primary group-hover:bg-primary/10 transition-colors">
                                        <i class="bi bi-mortarboard w-5 h-5"></i>
                                    </div>
                                    <h5 class="font-bold text-primary text-sm">Persiapan Materi Ujian</h5>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed">
                                    Sambil menunggu, pelajari materi Tes Potensi Akademik dan Bahasa Inggris untuk tahap seleksi mendatang.
                                </p>
                                <button type="button" disabled aria-disabled="true" class="flex cursor-not-allowed items-center gap-1 rounded-lg text-[10px] font-black uppercase tracking-widest text-slate-400 opacity-70">
                                    Kisi-Kisi Segera Tersedia <i class="bi bi-lock-fill w-3 h-3"></i>
                                </button>
                            </div>

                            <div class="relative bg-gradient-to-br from-primary to-[#0f2a4a] rounded-2xl p-8 text-white overflow-hidden shadow-xl">
                                <div class="pointer-events-none absolute -bottom-6 -right-6 opacity-10">
                                    <i class="bi bi-chat-dots w-32 h-32"></i>
                                </div>
                                <div class="relative z-10">
                                    <h5 class="font-bold text-base mb-2">Punya Pertanyaan?</h5>
                                    <p class="text-xs text-slate-300 mb-6 leading-relaxed">Tim Customer Service kami siap membantu Anda selama jam operasional kerja.</p>
                                    <button type="button" disabled aria-disabled="true" class="w-full cursor-not-allowed rounded-xl bg-white/10 py-3 text-xs font-bold uppercase tracking-widest text-white/60 shadow-lg">
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
                            src="{{ asset('images/accreditation.png') }}"
                            alt="Accreditation"
                        />
                    </div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">
                        © 2024 Akademi PMB - Direktorat Sistem Informasi
                    </p>
                </footer>
            </div>
        </main>
    </div>
@endsection

