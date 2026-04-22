@extends('layouts.public')

@section('content')
    @php
        $studyPrograms = [
            ['id' => 1, 'slug' => 'teknik-informatika', 'title' => 'Teknik Informatika', 'description' => 'Pelajari pengembangan perangkat lunak, kecerdasan buatan, dan keamanan siber untuk memimpin era digital.', 'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=900&q=80', 'accreditation' => 'Akreditasi Unggul', 'badgeType' => 'primary'],
            ['id' => 2, 'slug' => 'kedokteran', 'title' => 'Kedokteran', 'description' => 'Pendidikan medis komprehensif dengan fasilitas klinis modern untuk mencetak dokter profesional dan beretika.', 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAPg13QipeVLP_zcwpBv-M02GZcUqyMhyb8u_ykDrKvcpmOeGQ3epSWlJkouxPX9YHmZJWXFNI7Jmw4cDhjomj5jxt9O5sP0uvqHGGKWCUddAQfapwJbXWoTd60XGG5gI09zBsOXLKD6r1TB89a5YlTyqy03r0MeiAIo5mWqeSmSKf7VAHajsvbJ7XagCAiqofzZ7tJk4JQV81KCTSsTa-OGUV3a7nWYGYoEvL2pOQYxqOwxtKqs0QSGtCc95_WyF_RAIlzLWhEGnM', 'accreditation' => 'Akreditasi Unggul', 'badgeType' => 'primary'],
            ['id' => 3, 'slug' => 'manajemen', 'title' => 'Manajemen', 'description' => 'Bentuk jiwa kepemimpinan dan kewirausahaan dengan kurikulum bisnis aplikatif standar global.', 'image' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=900&q=80', 'accreditation' => 'Akreditasi A', 'badgeType' => 'muted'],
            ['id' => 4, 'slug' => 'arsitektur', 'title' => 'Arsitektur', 'description' => 'Padukan seni dan teknik untuk merancang ruang dan bangunan inovatif yang berkelanjutan.', 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBKZiAjVyyc1uJX2xuQQ9CIlfjJqm8RjbVE3rZcAxRiT_hiO4QFma6XASK6605Pbw9P7r8mrExTM3ks--cHfIfBVK-YnYSlO9ROU7vqv0wemnL6pM8B_vGzR9gMMNN9Yr7o-KlZI9Qd9y6BSddN175qekTI9G1LfFatNh5lmXhY66iW1REaWKaOKFs7DimYycHOstrrtVQ5uvOleapKwixcc38SIm5gzQ3aC-RQfISJL6rAhUz_KF6vdVo7ys3hufrE4SIrcL60TsI', 'accreditation' => 'Akreditasi Unggul', 'badgeType' => 'primary'],
            ['id' => 5, 'slug' => 'psikologi', 'title' => 'Psikologi', 'description' => 'Pahami perilaku manusia dan proses mental untuk memberikan solusi aplikatif di berbagai bidang kehidupan.', 'image' => 'https://images.unsplash.com/photo-1604881991720-f91add269bed?auto=format&fit=crop&w=900&q=80', 'accreditation' => 'Akreditasi A', 'badgeType' => 'muted'],
            ['id' => 6, 'slug' => 'ilmu-komunikasi', 'title' => 'Ilmu Komunikasi', 'description' => 'Kuasai strategi media massa, public relations, dan jurnalistik di era informasi digital yang dinamis.', 'image' => 'https://images.unsplash.com/photo-1495020689067-958852a7765e?auto=format&fit=crop&w=900&q=80', 'accreditation' => 'Akreditasi A', 'badgeType' => 'muted'],
        ];
    @endphp

    <main class="min-h-screen bg-background pt-20">
        <section class="mx-auto max-w-7xl px-6 py-20">
            <div class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-primary to-[#1E3A5F] p-12 text-center shadow-2xl md:p-24">
                <div class="absolute -right-32 -top-32 h-80 w-80 rounded-full bg-secondary/20 blur-[80px]"></div>
                <div class="absolute -bottom-32 -left-32 h-80 w-80 rounded-full bg-blue-400/10 blur-[80px]"></div>
                <div class="relative z-10">
                    <h1 class="mb-8 text-5xl font-extrabold tracking-tight text-white md:text-7xl">Program Studi</h1>
                    <p class="mx-auto max-w-3xl text-lg leading-relaxed text-slate-300 md:text-xl">Temukan program studi yang sesuai dengan passion dan wujudkan masa depan cemerlang Anda bersama institusi pendidikan terkemuka.</p>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-6 pb-20">
            <div class="grid grid-cols-1 gap-10 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($studyPrograms as $program)
                    <article id="program-{{ $program['id'] }}" class="group flex flex-col overflow-hidden rounded-2xl bg-white shadow-[0_2px_12px_rgba(30,58,95,0.08)] transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_18px_38px_rgba(30,58,95,0.14)]">
                        <div class="relative h-52 overflow-hidden">
                            <img src="{{ $program['image'] }}" alt="{{ $program['title'] }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" referrerpolicy="no-referrer">
                            <div class="absolute right-4 top-4 rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-primary shadow-sm {{ $program['badgeType'] === 'primary' ? 'bg-secondary' : 'bg-slate-200' }}">{{ $program['accreditation'] }}</div>
                        </div>
                        <div class="flex flex-grow flex-col p-7">
                            <h3 class="mb-3 text-xl font-bold text-primary">{{ $program['title'] }}</h3>
                            <p class="mb-6 flex-grow text-sm leading-relaxed text-slate-500">{{ $program['description'] }}</p>
                            <a href="{{ route('program-studi.show', $program['slug']) }}" class="group/btn flex w-full items-center justify-center gap-2 rounded-xl bg-gray-100 py-3 font-semibold text-gray-700 transition-all duration-300 hover:bg-primary hover:text-white">
                                Lihat Detail
                                <i class="bi bi-arrow-right transition-transform group-hover/btn:translate-x-1"></i>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    </main>
@endsection
