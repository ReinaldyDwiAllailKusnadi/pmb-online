<x-app-layout title="Dashboard">
    <div class="flex">
        @include('partials.sidebar', ['activePage' => 'beranda'])

        <div class="ml-65 flex-1 flex flex-col min-h-screen">
            @include('partials.topbar', [
                'pageLabel' => 'Beranda',
                'userName' => $applicant->full_name,
                'userRole' => 'Calon Mahasiswa',
                'userAvatar' => 'https://ui-avatars.com/api/?name=' . urlencode($applicant->full_name),
            ])

            <div class="p-8 space-y-8 max-w-7xl mx-auto w-full">
                <nav class="flex items-center gap-2 text-sm text-on-surface-variant font-medium">
                    <span>Beranda</span>
                    <span class="text-slate-400">›</span>
                    <span class="text-primary font-bold">Dashboard Siswa</span>
                </nav>

                @if ($applicant->status === 'draft')
                    <div class="rounded-2xl border border-amber-100 bg-amber-50 px-6 py-4 text-sm text-amber-800 shadow-sm">
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-secondary-container text-white">
                                <x-lucide-icon name="info" class="h-4.5 w-4.5" />
                            </div>
                            <div>
                                <p class="font-bold text-primary">Pendaftaran belum dimulai.</p>
                                <p class="mt-1 leading-relaxed">
                                    Draft pendaftaran Anda sudah dibuat otomatis. Lengkapi biodata dan dokumen untuk memulai proses PMB.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <section class="relative rounded-2xl overflow-hidden bg-primary-container p-10 flex flex-col md:flex-row justify-between items-center gap-8 shadow-lg">
                    <div class="z-10 text-center md:text-left">
                        <div class="inline-flex items-center px-3 py-1 bg-white/10 text-secondary-container rounded-full text-xs font-bold tracking-widest uppercase mb-4">
                            <span class="mr-2">●</span> Calon Mahasiswa
                        </div>
                        <h1 class="text-4xl md:text-5xl font-headline font-extrabold text-white leading-tight mb-3">
                            Selamat Datang, <br />{{ $applicant->full_name }}!
                        </h1>
                        <p class="text-blue-100/70 text-lg max-w-md">
                            Lengkapi administrasi Anda untuk menjadi bagian dari generasi unggul di institusi kami.
                        </p>
                        <a href="{{ route('form.step1') }}" class="mt-8 inline-flex cursor-pointer rounded-xl bg-secondary-container px-8 py-3 font-bold text-white shadow-lg shadow-secondary-container/20 transition-all hover:scale-[1.02] hover:brightness-105 active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary-container/70">
                            Lengkapi Profil
                        </a>
                    </div>
                    <div class="relative z-10 w-64 h-64 rounded-full border-8 border-white/10 p-4 bg-linear-to-tr from-white/5 to-transparent flex items-center justify-center">
                        <x-lucide-icon name="school" class="w-32 h-32 text-white/20" />
                    </div>
                </section>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 bg-surface-container-lowest p-8 rounded-2xl shadow-subtle">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-lg font-bold text-primary tracking-tight">Tahap Pendaftaran</h3>
                            <span class="text-sm font-medium text-on-surface-variant">{{ $progress['percentage'] }}% Selesai</span>
                        </div>
                        <div class="flex items-center justify-between relative px-2">
                            <div class="absolute top-5 left-10 right-10 h-1 bg-surface-container-high z-0">
                                <div class="h-full bg-primary rounded-full" style="width: {{ $progress['percentage'] }}%;"></div>
                            </div>
                            <div class="relative z-10 flex flex-col items-center gap-3">
                                <div class="w-10 h-10 rounded-full {{ $progress['steps']['biodata'] === 'completed' ? 'bg-primary text-white shadow-md' : ($progress['steps']['biodata'] === 'current' ? 'bg-secondary-container text-white shadow-md animate-pulse' : 'bg-surface-container-high text-on-surface-variant/40') }} flex items-center justify-center">
                                    <x-lucide-icon name="check" class="w-4.5 h-4.5" />
                                </div>
                                <span class="text-sm {{ $progress['steps']['biodata'] === 'current' ? 'font-bold text-secondary-container' : ($progress['steps']['biodata'] === 'completed' ? 'font-bold text-primary' : 'font-medium text-on-surface-variant') }}">Data Pribadi</span>
                            </div>
                            <div class="relative z-10 flex flex-col items-center gap-3">
                                <div class="w-10 h-10 rounded-full {{ $progress['steps']['documents'] === 'completed' ? 'bg-primary text-white shadow-md' : ($progress['steps']['documents'] === 'current' ? 'bg-secondary-container text-white shadow-md animate-pulse' : 'bg-surface-container-high text-on-surface-variant/40') }} flex items-center justify-center">
                                    <x-lucide-icon name="upload" class="w-4.5 h-4.5" />
                                </div>
                                <span class="text-sm {{ $progress['steps']['documents'] === 'current' ? 'font-bold text-secondary-container' : ($progress['steps']['documents'] === 'completed' ? 'font-bold text-primary' : 'font-medium text-on-surface-variant') }}">Unggah Dokumen</span>
                            </div>
                            <div class="relative z-10 flex flex-col items-center gap-3">
                                <div class="w-10 h-10 rounded-full {{ $progress['steps']['submission'] === 'completed' ? 'bg-primary text-white shadow-md' : ($progress['steps']['submission'] === 'current' ? 'bg-secondary-container text-white shadow-md animate-pulse' : 'bg-surface-container-high text-on-surface-variant/40') }} flex items-center justify-center">
                                    <x-lucide-icon name="check" class="w-4.5 h-4.5" />
                                </div>
                                <span class="text-sm {{ $progress['steps']['submission'] === 'current' ? 'font-bold text-secondary-container' : ($progress['steps']['submission'] === 'completed' ? 'font-bold text-primary' : 'font-medium text-on-surface-variant') }}">Selesai</span>
                            </div>
                        </div>
                        @if (($progress['show_missing_steps'] ?? true) && $progress['missing_steps'])
                            <div class="mt-8 rounded-xl bg-slate-50 p-4">
                                <p class="text-xs font-black uppercase tracking-widest text-on-surface-variant">Yang perlu dilengkapi</p>
                                <ul class="mt-3 space-y-2">
                                    @foreach ($progress['missing_steps'] as $missingStep)
                                        <li class="flex items-center gap-2 text-sm font-semibold text-primary">
                                            <span class="h-2 w-2 rounded-full bg-secondary-container"></span>
                                            {{ $missingStep }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @elseif ($progress['dashboard_notice'] ?? null)
                            @php
                                $noticeTone = $progress['dashboard_notice']['tone'] ?? 'info';
                                $noticeClasses = [
                                    'info' => 'bg-amber-50 text-amber-800 border-amber-100',
                                    'success' => 'bg-green-50 text-green-800 border-green-100',
                                    'warning' => 'bg-amber-50 text-amber-800 border-amber-100',
                                    'danger' => 'bg-red-50 text-red-800 border-red-100',
                                ][$noticeTone] ?? 'bg-slate-50 text-primary border-slate-100';
                            @endphp
                            <div class="mt-8 rounded-xl border p-4 {{ $noticeClasses }}">
                                <p class="text-xs font-black uppercase tracking-widest">{{ $progress['dashboard_notice']['title'] }}</p>
                                <p class="mt-2 text-sm font-semibold leading-relaxed">{{ $progress['dashboard_notice']['message'] }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="space-y-6">
                        <div class="group rounded-2xl bg-surface-container-lowest p-6 shadow-subtle transition-all duration-300 hover:-translate-y-0.5 hover:bg-primary hover:shadow-lg">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-2 bg-primary/5 rounded-lg group-hover:bg-white/20">
                                    <x-lucide-icon name="calendar" class="w-4.5 h-4.5 text-primary group-hover:text-white" />
                                </div>
                                <span class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant group-hover:text-white/60">Tenggat Waktu</span>
                            </div>
                            <p class="text-xs text-on-surface-variant group-hover:text-white/80">Tanggal Pendaftaran</p>
                            <h4 class="text-xl font-headline font-extrabold text-primary group-hover:text-white mt-1">15 Juli 2024</h4>
                        </div>
                        <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-subtle">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-2 bg-secondary-container/5 rounded-lg">
                                    <x-lucide-icon name="shield-check" class="w-4.5 h-4.5 text-secondary-container" />
                                </div>
                                <span class="px-3 py-1 bg-secondary-container/10 text-secondary-container rounded-full text-[10px] font-bold uppercase">{{ $progress['status']['badge'] }}</span>
                            </div>
                            <p class="text-xs text-on-surface-variant">Status Verifikasi</p>
                            <h4 class="text-xl font-headline font-extrabold text-primary mt-1">{{ $progress['status']['label'] }}</h4>
                        </div>
                    </div>
                </div>

                <section class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach ([
                        ['label' => 'Tanya CS', 'icon' => 'headphones'],
                        ['label' => 'Panduan Tes', 'icon' => 'book-open'],
                        ['label' => 'Cek Tagihan', 'icon' => 'wallet'],
                        ['label' => 'Jadwal', 'icon' => 'calendar-days'],
                    ] as $action)
                        <button type="button" class="flex cursor-pointer flex-col items-center justify-center gap-3 rounded-xl border border-transparent bg-white p-6 text-center shadow-sm transition-all hover:-translate-y-0.5 hover:border-primary/20 hover:shadow-md active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary-container/70">
                            <div class="w-12 h-12 rounded-full bg-primary/5 flex items-center justify-center text-primary">
                                <x-lucide-icon :name="$action['icon']" class="w-5 h-5" />
                            </div>
                            <span class="text-xs font-bold text-primary uppercase tracking-wider">{{ $action['label'] }}</span>
                        </button>
                    @endforeach
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
