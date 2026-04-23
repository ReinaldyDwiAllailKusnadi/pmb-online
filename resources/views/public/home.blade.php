@extends('layouts.public')

@section('content')
    @php
        $features = [
            ['icon' => 'bi bi-patch-check-fill', 'title' => 'Akreditasi Unggul', 'description' => 'Seluruh program studi telah terakreditasi Unggul dan A, menjamin kualitas kurikulum dan lulusan.'],
            ['icon' => 'bi bi-mortarboard-fill', 'title' => 'Beasiswa Beragam', 'description' => 'Tersedia berbagai skema beasiswa mulai dari prestasi akademik, olahraga, hingga bantuan ekonomi.'],
            ['icon' => 'bi bi-building', 'title' => 'Fasilitas Modern', 'description' => 'Laboratorium canggih, perpustakaan digital, dan coworking space untuk mendukung kreativitas mahasiswa.'],
        ];
        $steps = ['Registrasi Akun', 'Isi Formulir', 'Unggah Dokumen', 'Verifikasi', 'Lulus'];
        $programs = [
            ['title' => 'Teknik Informatika', 'slug' => 'teknik-informatika', 'description' => 'Fokus pada AI, Cloud Computing, dan Rekayasa Perangkat Lunak.', 'accreditation' => 'UNGGUL', 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBYok0fuYEXwj-fKIajtuZq6XmlyHp3fSrX-HfDpTk9Sxb69XvhZzxdu_C4WBx2rVqk6uJksjRbn3HgpldrEyqx9uG_GCcC2_4BLYf6UVNbCofqcF6xaxhUrinhVTi5yNBetlVNiP_xQ7xy6sca6dVpnD41ZD6_c41fxmAvjC2_2cd9n4kAYAFGL9oE8m-TJ_Yl0v0PzgVfNs__L87GyzmkmT-ETa5gRoD2qwgP_PWj2-hIT7zjwLLhjwE_yWaKqMt7AqkuNmTo-JA'],
            ['title' => 'Kedokteran', 'slug' => 'kedokteran', 'description' => 'Pendidikan dokter berkualitas dengan fasilitas rumah sakit pendidikan modern.', 'accreditation' => 'UNGGUL', 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAPg13QipeVLP_zcwpBv-M02GZcUqyMhyb8u_ykDrKvcpmOeGQ3epSWlJkouxPX9YHmZJWXFNI7Jmw4cDhjomj5jxt9O5sP0uvqHGGKWCUddAQfapwJbXWoTd60XGG5gI09zBsOXLKD6r1TB89a5YlTyqy03r0MeiAIo5mWqeSmSKf7VAHajsvbJ7XagCAiqofzZ7tJk4JQV81KCTSsTa-OGUV3a7nWYGYoEvL2pOQYxqOwxtKqs0QSGtCc95_WyF_RAIlzLWhEGnM'],
            ['title' => 'Manajemen', 'slug' => 'manajemen', 'description' => 'Mempersiapkan entrepreneur dan manajer global di era digital ekonomi.', 'accreditation' => 'A', 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD6SK0UvZXY1F353jZNRKpqp8KQBrPrDyNRup27f1UClELKdF1Xul59slG6nfel-sa44PRd-vSLq3vMovOejt2FG74COzTzi9uAdxEFDx1uFIDAe_Xbr4DyO72y0CtwYCOE_y2hsTfwGwlanQFc29VuCn_bBxozYZjZXuYv_d2xZ_nsJisymjoKKjp-A4Q0K-6_shbKXjDfCUiFdSY_dCYzVnfDCfO3TBlLUzlez22JqazyxbILRx9dS0jjm50KBPBnd-ieXdEBlsA'],
            ['title' => 'Arsitektur', 'slug' => 'arsitektur', 'description' => 'Desain berkelanjutan dan perencanaan tata kota futuristik.', 'accreditation' => 'A', 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBKZiAjVyyc1uJX2xuQQ9CIlfjJqm8RjbVE3rZcAxRiT_hiO4QFma6XASK6605Pbw9P7r8mrExTM3ks--cHfIfBVK-YnYSlO9ROU7vqv0wemnL6pM8B_vGzR9gMMNN9Yr7o-KlZI9Qd9y6BSddN175qekTI9G1LfFatNh5lmXhY66iW1REaWKaOKFs7DimYycHOstrrtVQ5uvOleapKwixcc38SIm5gzQ3aC-RQfISJL6rAhUz_KF6vdVo7ys3hufrE4SIrcL60TsI'],
        ];
        $newsItems = [
            ['icon' => 'bi bi-calendar-event-fill', 'title' => 'Webinar Strategi Memilih Program Studi', 'info' => '15 April 2024 • Via Zoom Meeting'],
            ['icon' => 'bi bi-shield-check', 'title' => 'Panduan Pengisian Portal PMB 2024', 'info' => '10 April 2024 • Panduan PDF'],
            ['icon' => 'bi bi-megaphone-fill', 'title' => 'Open House Kampus Utama', 'info' => '20 April 2024 • Kampus Pusat'],
        ];
    @endphp

    <main class="min-h-screen bg-background pt-20">
        <section class="relative overflow-hidden bg-surface-container-low py-20">
            <div class="mx-auto grid max-w-[1400px] grid-cols-1 items-center gap-14 px-6 lg:grid-cols-2">
                <div class="relative z-10">
                    <span class="mb-6 inline-block rounded-full bg-secondary/10 px-4 py-1 text-sm font-bold tracking-wider text-secondary">PENERIMAAN MAHASISWA BARU 2024/2025</span>
                    <h1 class="mb-6 max-w-2xl font-display text-5xl font-extrabold leading-tight tracking-tight text-primary lg:text-6xl">Mulai Masa Depan Gemilang di Universitas Harapan Bangsa</h1>
                    <p class="mb-10 max-w-xl text-lg leading-relaxed text-on-surface-variant">Temukan program studi impian Anda dan bergabunglah dengan komunitas akademik unggul yang mencetak pemimpin masa depan kelas dunia.</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('register') }}" class="rounded-xl bg-primary px-8 py-4 font-bold text-white shadow-lg shadow-primary/20 transition-all hover:bg-[#1E3A5F] active:scale-95">Daftar Sekarang</a>
                        <span aria-disabled="true" class="flex cursor-not-allowed items-center gap-2 rounded-xl bg-gray-100 px-8 py-4 font-bold text-gray-400 opacity-70"><i class="bi bi-play-circle-fill text-xl"></i>Tur Kampus Segera Tersedia</span>
                    </div>
                </div>
                <div class="relative mx-auto max-w-2xl rotate-0 transition-transform duration-500 lg:ml-auto lg:rotate-2">
                    <div class="absolute -right-12 -top-12 h-72 w-72 rounded-full bg-secondary/10 blur-3xl"></div>
                    <div class="absolute -bottom-12 -left-12 h-72 w-72 rounded-full bg-primary/5 blur-3xl"></div>
                    <div class="relative overflow-hidden rounded-2xl shadow-2xl">
                        <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuA2CJHPa2x6fIMlfT_ACbQYDxGE_jUl2vvTBTkrdRpeEhEMdZ4elVb1RSUDL-6zLuL7CuMDiV9Uory9hz9u4PAYaPaUJNmPNotdk_zCwQH6Y7pDiVm8guzDKkqmCFWGf-_i4NmakbVYu40Md3bam_igBJiFfVLIzwlCIpdu64i9NsUsOJp8f5GR6u7eqT7whFJ774Zyz8og4I8VzSHA_wUVlDAlfcd4rt_a5DmKmohdy5V2rlnkVXlvqKwg8XJvIiycTpBalBSD81A" alt="University Campus" class="aspect-[4/3] h-full w-full object-cover" referrerpolicy="no-referrer">
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-surface-container-lowest py-20">
            <div class="mx-auto max-w-[1400px] px-6">
                <div class="mb-12 text-center"><h2 class="mb-4 font-display text-3xl font-extrabold tracking-tight text-primary">Mengapa Memilih Kami?</h2><div class="mx-auto h-1 w-24 rounded-full bg-secondary"></div></div>
                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    @foreach ($features as $feature)
                        <div class="group rounded-2xl bg-surface-container-low p-8 transition-all duration-500 hover:-translate-y-2 hover:bg-primary">
                            <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-xl bg-primary/10 transition-colors group-hover:bg-white/20"><i class="{{ $feature['icon'] }} text-2xl text-primary transition-colors group-hover:text-white"></i></div>
                            <h3 class="mb-3 font-display text-xl font-bold text-primary transition-colors group-hover:text-white">{{ $feature['title'] }}</h3>
                            <p class="leading-relaxed text-on-surface-variant transition-colors group-hover:text-white/80">{{ $feature['description'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="bg-surface-container-high py-20">
            <div class="mx-auto max-w-[1400px] px-6">
                <div class="mb-12 text-center"><h2 class="mb-4 font-display text-3xl font-extrabold text-primary">Langkah Pendaftaran</h2><p class="text-on-surface-variant">Proses pendaftaran yang mudah dan transparan sepenuhnya secara online.</p></div>
                <div class="flex flex-col items-start justify-between gap-6 md:flex-row md:items-center">
                    @foreach ($steps as $step)
                        <div class="flex flex-1 flex-col items-center text-center">
                            @php $stepClass = match($loop->iteration) { 1 => 'bg-primary text-white shadow-lg shadow-primary/20', 2 => 'bg-secondary text-white shadow-lg shadow-secondary/20', default => 'bg-surface-container-highest text-on-surface-variant' }; @endphp
                            <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full text-xl font-bold {{ $stepClass }}">{{ $loop->iteration }}</div>
                            <h4 class="font-bold text-primary">{{ $step }}</h4>
                        </div>
                        @if (! $loop->last)<div class="mb-8 hidden h-0.5 flex-1 bg-outline-variant opacity-30 md:block"></div>@endif
                    @endforeach
                </div>
            </div>
        </section>

        <section class="bg-surface-container-lowest py-20">
            <div class="mx-auto max-w-[1400px] px-6">
                <div class="mb-12 flex items-end justify-between gap-6"><div><h2 class="mb-2 font-display text-3xl font-extrabold text-primary">Program Studi Unggulan</h2><p class="text-on-surface-variant">Pilih disiplin ilmu yang sesuai dengan passion dan karir masa depan Anda.</p></div><a class="hidden font-bold text-secondary hover:underline md:block" href="{{ route('program-studi.index') }}">Lihat Semua Program</a></div>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($programs as $program)
                        <article class="overflow-hidden rounded-2xl border border-outline-variant/10 bg-white shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                            <img src="{{ $program['image'] }}" alt="{{ $program['title'] }}" class="h-48 w-full object-cover" referrerpolicy="no-referrer">
                            <div class="p-6"><h3 class="mb-2 font-display text-xl font-bold text-primary">{{ $program['title'] }}</h3><p class="mb-4 text-sm text-on-surface-variant">{{ $program['description'] }}</p><div class="flex items-center justify-between gap-4"><span class="inline-block rounded bg-primary/5 px-3 py-1 text-xs font-bold text-primary">AKREDITASI {{ $program['accreditation'] }}</span><a href="{{ route('program-studi.show', $program['slug']) }}" class="text-sm font-bold text-secondary hover:underline">Detail</a></div></div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="bg-surface-container-low py-20">
            <div class="mx-auto max-w-[1400px] px-6">
                <h2 class="mb-12 text-center font-display text-3xl font-extrabold text-primary">Berita & Pengumuman</h2>
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
                    <article class="flex flex-col overflow-hidden rounded-3xl border border-outline-variant/5 bg-white shadow-md md:flex-row lg:col-span-7">
                        <div class="md:w-1/2"><img src="https://lh3.googleusercontent.com/aida-public/AB6AXuDZugqqQTvN8yBzhBGmiSLC4jt5OYEkGCvl8OLWxNR4-LEI6IzQCFiSUNVVlSWHtPeLBTEvfTuh9LpfKysjKzurqkNCtS5BhrUMWXBNOmNWgADOK9O1nLzH30mVMjZj9zHBRgVGQJqiuKUbVMHvAI6OJw7jEU7jK-MfdY6gRHACsf6ITkRkJEgjuDX8JA9frcGV-w9tsQbNH2Tld9TYqCbV1eUu05qzhQkPLJyeKYd7q89sw8d4kHirXGdoFdA590dBWl3gscLADzo" alt="News main" class="h-full w-full object-cover" referrerpolicy="no-referrer"></div>
                        <div class="flex flex-col justify-center p-8 md:w-1/2"><span class="mb-2 text-xs font-bold uppercase tracking-widest text-secondary">PENGUMUMAN</span><h3 class="mb-4 font-display text-2xl font-bold text-primary">Penerimaan Jalur Prestasi Gelombang II Dibuka</h3><p class="mb-6 text-sm text-on-surface-variant">Dapatkan kesempatan potongan biaya pendidikan hingga 100% melalui jalur prestasi non-akademik.</p><a class="group flex items-center gap-2 text-sm font-extrabold text-primary" href="{{ route('informasi.index') }}">Baca Selengkapnya<i class="bi bi-arrow-right transition-transform group-hover:translate-x-1"></i></a></div>
                    </article>
                    <div class="flex flex-col gap-4 lg:col-span-5">
                        @foreach ($newsItems as $item)
                            <article class="flex items-center gap-4 rounded-2xl border border-outline-variant/5 bg-white p-6 shadow-sm transition-all duration-300 hover:translate-x-2"><div class="shrink-0 rounded-xl bg-primary/5 p-3 text-primary"><i class="{{ $item['icon'] }}"></i></div><div><h4 class="mb-1 font-display text-sm font-bold text-primary">{{ $item['title'] }}</h4><p class="text-xs text-on-surface-variant">{{ $item['info'] }}</p></div></article>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
