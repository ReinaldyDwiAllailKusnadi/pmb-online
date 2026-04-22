@extends('layouts.public')

@section('content')
    @php
        $registrationPaths = [
            [
                'icon' => 'bi bi-award-fill',
                'title' => 'Jalur Prestasi',
                'description' => 'Diperuntukkan bagi calon mahasiswa yang memiliki prestasi akademik atau non-akademik tingkat nasional maupun internasional.',
                'button' => 'Detail Jalur Prestasi Segera Tersedia',
                'color' => 'bg-secondary/10 text-secondary',
            ],
            [
                'icon' => 'bi bi-file-earmark-richtext-fill',
                'title' => 'Jalur Mandiri',
                'description' => 'Jalur seleksi melalui ujian tertulis (CBT) yang diselenggarakan secara mandiri oleh pihak Universitas.',
                'button' => 'Detail Jalur Mandiri Segera Tersedia',
                'color' => 'bg-primary/10 text-primary',
            ],
        ];

        $waves = [
            [
                'number' => 1,
                'title' => 'Gelombang 1',
                'registration' => '1 Feb - 31 Mar 2024',
                'exam' => '15 April 2024',
                'active' => true,
            ],
            [
                'number' => 2,
                'title' => 'Gelombang 2',
                'registration' => '1 Mei - 30 Jun 2024',
                'exam' => '15 Juli 2024',
                'active' => false,
            ],
            [
                'number' => 3,
                'title' => 'Gelombang 3',
                'registration' => '1 Jul - 31 Ags 2024',
                'exam' => '10 September 2024',
                'active' => false,
            ],
        ];

        $requirements = [
            'Lulusan SMA/SMK/MA sederajat tahun 2022, 2023, 2024.',
            'Fotokopi Ijazah/SKL yang dilegalisir.',
            'Fotokopi Kartu Keluarga (KK) dan KTP/Kartu Pelajar.',
            'Pas foto berwarna terbaru ukuran 4x6.',
        ];

        $tuitionCards = [
            ['title' => 'Fakultas Teknik', 'price' => 'Rp 8.500.000'],
            ['title' => 'Fakultas Kedokteran', 'price' => 'Rp 25.000.000'],
            ['title' => 'Fakultas Ekonomi', 'price' => 'Rp 7.000.000'],
        ];
    @endphp

    <div class="flex min-h-screen flex-col bg-background antialiased">
