@php
    $isReadonly = $isReadonly ?? false;
@endphp

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
                    <div class="pointer-events-none absolute left-0 top-1/2 -z-10 h-0.5 w-full -translate-y-1/2 bg-surface-container-high"></div>
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

                        @if (session('success'))
                            <div class="mb-6 rounded-lg bg-secondary/10 p-4 text-sm font-semibold text-primary">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('draft_saved'))
                            <div id="draft-saved-toast" class="mb-6 flex items-center gap-4 rounded-lg border-l-4 border-secondary bg-white p-4 text-sm font-semibold text-primary shadow-sm">
                                <div class="flex-1">{{ session('draft_saved') }}</div>
                                <button type="button" data-dismiss="#draft-saved-toast" class="cursor-pointer rounded-lg p-1 text-on-surface-variant transition-colors hover:bg-primary/5 hover:text-primary active:scale-95 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/60">
                                    <x-lucide-icon name="x" class="w-3.5 h-3.5" />
                                </button>
                            </div>
                        @endif

                        @if ($isReadonly)
                            <div class="mb-6 rounded-xl border border-amber-100 bg-amber-50 p-4 text-sm font-semibold text-amber-800">
                                Formulir sudah dikirim dan sedang menunggu review admin. Dokumen dapat dilihat, tetapi tidak dapat diubah kecuali admin meminta revisi.
                            </div>
                        @endif

                        <form id="form-step2" class="space-y-8" method="POST" action="{{ route('form.step2.store') }}" enctype="multipart/form-data">
                            @csrf
                            <fieldset @disabled($isReadonly)>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @php
                                    $documents = [
                                        [
                                            'label' => 'Pas Foto Formal',
                                            'name' => 'photo',
                                            'accept' => '.jpg,.jpeg,.png',
                                            'current' => $applicant->photo_path,
                                            'note' => 'Format JPG/PNG, maksimal 2 MB',
                                        ],
                                        [
                                            'label' => 'KTP / Identitas',
                                            'name' => 'id_card',
                                            'accept' => '.jpg,.jpeg,.png,.pdf',
                                            'current' => $applicant->id_card_path,
                                            'note' => 'Format JPG/PNG/PDF, maksimal 4 MB',
                                        ],
                                        [
                                            'label' => 'Kartu Keluarga',
                                            'name' => 'family_card',
                                            'accept' => '.jpg,.jpeg,.png,.pdf',
                                            'current' => $applicant->family_card_path,
                                            'note' => 'Format JPG/PNG/PDF, maksimal 4 MB',
                                        ],
                                        [
                                            'label' => 'Ijazah Terakhir',
                                            'name' => 'diploma',
                                            'accept' => '.jpg,.jpeg,.png,.pdf',
                                            'current' => $applicant->diploma_path,
                                            'note' => 'Format JPG/PNG/PDF, maksimal 4 MB',
                                        ],
                                        [
                                            'label' => 'Transkrip Nilai',
                                            'name' => 'transcript',
                                            'accept' => '.jpg,.jpeg,.png,.pdf',
                                            'current' => $applicant->transcript_path,
                                            'note' => 'Format JPG/PNG/PDF, maksimal 4 MB',
                                        ],
                                    ];

                                    $missingDocuments = collect($documents)
                                        ->filter(fn ($document) => blank($document['current'])
                                            || (
                                                ! \Illuminate\Support\Facades\Storage::disk('local')->exists($document['current'])
                                                && ! \Illuminate\Support\Facades\Storage::disk('public')->exists($document['current'])
                                            ))
                                        ->values();
                                @endphp

                                @if ($missingDocuments->isNotEmpty())
                                    <div class="md:col-span-2 rounded-xl border border-amber-100 bg-amber-50 p-5 text-sm text-amber-800">
                                        <div class="flex items-start gap-3">
                                            <div class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-secondary text-white">
                                                <x-lucide-icon name="alert-circle" class="h-4.5 w-4.5" />
                                            </div>
                                            <div>
                                                <p class="font-bold text-primary">Dokumen belum lengkap.</p>
                                                <p class="mt-1 leading-relaxed">
                                                    Lengkapi dokumen berikut sebelum mengirim pendaftaran:
                                                </p>
                                                <div class="mt-3 flex flex-wrap gap-2">
                                                    @foreach ($missingDocuments as $document)
                                                        <span class="rounded-full bg-white px-3 py-1 text-xs font-bold text-amber-800 shadow-sm">
                                                            {{ $document['label'] }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @foreach ($documents as $document)
                                    @php
                                        $documentExists = filled($document['current'])
                                            && (
                                                \Illuminate\Support\Facades\Storage::disk('local')->exists($document['current'])
                                                || \Illuminate\Support\Facades\Storage::disk('public')->exists($document['current'])
                                            );
                                        $documentRoutes = [
                                            'photo' => 'photo',
                                            'id_card' => 'id-card',
                                            'family_card' => 'family-card',
                                            'diploma' => 'diploma',
                                            'transcript' => 'transcript',
                                        ];
                                    @endphp
                                    <div class="bg-white p-6 rounded-xl border border-outline-variant/20 shadow-sm">
                                        <div class="flex items-start justify-between gap-4">
                                            <div>
                                                <h4 class="font-bold text-sm text-primary">{{ $document['label'] }}</h4>
                                                <p class="text-xs text-on-surface-variant mt-1">{{ $document['note'] }}</p>
                                            </div>
                                            <span class="text-[10px] font-bold px-2 py-1 rounded-full {{ $documentExists ? 'bg-secondary/10 text-secondary' : 'bg-outline-variant/40 text-on-surface-variant' }}">
                                                {{ $documentExists ? 'Sudah diunggah' : ($document['current'] ? 'File tidak ditemukan' : 'Belum diunggah') }}
                                            </span>
                                        </div>
                                        <label class="mt-4 flex {{ $isReadonly ? 'cursor-not-allowed opacity-50' : 'cursor-pointer hover:border-primary hover:bg-primary/5 active:scale-[0.99]' }} items-center justify-between gap-4 rounded-lg border-2 border-dashed p-4 transition-all focus-within:border-primary focus-within:ring-2 focus-within:ring-secondary/30">
                                            <span class="js-file-label text-xs font-semibold text-on-surface-variant">Pilih file</span>
                                            <x-lucide-icon name="upload" class="w-4.5 h-4.5 text-primary" />
                                            <input type="file" name="{{ $document['name'] }}" accept="{{ $document['accept'] }}" class="hidden js-auto-upload" />
                                        </label>
                                        @error($document['name'])
                                            <p class="mt-3 text-xs font-semibold text-error">{{ $message }}</p>
                                        @enderror
                                        @if ($documentExists)
                                            <a href="{{ route('mahasiswa.dokumen.show', $documentRoutes[$document['name']]) }}" target="_blank" class="mt-3 inline-flex cursor-pointer items-center gap-2 text-xs font-bold text-primary transition-all hover:translate-x-0.5 hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/60">
                                                <x-lucide-icon name="file-text" class="w-3.5 h-3.5" />
                                                Lihat dokumen terakhir
                                            </a>
                                        @elseif ($document['current'])
                                            <p class="mt-3 text-xs font-semibold text-error">
                                                File sebelumnya tidak ditemukan di storage. Silakan unggah ulang dokumen ini.
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            </fieldset>
                        </form>
                    </div>

                    <div class="bg-surface-container-low p-8 flex items-center justify-between gap-4">
                        <a href="{{ route('form.step1') }}" class="flex cursor-pointer items-center gap-2 rounded-xl border-2 border-primary px-8 py-4 font-bold text-primary transition-all hover:bg-primary/5 active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/60">
                            <x-lucide-icon name="arrow-left" class="w-4.5 h-4.5" />
                            Kembali
                        </a>
                        <div class="flex items-center gap-3">
                            @if (! $isReadonly)
                                <button type="submit" form="form-step2" class="flex cursor-pointer items-center gap-2 rounded-xl bg-secondary px-10 py-4 font-bold text-white shadow-lg shadow-secondary/20 transition-all hover:scale-[1.02] hover:brightness-105 active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/60">
                                    Simpan Dokumen
                                    <x-lucide-icon name="upload" class="w-4.5 h-4.5" />
                                </button>
                            @endif

                            @if ($missingDocuments->isEmpty())
                                <a href="{{ route('form.step3') }}" class="flex cursor-pointer items-center gap-2 rounded-xl bg-primary px-10 py-4 font-bold text-white shadow-lg shadow-primary/20 transition-all hover:brightness-110 active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/60">
                                    Lanjut ke Konfirmasi
                                    <x-lucide-icon name="arrow-right" class="w-4.5 h-4.5" />
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                @include('partials.footer')
            </div>
        </main>
    </div>

    <script>
        document.querySelectorAll('[data-dismiss]').forEach(function (button) {
            button.addEventListener('click', function () {
                document.querySelector(button.dataset.dismiss)?.remove();
            });
        });

        @if (! $isReadonly)
        document.querySelectorAll('.js-auto-upload').forEach(function (input) {
            input.addEventListener('change', function () {
                const file = input.files && input.files[0];
                const form = input.closest('form');
                const label = input.closest('label')?.querySelector('.js-file-label');

                if (!file || !form) {
                    return;
                }

                if (label) {
                    label.textContent = 'Mengunggah: ' + file.name;
                    label.classList.remove('text-on-surface-variant');
                    label.classList.add('text-primary');
                }

                form.requestSubmit();
            });
        });
        @endif
    </script>
</x-app-layout>
