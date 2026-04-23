@extends('layouts.public')

@section('content')
    @php
        $programs = [
            'teknik-informatika' => [
                'faculty' => 'Fakultas Ilmu Komputer',
                'title' => 'Teknik Informatika',
                'description' => 'Program studi yang mempersiapkan lulusan untuk menjadi inovator di bidang teknologi informasi, dengan fokus pada pengembangan perangkat lunak, kecerdasan buatan, dan arsitektur sistem.',
                'heroImage' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDC_dxnc4-jj-UrfzViQ0igCCaliNQf0dJ7t_vOsbutY2oh69BkTDdYdLR5siaVkfGsUY4xhD971nm75z_Ssi84NKU1RqYAcxeY8R8mZWMRylK4S9YynGs4DXxUJI4sJ1_tYEatR1G2hmSh5B6jwa3fQo0ezkI9Va5OIYRQRS6d_FsDi8lfWlCAClnOSnYMMUD3r-3Vcdm8W-bt4RcvaP7Q9CADTIMJp3IX7yTbYZ5Frl9vP4p5toXudPbidKNZN5kDdcDul7ketk0',
                'heroLabel' => 'IoT & AI Innovation Center',
                'degree' => 'S.Kom',
                'duration' => '8 Semester',
                'accreditation' => 'Unggul (A)',
                'about' => 'Teknik Informatika menggabungkan landasan teoritis komputasi dengan pendekatan praktis untuk merancang dan membangun sistem perangkat lunak yang kompleks. Kurikulum kami dirancang adaptif terhadap perkembangan teknologi global.',
                'vision' => 'Menjadi pusat unggulan pendidikan dan penelitian di bidang Teknik Informatika tingkat Asia Tenggara pada tahun 2030.',
                'missions' => ['Menyelenggarakan pendidikan berkualitas standar internasional.', 'Mengembangkan riset inovatif berbasis AI dan Cloud Computing.'],
            ],
            'kedokteran' => [
                'faculty' => 'Fakultas Kedokteran',
                'title' => 'Kedokteran',
                'description' => 'Program studi kedokteran yang menyiapkan calon dokter profesional, humanis, dan adaptif terhadap perkembangan ilmu kesehatan modern.',
                'heroImage' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAPg13QipeVLP_zcwpBv-M02GZcUqyMhyb8u_ykDrKvcpmOeGQ3epSWlJkouxPX9YHmZJWXFNI7Jmw4cDhjomj5jxt9O5sP0uvqHGGKWCUddAQfapwJbXWoTd60XGG5gI09zBsOXLKD6r1TB89a5YlTyqy03r0MeiAIo5mWqeSmSKf7VAHajsvbJ7XagCAiqofzZ7tJk4JQV81KCTSsTa-OGUV3a7nWYGYoEvL2pOQYxqOwxtKqs0QSGtCc95_WyF_RAIlzLWhEGnM',
                'heroLabel' => 'Clinical Simulation Center',
                'degree' => 'S.Ked',
                'duration' => '8 Semester',
                'accreditation' => 'Unggul (A)',
                'about' => 'Kedokteran memadukan pembelajaran biomedis, keterampilan klinis, dan etika profesi melalui fasilitas laboratorium serta simulasi klinik modern.',
                'vision' => 'Menjadi program studi kedokteran unggul yang menghasilkan dokter berintegritas dan berorientasi pada pelayanan masyarakat.',
                'missions' => ['Menyelenggarakan pendidikan kedokteran berbasis kompetensi.', 'Mengembangkan riset kesehatan yang relevan dengan kebutuhan masyarakat.'],
            ],
            'manajemen' => [
                'faculty' => 'Fakultas Ekonomi dan Bisnis',
                'title' => 'Manajemen',
                'description' => 'Program studi yang membentuk pemimpin bisnis, entrepreneur, dan manajer profesional dengan kemampuan analitis serta adaptasi digital.',
                'heroImage' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=1200&q=80',
                'heroLabel' => 'Business Innovation Hub',
                'degree' => 'S.M',
                'duration' => '8 Semester',
                'accreditation' => 'A',
                'about' => 'Manajemen mengembangkan kemampuan strategi, pemasaran, keuangan, operasional, dan kewirausahaan dengan pendekatan studi kasus dan praktik industri.',
                'vision' => 'Menjadi program studi manajemen yang unggul dalam pengembangan kepemimpinan bisnis dan kewirausahaan digital.',
                'missions' => ['Menyelenggarakan pendidikan bisnis aplikatif dan beretika.', 'Mendorong inovasi kewirausahaan berbasis teknologi.'],
            ],
            'arsitektur' => [
                'faculty' => 'Fakultas Teknik',
                'title' => 'Arsitektur',
                'description' => 'Program studi yang memadukan seni, teknologi, dan keberlanjutan untuk merancang ruang hidup dan lingkungan binaan masa depan.',
                'heroImage' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBKZiAjVyyc1uJX2xuQQ9CIlfjJqm8RjbVE3rZcAxRiT_hiO4QFma6XASK6605Pbw9P7r8mrExTM3ks--cHfIfBVK-YnYSlO9ROU7vqv0wemnL6pM8B_vGzR9gMMNN9Yr7o-KlZI9Qd9y6BSddN175qekTI9G1LfFatNh5lmXhY66iW1REaWKaOKFs7DimYycHOstrrtVQ5uvOleapKwixcc38SIm5gzQ3aC-RQfISJL6rAhUz_KF6vdVo7ys3hufrE4SIrcL60TsI',
                'heroLabel' => 'Sustainable Design Studio',
                'degree' => 'S.Ars',
                'duration' => '8 Semester',
                'accreditation' => 'Unggul (A)',
                'about' => 'Arsitektur mengajarkan perancangan bangunan, tata ruang, visualisasi desain, dan pendekatan lingkungan berkelanjutan.',
                'vision' => 'Menjadi pusat pendidikan arsitektur yang unggul dalam desain inovatif dan berkelanjutan.',
                'missions' => ['Menyelenggarakan studio desain berbasis problem nyata.', 'Mengembangkan riset arsitektur tropis dan kota berkelanjutan.'],
            ],
            'psikologi' => [
                'faculty' => 'Fakultas Psikologi',
                'title' => 'Psikologi',
                'description' => 'Program studi yang mempelajari perilaku manusia dan proses mental untuk mendukung pengembangan individu, organisasi, dan masyarakat.',
                'heroImage' => 'https://images.unsplash.com/photo-1604881991720-f91add269bed?auto=format&fit=crop&w=1200&q=80',
                'heroLabel' => 'Human Development Center',
                'degree' => 'S.Psi',
                'duration' => '8 Semester',
                'accreditation' => 'A',
                'about' => 'Psikologi membekali mahasiswa dengan dasar asesmen, konseling, psikologi perkembangan, industri-organisasi, dan riset perilaku.',
                'vision' => 'Menjadi program studi psikologi yang unggul dalam pengembangan manusia dan kesejahteraan psikologis.',
                'missions' => ['Menyelenggarakan pendidikan psikologi berbasis sains dan empati.', 'Mengembangkan layanan serta riset psikologi terapan.'],
            ],
            'ilmu-komunikasi' => [
                'faculty' => 'Fakultas Ilmu Sosial dan Komunikasi',
                'title' => 'Ilmu Komunikasi',
                'description' => 'Program studi yang menyiapkan praktisi komunikasi strategis, media digital, public relations, dan jurnalistik modern.',
                'heroImage' => 'https://images.unsplash.com/photo-1495020689067-958852a7765e?auto=format&fit=crop&w=1200&q=80',
                'heroLabel' => 'Digital Media Studio',
                'degree' => 'S.I.Kom',
                'duration' => '8 Semester',
                'accreditation' => 'A',
                'about' => 'Ilmu Komunikasi memadukan teori komunikasi, produksi konten, riset media, strategi kampanye, dan komunikasi korporat.',
                'vision' => 'Menjadi program studi komunikasi unggul yang adaptif terhadap ekosistem media digital.',
                'missions' => ['Menyelenggarakan pendidikan komunikasi kreatif dan strategis.', 'Mengembangkan praktik media yang etis dan berdampak.'],
            ],
        ];
        $program = $programs[$slug ?? 'teknik-informatika'] ?? null;
        abort_unless($program, 404);
        $infoRows = [
            ['label' => 'Gelar Akademik', 'value' => $program['degree'], 'highlight' => false],
            ['label' => 'Masa Studi', 'value' => $program['duration'], 'highlight' => false],
            ['label' => 'Akreditasi', 'value' => $program['accreditation'], 'highlight' => true],
        ];

        $careers = [
            [
                'icon' => 'bi bi-code-slash',
                'title' => 'Software Engineer',
                'description' => 'Merancang, mengembangkan, dan memelihara aplikasi skala besar untuk berbagai platform.',
                'color' => 'bg-blue-50 text-primary',
            ],
            [
                'icon' => 'bi bi-bar-chart-fill',
                'title' => 'Data Scientist',
                'description' => 'Menganalisis big data untuk menghasilkan insight bisnis menggunakan algoritma machine learning.',
                'color' => 'bg-orange-50 text-slate-800',
            ],
            [
                'icon' => 'bi bi-cloud-fill',
                'title' => 'Cloud Architect',
                'description' => 'Mendesain arsitektur infrastruktur IT berbasis cloud untuk performa tinggi dan keamanan.',
                'color' => 'bg-yellow-50 text-orange-600',
            ],
        ];

        $facilities = [
            [
                'title' => 'Cyber Security Lab',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBpSbagK6tnCriuLxadetwn87O5QUfEYCxFbN7-u7TVRyAv7qpYT5s6C4kSW8BH1PXwUvO_tQxyJTtfFaiFgWD-ffBY6NJ2X7IKcZ_S-xRPAEdCJNc1cXVFhGbAFSCp_SEEkY0Yb4JZ1FXTV_weJd3ZAOA8pU2jxpEo9GX8iFo9dDDoMD4DUCak67oMogS1Zr419exf5k5Ic5S00BHLgYUDqKHMcQnLWyz53fmqMWwkvx2iGFosj68cDoiWMG-_FKn4LAu2YG49l84',
            ],
            [
                'title' => 'IoT Research Center',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDWBbvXHPrJwjneawCB4hudDadXil-ysMoBAzxe60zG77Fm6hkZnJHU0Cxo4VtNC1jVDoAaRsjMcZdXLa5TxvMm1ELkZRtGpqG22VC3u1hWgn6ZgVyw_0MQZGuykx8Cf6KZIIdDIPmjVl7vKzLAtMa2uCkCng5-WmpjFdMvEwd00xuw4DTVYtN9AjZU6PQpO-R25OzFmnP5BgGSEBW9Csicy8Eut88lMQIDxH-L4Zagg81m1qlbfkBN3XiUKykc4BoOt9euuvuVUEo',
            ],
        ];
    @endphp

    <div class="flex min-h-screen flex-col bg-background">
        <main class="flex-1 py-20">
            <div class="mx-auto flex max-w-[1400px] flex-col gap-12 px-6 lg:flex-row">
                <div class="flex w-full flex-col gap-12 lg:w-2/3">
                    <header class="flex flex-col gap-6">
                        <div>
                            <span class="rounded-full bg-slate-100 px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-primary">
                                {{ $program['faculty'] }}
                            </span>
                        </div>
                        <h1 class="text-4xl font-bold leading-tight text-primary md:text-5xl">
                            {{ $program['title'] }}
                        </h1>
                        <p class="max-w-2xl text-lg leading-relaxed text-slate-600">
                            {{ $program['description'] }}
                        </p>
                    </header>

                    <div class="group relative aspect-video overflow-hidden rounded-2xl shadow-xl">
                        <img
                            src="{{ $program['heroImage'] }}"
                            alt="{{ $program['title'] }}"
                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                            referrerpolicy="no-referrer"
                        >
                        <div class="absolute inset-0 flex items-end bg-gradient-to-t from-primary/90 via-transparent to-transparent p-8">
                            <span class="text-lg font-medium tracking-wide text-white">{{ $program['heroLabel'] }}</span>
                        </div>
                    </div>

                    <section class="flex flex-col gap-6">
                        <h2 class="text-3xl font-bold text-primary">Tentang Program Studi</h2>
                        <div class="rounded-2xl border border-slate-100 bg-white p-8 leading-relaxed text-slate-600 shadow-sm">
                            <p class="mb-8">
                                {{ $program['about'] }}
                            </p>
                    <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                                <div class="flex flex-col gap-3">
                                    <h3 class="flex items-center gap-2 text-xl font-bold text-primary">
                                        <span class="rounded-lg bg-yellow-50 p-1.5">
                                            <i class="bi bi-eye-fill text-secondary"></i>
                                        </span>
                                        Visi
                                    </h3>
                                    <p class="text-sm">
                                        {{ $program['vision'] }}
                                    </p>
                                </div>
                                <div class="flex flex-col gap-3">
                                    <h3 class="flex items-center gap-2 text-xl font-bold text-primary">
                                        <span class="rounded-lg bg-yellow-50 p-1.5">
                                            <i class="bi bi-flag-fill text-secondary"></i>
                                        </span>
                                        Misi
                                    </h3>
                                    <ul class="list-inside list-disc space-y-2 text-sm">
                                        @foreach ($program['missions'] as $mission)
                                            <li>{{ $mission }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="flex flex-col gap-6">
                        <h2 class="text-3xl font-bold text-primary">Prospek Karir</h2>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($careers as $career)
                                <article class="flex flex-col gap-4 rounded-xl border border-slate-100 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-xl {{ $career['color'] }}">
                                        <i class="{{ $career['icon'] }} text-xl"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-primary">{{ $career['title'] }}</h3>
                                    <p class="text-sm leading-relaxed text-slate-500">{{ $career['description'] }}</p>
                                </article>
                            @endforeach
                        </div>
                    </section>

                    <section class="flex flex-col gap-6">
                        <h2 class="text-3xl font-bold text-primary">Fasilitas Unggulan</h2>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            @foreach ($facilities as $facility)
                                <article class="group relative h-56 overflow-hidden rounded-2xl shadow-lg">
                                    <img
                                        src="{{ $facility['image'] }}"
                                        alt="{{ $facility['title'] }}"
                                        class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                                        referrerpolicy="no-referrer"
                                    >
                                    <div class="absolute inset-0 flex flex-col justify-end bg-gradient-to-t from-primary/90 via-primary/30 to-transparent p-6">
                                        <h3 class="mb-1 text-xl font-bold text-white">{{ $facility['title'] }}</h3>
                                        <p class="translate-y-4 text-xs text-white/60 opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                                            Fasilitas riset dan pengembangan standar industri.
                                        </p>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>
                </div>

                <aside class="flex w-full flex-col gap-6 lg:w-1/3">
                    <div class="sticky top-28 flex flex-col gap-6">
                        <section class="relative flex flex-col gap-6 overflow-hidden rounded-2xl border border-slate-100 bg-white p-8 shadow-xl">
                            <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-secondary opacity-5 blur-3xl"></div>
                            <h3 class="text-2xl font-bold text-primary">Informasi Pendaftaran</h3>

                            <div class="flex flex-col gap-4">
                                @foreach ($infoRows as $row)
                                    <div class="flex items-center justify-between border-b border-slate-50 py-3">
                                        <span class="text-sm font-medium text-slate-500">{{ $row['label'] }}</span>
                                        <span class="font-bold {{ $row['highlight'] ? 'text-secondary' : 'text-primary' }}">{{ $row['value'] }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-4 flex flex-col gap-3">
                                <a href="{{ route('register') }}" class="flex w-full items-center justify-center gap-2 rounded-xl bg-primary py-3.5 font-bold text-white shadow-lg shadow-primary/20 transition-all hover:bg-[#1E3A5F] active:scale-95">
                                    <i class="bi bi-file-earmark-text-fill"></i>
                                    Daftar Sekarang
                                </a>
                                <span aria-disabled="true" class="flex w-full cursor-not-allowed items-center justify-center gap-2 rounded-xl bg-gray-100 py-3.5 font-bold text-gray-400">
                                    <i class="bi bi-download"></i>
                                    Brosur Segera Tersedia
                                </span>
                            </div>
                        </section>

                        <section class="flex items-start gap-4 rounded-2xl border border-slate-200/50 bg-slate-50 p-6">
                            <div class="rounded-full bg-white p-3 shadow-sm">
                                <i class="bi bi-headset text-xl text-primary"></i>
                            </div>
                            <div>
                                <h4 class="mb-1 font-bold text-primary">Butuh Bantuan?</h4>
                                <p class="mb-3 text-xs leading-relaxed text-slate-500">Tim admisi kami siap membantu menjawab pertanyaan Anda.</p>
                                <a href="{{ route('kontak') }}" class="group flex items-center gap-1 text-sm font-bold text-secondary">
                                    Hubungi Admin
                                    <i class="bi bi-arrow-right transition-transform group-hover:translate-x-1"></i>
                                </a>
                            </div>
                        </section>
                    </div>
                </aside>
            </div>
        </main>
</div>
@endsection





