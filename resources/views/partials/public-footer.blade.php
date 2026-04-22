<footer class="bg-primary px-6 py-16 text-white">
    <div class="mx-auto grid max-w-7xl grid-cols-1 gap-12 md:grid-cols-3">
        <div class="space-y-4">
            <h2 class="font-display text-2xl font-bold tracking-tighter">PMB Online</h2>
            <p class="max-w-sm text-sm leading-relaxed text-white/70">
                Portal Penerimaan Mahasiswa Baru Universitas. Kami membantu calon mahasiswa menemukan jalur akademik terbaik dengan proses yang mudah, transparan, dan profesional.
            </p>
        </div>

        <div class="space-y-4">
            <h3 class="font-display text-lg font-bold text-secondary">Tautan Cepat</h3>
            <ul class="space-y-3 text-sm">
                <li><a href="{{ route('home') }}" class="text-white/70 hover:text-secondary">Beranda</a></li>
                <li><a href="{{ route('program-studi.index') }}" class="text-white/70 hover:text-secondary">Program Studi</a></li>
                <li><a href="{{ route('informasi.index') }}" class="text-white/70 hover:text-secondary">Informasi</a></li>
                <li><a href="{{ route('kontak') }}" class="text-white/70 hover:text-secondary">Kontak</a></li>
            </ul>
        </div>

        <div class="space-y-4">
            <h3 class="font-display text-lg font-bold text-secondary">Bantuan</h3>
            <ul class="space-y-3 text-sm">
                <li><a href="{{ route('informasi.index') }}" class="text-white/70 hover:text-secondary">FAQ</a></li>
                <li><a href="{{ route('informasi.index') }}" class="text-white/70 hover:text-secondary">Kebijakan Privasi</a></li>
                <li><a href="{{ route('kontak') }}" class="text-white/70 hover:text-secondary">Hubungi Kami</a></li>
            </ul>
        </div>
    </div>

    <div class="mx-auto mt-12 max-w-7xl border-t border-white/10 pt-8 text-center text-xs text-white/50">
        © {{ date('Y') }} University New Student Admission System. All Rights Reserved.
    </div>
</footer>