<main class="mx-auto w-full max-w-7xl space-y-20 px-6 py-20">
            <section class="relative flex overflow-hidden rounded-2xl bg-primary px-8 py-20 text-white shadow-2xl">
                <div class="z-10 max-w-2xl space-y-6">
                    <h1 class="font-display text-4xl font-bold leading-tight tracking-tight md:text-5xl lg:text-6xl">
                        Informasi Pendaftaran Mahasiswa Baru
                    </h1>
                    <p class="max-w-xl text-lg text-blue-100 md:text-xl">
                        Langkah pertama menuju masa depan yang gemilang. Temukan semua informasi yang Anda butuhkan untuk bergabung dengan universitas kami.
                    </p>
                </div>
                <div class="pointer-events-none absolute inset-0 opacity-30">
                    <img
                        id="hero-bg-img"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuC-dEuFzBd5ze-8D4H0ZL3_a5CNHIgZ7IFC2jTXvVb_DFdO75W_JiiG_5V6g0V3YKMSjyVoc7FtP6givSutOnuO7WP0-3wi0mYansI5ml7oeUOOmWoJ9k_mWMXr2SjJd5hlFQyWuup76n2sN1sIDsmsBoshYquF2yegAoAIT-QEcvob2ylBTwLVcJ3p4AUTU8emRnatz9T_6RTkGP5JQqK3xYxAEo5G2oh4kI8U6dYDWej38YlilkPi8ziX5LLUKmDBgzbnAQAzsHE"
                        alt="University Campus"
                        class="h-full w-full object-cover"
                        referrerpolicy="no-referrer"
                    >
                </div>
            </section>

            <section class="space-y-12">
                <div class="space-y-3 text-center">
                    <h2 class="font-display text-3xl font-bold text-primary md:text-4xl">Jalur Pendaftaran</h2>
                    <p class="mx-auto max-w-2xl text-slate-500">Pilih jalur pendaftaran yang sesuai dengan kualifikasi Anda untuk memulai perjalanan akademik Anda.</p>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                    @foreach ($registrationPaths as $path)
                        <article class="group flex h-full flex-col rounded-2xl border border-slate-100 bg-white p-8 shadow-[0_2px_12px_rgba(30,58,95,0.08)] transition-all duration-300 hover:-translate-y-1">
                            <div class="mb-6 flex items-center space-x-4">
                                <div class="flex h-14 w-14 items-center justify-center rounded-2xl {{ $path['color'] }} transition-transform group-hover:scale-110">
                                    <i class="{{ $path['icon'] }} text-2xl"></i>
                                </div>
                                <h3 class="font-display text-2xl font-bold text-primary">{{ $path['title'] }}</h3>
                            </div>
                            <p class="mb-8 flex-grow leading-relaxed text-slate-600">
                                {{ $path['description'] }}
                            </p>
                            <span aria-disabled="true" class="mt-auto w-full cursor-not-allowed rounded-xl border-2 border-slate-200 bg-gray-100 py-3.5 text-center font-semibold text-gray-400">
                                {{ $path['button'] }}
                            </span>
                        </article>
                    @endforeach
                </div>
            </section>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                <section class="rounded-2xl border border-slate-100 bg-white p-8 shadow-[0_2px_12px_rgba(30,58,95,0.08)] lg:col-span-2">
                    <div class="mb-10 flex items-center space-x-4">
                        <div class="rounded-lg bg-secondary/10 p-2 text-secondary">
                            <i class="bi bi-calendar-event-fill text-2xl"></i>
                        </div>
                        <h2 class="font-display text-2xl font-bold text-primary">Jadwal Seleksi 2024</h2>
                    </div>

                    <div class="relative space-y-8 before:absolute before:bottom-2 before:left-[19px] before:top-2 before:w-0.5 before:bg-slate-100">
                        @foreach ($waves as $wave)
                            <div class="group relative flex items-start gap-6">
                                <div class="relative z-10 flex h-10 w-10 items-center justify-center rounded-full font-bold ring-4 ring-white {{ $wave['active'] ? 'bg-secondary text-white shadow-lg' : 'bg-slate-200 text-slate-500' }}">
                                    {{ $wave['number'] }}
                                </div>
                                <div class="flex-grow rounded-2xl p-6 transition-all {{ $wave['active'] ? 'border border-slate-100 bg-slate-50 hover:shadow-md' : 'border border-dashed border-slate-200 opacity-70' }}">
                                    <h3 class="mb-2 font-display text-xl font-bold text-primary">{{ $wave['title'] }}</h3>
                                    <div class="space-y-1 text-slate-600">
                                        @if ($wave['active'])
                                            <p><span class="font-semibold text-secondary">Pendaftaran:</span> {{ $wave['registration'] }}</p>
                                            <p><span class="font-semibold text-secondary">Ujian:</span> {{ $wave['exam'] }}</p>
                                        @else
                                            <p>Pendaftaran: {{ $wave['registration'] }}</p>
                                            <p>Ujian: {{ $wave['exam'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section class="flex flex-col rounded-2xl border border-slate-100 bg-white p-8 shadow-[0_2px_12px_rgba(30,58,95,0.08)]">
                    <div class="mb-8 flex items-center space-x-4">
                        <div class="rounded-lg bg-primary/10 p-2 text-primary">
                            <i class="bi bi-grid-3x3-gap-fill text-2xl"></i>
                        </div>
                        <h2 class="font-display text-2xl font-bold text-primary">Syarat & Ketentuan</h2>
                    </div>

                    <ul class="mb-10 flex-grow space-y-5 text-slate-600">
                        @foreach ($requirements as $requirement)
                            <li class="group flex items-start space-x-3">
                                <i class="bi bi-check-circle-fill mt-1 shrink-0 text-secondary transition-transform group-hover:scale-110"></i>
                                <span class="leading-tight">{{ $requirement }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <a href="{{ route('informasi.index') }}" class="group flex w-full items-center justify-center space-x-2 border-t border-slate-50 pt-6 font-semibold text-primary transition-colors hover:text-secondary">
                        <span>Lihat Selengkapnya</span>
                        <i class="bi bi-chevron-right transition-transform group-hover:translate-x-1"></i>
                    </a>
                </section>
            </div>

            <section class="relative overflow-hidden rounded-3xl bg-primary p-8 text-white shadow-2xl md:p-16">
                <div class="relative z-10">
                    <div class="mx-auto mb-16 max-w-3xl space-y-6 text-center">
                        <h2 class="font-display text-4xl font-bold">Informasi Biaya Kuliah</h2>
                        <p class="text-lg text-blue-100">
                            Transparansi biaya pendidikan adalah komitmen kami. Estimasi biaya per semester untuk tahun ajaran 2024/2025 di setiap fakultas unggulan.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                        @foreach ($tuitionCards as $tuition)
                            <article class="flex flex-col justify-center rounded-2xl border border-white/20 bg-white/10 p-8 text-center shadow-lg backdrop-blur-sm transition-transform duration-300 hover:scale-[1.02]">
                                <h4 class="mb-4 font-display text-lg font-semibold text-blue-200">{{ $tuition['title'] }}</h4>
                                <p class="mb-2 font-display text-3xl font-bold text-secondary">{{ $tuition['price'] }}</p>
                                <p class="text-sm text-blue-200">/ Semester</p>
                            </article>
                        @endforeach
                    </div>

                    <div class="mt-16 text-center">
                        <span aria-disabled="true" class="mx-auto flex w-fit cursor-not-allowed items-center gap-3 rounded-xl bg-white/10 px-10 py-4 font-bold text-white/60 shadow-xl">
                            <i class="bi bi-file-earmark-text-fill"></i>
                            Rincian PDF Segera Tersedia
                        </span>
                    </div>
                </div>

                <div class="pointer-events-none absolute left-0 top-0 h-full w-full overflow-hidden opacity-10">
                    <div class="absolute -right-10 -top-10 h-64 w-64 rounded-full bg-white blur-3xl"></div>
                    <div class="absolute -bottom-10 -left-10 h-96 w-96 rounded-full bg-secondary blur-3xl"></div>
                </div>
            </section>
        </main>
</div>
@endsection




