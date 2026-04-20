<x-app-layout title="Unggah Dokumen">
    <div class="flex min-h-screen bg-background font-body text-primary">
    @include('partials.sidebar', ['activePage' => 'formulir'])

        <main class="flex-1 ml-65 relative">
            @include('partials.topbar', [
                'pageLabel' => 'Unggah Dokumen',
                'userName' => $applicant->full_name,
                'userRole' => 'Calon Mahasiswa',
                'userAvatar' => 'https://ui-avatars.com/api/?name=' . urlencode($applicant->full_name),
            ])

            <div class="max-w-5xl mx-auto p-10 pb-24">
                <div class="flex items-center justify-between mb-12 relative px-4">
                    <div class="absolute top-1/2 left-0 w-full h-0.5 bg-surface-container-high -translate-y-1/2 -z-10"></div>
                    <div class="flex flex-col items-center gap-3 bg-background px-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-extrabold text-sm bg-secondary text-white shadow-lg shadow-secondary/30">1</div>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Data Pribadi</span>
                    </div>
                    <div class="flex flex-col items-center gap-3 bg-background px-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-extrabold text-sm bg-secondary text-white shadow-lg shadow-secondary/30">2</div>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-primary">Unggah Dokumen</span>
                    </div>
                    <div class="flex flex-col items-center gap-3 bg-background px-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-extrabold text-sm bg-outline-variant/40 text-on-surface-variant">3</div>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Konfirmasi</span>
                    </div>
                </div>

                <div class="bg-surface-container-lowest rounded-2xl shadow-editorial overflow-hidden">
                    <div class="p-8 lg:p-10">
                        <div class="mb-10 inline-block">
                            <h2 class="text-2xl font-headline font-bold tracking-tight">Unggah Dokumen</h2>
                            <div class="h-1 w-1/2 bg-primary mt-1 rounded-full"></div>
                        </div>

                        @if ($errors->any())
                            <div class="mb-6 p-4 rounded-lg bg-error/10 text-error text-sm font-semibold">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form id="form-step2" class="space-y-8" method="POST" action="{{ route('form.step2.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @php
                                    $documents = [
                                        [
                                            'label' => 'Pas Foto Formal',
                                            'name' => 'photo',
                                            'accept' => 'image/*',
                                            'current' => $applicant->photo_path,
                                            'note' => 'Format JPG/PNG, maksimal 2 MB',
                                        ],
                                        [
                                            'label' => 'KTP / Identitas',
                                            'name' => 'id_card',
                                            'accept' => 'image/*,.pdf',
                                            'current' => $applicant->id_card_path,
                                            'note' => 'Format JPG/PNG/PDF, maksimal 4 MB',
                                        ],
                                        [
                                            'label' => 'Kartu Keluarga',
                                            'name' => 'family_card',
                                            'accept' => 'image/*,.pdf',
                                            'current' => $applicant->family_card_path,
                                            'note' => 'Format JPG/PNG/PDF, maksimal 4 MB',
                                        ],
                                        [
                                            'label' => 'Ijazah Terakhir',
                                            'name' => 'diploma',
                                            'accept' => 'image/*,.pdf',
                                            'current' => $applicant->diploma_path,
                                            'note' => 'Format JPG/PNG/PDF, maksimal 4 MB',
                                        ],
                                        [
                                            'label' => 'Transkrip Nilai',
                                            'name' => 'transcript',
                                            'accept' => 'image/*,.pdf',
                                            'current' => $applicant->transcript_path,
                                            'note' => 'Format JPG/PNG/PDF, maksimal 4 MB',
                                        ],
                                    ];
                                @endphp

                                @foreach ($documents as $document)
                                    <div class="bg-white p-6 rounded-xl border border-outline-variant/20 shadow-sm">
                                        <div class="flex items-start justify-between gap-4">
                                            <div>
                                                <h4 class="font-bold text-sm text-primary">{{ $document['label'] }}</h4>
                                                <p class="text-xs text-on-surface-variant mt-1">{{ $document['note'] }}</p>
                                            </div>
                                            <span class="text-[10px] font-bold px-2 py-1 rounded-full {{ $document['current'] ? 'bg-secondary/10 text-secondary' : 'bg-outline-variant/40 text-on-surface-variant' }}">
                                                {{ $document['current'] ? 'Sudah diunggah' : 'Belum diunggah' }}
                                            </span>
                                        </div>
                                        <label class="mt-4 flex items-center justify-between gap-4 p-4 border-2 border-dashed rounded-lg cursor-pointer hover:border-primary transition-colors">
                                            <span class="text-xs font-semibold text-on-surface-variant">Pilih file</span>
                                            <x-lucide-icon name="upload" class="w-5 h-5 text-primary" />
                                            <input type="file" name="{{ $document['name'] }}" accept="{{ $document['accept'] }}" class="hidden" />
                                        </label>
                                        @if ($document['current'])
                                            <a href="{{ asset('storage/' . $document['current']) }}" target="_blank" class="mt-3 inline-flex items-center gap-2 text-xs font-bold text-primary">
                                                <x-lucide-icon name="file-text" class="w-4 h-4" />
                                                Lihat dokumen terakhir
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </form>
                    </div>

                    <div class="bg-surface-container-low p-8 flex items-center justify-between gap-4">
                        <a href="{{ route('form.step1') }}" class="flex items-center gap-2 px-8 py-4 border-2 border-primary text-primary font-bold rounded-xl hover:bg-primary/5 transition-all">
                            <x-lucide-icon name="arrow-left" class="w-5 h-5" />
                            Kembali
                        </a>
                        <button type="submit" form="form-step2" class="flex items-center gap-2 px-10 py-4 bg-secondary text-white font-bold rounded-xl shadow-lg shadow-secondary/20 hover:scale-[1.02] transition-all">
                            Simpan Dokumen
                            <x-lucide-icon name="arrow-right" class="w-5 h-5" />
                        </button>
                    </div>
                </div>

                @include('partials.footer')
            </div>
        </main>
    </div>
</x-app-layout>