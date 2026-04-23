@extends('layouts.public')

@section('content')
    @php
        $contactItems = [
            [
                'icon' => 'bi bi-geo-alt-fill',
                'title' => 'Alamat Kampus Utama',
                'lines' => [
                    'Jl. Pendidikan No. 123, Kompleks Akademik',
                    'Kota Pelajar, 12345',
                    'Gedung Rektorat, Lantai 1',
                ],
            ],
            [
                'icon' => 'bi bi-telephone-fill',
                'title' => 'Telepon & WhatsApp',
                'lines' => [
                    '+62 811 2233 4455 (Hotline PMB)',
                    '(021) 555-0123 (Office)',
                ],
            ],
            [
                'icon' => 'bi bi-envelope-fill',
                'title' => 'Email',
                'lines' => [
                    'admisi@universitas.ac.id',
                    'info.pmb@universitas.ac.id',
                ],
            ],
            [
                'icon' => 'bi bi-clock-fill',
                'title' => 'Jam Operasional Layanan',
                'lines' => [
                    'Senin - Jumat: 08:00 - 16:00 WIB',
                    'Sabtu - Minggu: Tutup',
                ],
            ],
        ];
    @endphp

    <div class="min-h-screen bg-background">
<main class="pt-20">
            <section class="px-6 py-20">
                <div class="mx-auto max-w-[1400px]">
                    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-primary to-[#162a45] p-12 text-center shadow-[0_10px_30px_rgba(15,23,42,0.12)] md:p-20">
                        <div class="absolute right-0 top-0 -mr-20 -mt-20 h-80 w-80 rounded-full bg-white/5 blur-3xl"></div>
                        <div class="absolute bottom-0 left-0 -mb-16 -ml-16 h-64 w-64 rounded-full bg-secondary/5 blur-3xl"></div>
                        <div class="relative z-10 space-y-4">
                    <h1 class="font-display text-4xl font-bold tracking-tight text-white md:text-5xl">
                                Hubungi Kami
                            </h1>
                            <p class="mx-auto max-w-2xl text-lg font-medium leading-relaxed text-white/80 md:text-xl">
                                Tim Layanan Mahasiswa Baru siap membantu Anda dengan pertanyaan seputar pendaftaran, program studi, dan fasilitas kampus.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mx-auto max-w-[1400px] px-6 py-20">
                <div class="grid grid-cols-1 gap-12 lg:grid-cols-2">
                    <div class="rounded-3xl bg-white p-8 shadow-[0_10px_30px_rgba(15,23,42,0.06)] md:p-10">
                        <h2 class="mb-8 font-display text-2xl font-bold text-primary">Kirim Pesan (Demo)</h2>
                        <form action="{{ route('kontak') }}" method="GET" class="space-y-6" aria-label="Form kontak pratinjau">
                            <div>
                                <label for="nama_lengkap" class="mb-2 block text-sm font-semibold text-on-surface-variant">Nama Lengkap</label>
                                <input
                                    id="nama_lengkap"
                                    name="nama_lengkap"
                                    type="text"
                                    placeholder="Masukkan nama Anda"
                                    class="w-full rounded-xl border-none bg-surface-container-high px-5 py-4 outline-none transition-all focus:bg-white focus:ring-2 focus:ring-primary/20"
                                >
                            </div>

                            <div>
                                <label for="email" class="mb-2 block text-sm font-semibold text-on-surface-variant">Alamat Email</label>
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    placeholder="email@contoh.com"
                                    class="w-full rounded-xl border-none bg-surface-container-high px-5 py-4 outline-none transition-all focus:bg-white focus:ring-2 focus:ring-primary/20"
                                >
                            </div>

                            <div>
                                <label for="subjek" class="mb-2 block text-sm font-semibold text-on-surface-variant">Subjek</label>
                                <div class="relative">
                                    <select
                                        id="subjek"
                                        name="subjek"
                                        class="w-full cursor-pointer appearance-none rounded-xl border-none bg-surface-container-high px-5 py-4 outline-none transition-all focus:bg-white focus:ring-2 focus:ring-primary/20"
                                    >
                                        <option>Informasi Pendaftaran</option>
                                        <option>Program Studi</option>
                                        <option>Beasiswa</option>
                                        <option>Lainnya</option>
                                    </select>
                                    <div class="pointer-events-none absolute right-5 top-1/2 -translate-y-1/2 opacity-50">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="pesan" class="mb-2 block text-sm font-semibold text-on-surface-variant">Pesan</label>
                                <textarea
                                    id="pesan"
                                    name="pesan"
                                    rows="4"
                                    placeholder="Tuliskan pesan atau pertanyaan Anda di sini..."
                                    class="w-full resize-none rounded-xl border-none bg-surface-container-high px-5 py-4 outline-none transition-all focus:bg-white focus:ring-2 focus:ring-primary/20"
                                ></textarea>
                            </div>

                            <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-secondary py-4 text-lg font-bold text-white shadow-[0_10px_30px_rgba(15,23,42,0.12)] transition-all hover:opacity-90 active:scale-[0.98]">
                                Kirim Pesan (Demo)
                                <i class="bi bi-send-fill"></i>
                            </button>
                        </form>
                    </div>

                    <div class="space-y-10 rounded-3xl bg-surface-container-high p-8 md:p-12">
                        <h2 class="font-display text-2xl font-bold text-primary">Informasi Kontak</h2>
                        <div class="space-y-8">
                            @foreach ($contactItems as $item)
                                <div class="group flex items-start gap-5">
                                    <div class="rounded-xl bg-white p-3.5 text-secondary shadow-[0_10px_30px_rgba(15,23,42,0.06)] transition-transform duration-300 group-hover:scale-110">
                                        <i class="{{ $item['icon'] }} text-lg"></i>
                                    </div>
                                    <div>
                                        <h3 class="mb-1 font-bold text-primary">{{ $item['title'] }}</h3>
                                        <p class="text-sm leading-relaxed text-on-surface-variant">
                                            @foreach ($item['lines'] as $line)
                                                {{ $line }}@if (! $loop->last)<br>@endif
                                            @endforeach
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            <section class="mx-auto max-w-[1400px] px-6 py-20">
                <div class="relative h-[480px] overflow-hidden rounded-3xl shadow-[0_10px_30px_rgba(15,23,42,0.12)]">
                    <img
                        src="https://images.unsplash.com/photo-1526772662000-3f88f10405ff?auto=format&fit=crop&q=80&w=1200"
                        alt="Map Background"
                        class="h-full w-full object-cover"
                    >
                    <div class="absolute inset-0 bg-primary/20 mix-blend-multiply"></div>
                    <div class="absolute left-8 top-8 max-w-sm rounded-2xl bg-white/95 p-8 shadow-[0_10px_30px_rgba(15,23,42,0.12)] backdrop-blur-sm">
                        <h3 class="mb-3 font-display text-xl font-bold text-primary">Pusat Admisi</h3>
                        <p class="mb-6 text-sm leading-relaxed text-on-surface-variant">
                            Temukan kami di pusat kota pendidikan. Tersedia parkir luas untuk pengunjung.
                        </p>
                        <a href="https://www.google.com/maps/search/?api=1&query=Jl.+Pendidikan+No.+123+Jakarta+Selatan" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-sm font-bold text-secondary transition-opacity hover:opacity-80">
                            Buka di Google Maps
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                    </div>
                </div>
            </section>
        </main>
</div>
@endsection





