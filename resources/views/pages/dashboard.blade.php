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
                        <a href="{{ route('form.step1') }}" class="mt-8 inline-flex px-8 py-3 bg-secondary-container text-white rounded-xl font-bold shadow-lg shadow-secondary-container/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
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
                            <span class="text-sm font-medium text-on-surface-variant">25% Selesai</span>
                        </div>
                        <div class="flex items-center justify-between relative px-2">
                            <div class="absolute top-5 left-10 right-10 h-1 bg-surface-container-high z-0">
                                <div class="h-full bg-primary w-1/2 rounded-full"></div>
                            </div>
                            <div class="relative z-10 flex flex-col items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center shadow-md">
                                    <x-lucide-icon name="check" class="w-4.5 h-4.5" />
                                </div>
                                <span class="text-sm font-bold text-primary">Data Pribadi</span>
                            </div>
                            <div class="relative z-10 flex flex-col items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-secondary-container text-white flex items-center justify-center shadow-md animate-pulse">
                                    <x-lucide-icon name="upload" class="w-4.5 h-4.5" />
                                </div>
                                <span class="text-sm font-bold text-secondary-container">Unggah Dokumen</span>
                            </div>
                            <div class="relative z-10 flex flex-col items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-surface-container-high text-on-surface-variant/40 flex items-center justify-center">
                                    <x-lucide-icon name="check" class="w-4.5 h-4.5" />
                                </div>
                                <span class="text-sm font-medium text-on-surface-variant">Selesai</span>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-subtle group hover:bg-primary transition-all duration-300">
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
                                <span class="px-3 py-1 bg-secondary-container/10 text-secondary-container rounded-full text-[10px] font-bold uppercase">Pending</span>
                            </div>
                            <p class="text-xs text-on-surface-variant">Status Verifikasi</p>
                            <h4 class="text-xl font-headline font-extrabold text-primary mt-1">Menunggu Review</h4>
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
                        <button class="bg-white p-6 rounded-xl shadow-sm flex flex-col items-center justify-center text-center gap-3 border border-transparent hover:border-primary/20 hover:shadow-md hover:-translate-y-0.5 transition-all">
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