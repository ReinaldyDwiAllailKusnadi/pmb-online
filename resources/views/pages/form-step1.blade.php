@php
    $religions = ['Pilih Agama', 'Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha'];
    $citizens = ['WNI', 'WNA'];
    $genders = ['Laki-laki', 'Perempuan'];
    $maritals = ['Belum Menikah', 'Menikah'];
    $isReadonly = $isReadonly ?? false;
    $regions = $regions ?? [];
    $provinces = $provinces ?? array_keys($regions);
    $selectedProvince = old('province', $applicant->province);
    $selectedCity = old('city', $applicant->city);
    $selectedCities = $regions[$selectedProvince] ?? [];
    $stepperCompleted = in_array($applicant->status, ['submitted', 'under_review', 'verified', 'accepted'], true);
    $photoExists = filled($applicant->photo_path)
        && (
            \Illuminate\Support\Facades\Storage::disk('local')->exists($applicant->photo_path)
            || \Illuminate\Support\Facades\Storage::disk('public')->exists($applicant->photo_path)
        );
@endphp

<x-app-layout title="Formulir Pendaftaran">
    <div class="flex min-h-screen bg-background font-body text-primary">
    @include('partials.sidebar', ['activePage' => 'formulir'])

        <main class="flex-1 ml-65 relative">
            @include('partials.topbar', [
                'pageLabel' => 'Formulir Pendaftaran',
                'userName' => $applicant->full_name,
                'userRole' => 'Calon Mahasiswa',
                'userAvatar' => 'https://ui-avatars.com/api/?name=' . urlencode($applicant->full_name),
            ])

            <div class="max-w-5xl mx-auto p-10 pb-24">
                @if (session('draft_saved'))
                    <div id="draft-saved-toast" class="fixed top-20 right-8 z-50 flex items-center gap-4 bg-white p-4 rounded-xl shadow-xl border-l-4 border-secondary">
                        <div class="w-10 h-10 bg-secondary/10 rounded-full flex items-center justify-center text-secondary">
                            <x-lucide-icon name="info" class="w-4.5 h-4.5" />
                        </div>
                        <div class="flex-1 min-w-50">
                            <h4 class="font-bold text-sm">Draft Saved</h4>
                            <p class="text-xs text-on-surface-variant">{{ session('draft_saved') }}</p>
                        </div>
                        <button type="button" data-dismiss="#draft-saved-toast" class="cursor-pointer rounded-lg p-1 text-on-surface-variant transition-colors hover:bg-primary/5 hover:text-primary active:scale-95 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/60">
                            <x-lucide-icon name="x" class="w-3.5 h-3.5" />
                        </button>
                    </div>
                @endif

                <div class="flex items-center justify-between mb-12 relative px-4">
                    <div class="pointer-events-none absolute left-0 top-1/2 -z-10 h-0.5 w-full -translate-y-1/2 bg-surface-container-high"></div>
                    <div class="flex flex-col items-center gap-3 bg-background px-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-extrabold text-sm {{ $stepperCompleted ? 'bg-primary text-white shadow-lg' : 'bg-secondary text-white shadow-lg shadow-secondary/30' }}">1</div>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-primary">Data Pribadi</span>
                    </div>
                    <div class="flex flex-col items-center gap-3 bg-background px-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-extrabold text-sm {{ $stepperCompleted ? 'bg-primary text-white shadow-lg' : 'bg-outline-variant/40 text-on-surface-variant' }}">2</div>
                        <span class="text-[10px] font-bold uppercase tracking-widest {{ $stepperCompleted ? 'text-primary' : 'text-on-surface-variant' }}">Akademik</span>
                    </div>
                    <div class="flex flex-col items-center gap-3 bg-background px-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-extrabold text-sm {{ $stepperCompleted ? 'bg-primary text-white shadow-lg' : 'bg-outline-variant/40 text-on-surface-variant' }}">3</div>
                        <span class="text-[10px] font-bold uppercase tracking-widest {{ $stepperCompleted ? 'text-primary' : 'text-on-surface-variant' }}">Konfirmasi</span>
                    </div>
                </div>

                <div class="bg-surface-container-lowest rounded-2xl shadow-editorial overflow-hidden">
                    <div class="p-8 lg:p-10">
                        <div class="mb-10 inline-block">
                            <h2 class="text-2xl font-headline font-bold tracking-tight">Data Pribadi</h2>
                            <div class="h-1 w-1/2 bg-primary mt-1 rounded-full"></div>
                        </div>

                        @if ($isReadonly)
                            <div class="mb-6 rounded-xl border border-amber-100 bg-amber-50 p-4 text-sm font-semibold text-amber-800">
                                Formulir sudah dikirim dan sedang menunggu review admin. Data dapat dilihat, tetapi tidak dapat diubah kecuali admin meminta revisi.
                            </div>
                        @endif

                        <form id="form-step1" class="space-y-8" method="POST" action="{{ route('form.step1.store') }}" enctype="multipart/form-data">
                            @csrf
                            <fieldset @disabled($isReadonly)>
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                                <div class="lg:col-span-1">
                                    <div class="flex flex-col items-center p-6 bg-surface-container-low rounded-xl border-2 border-dashed border-outline-variant/50">
                                        <div class="w-40 h-52 bg-white rounded-lg mb-4 shadow-inner overflow-hidden relative group">
                                            @if ($photoExists)
                                                <img
                                                    id="photo-preview"
                                                    src="{{ route('mahasiswa.dokumen.show', 'photo') }}"
                                                    alt="Pas Foto Formal"
                                                    class="h-full w-full object-cover"
                                                />
                                            @else
                                                <img
                                                    id="photo-preview"
                                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuA5jCo7jDM0a6C6YagsVkp_MGZe53QJbFpO_nRu1PL2nNArvAPiYUXfq5-0LRZPwrEVUW-MqWPd6_QcCQS7KMwRyXHA5gNTZnAVDOenGeAiu-8Uj-dzmC31JzmaszbQ-gZlQ7_VvH-qFYRo1_C-MS5xIOPCkYSBSlJVBr08AHdu0GXdgoWJFAVMlUwFafxk7iPt8ZX6ya7dNiZ5PHk0_p3JoBjINMkaJDIZarCkoFudWWS831MIuCp-kcFGMQQZ_gMPxdmD2L9MaSA"
                                                    alt="Placeholder"
                                                    referrerpolicy="no-referrer"
                                                    class="h-full w-full object-cover grayscale opacity-40"
                                                />
                                            @endif
                                            <div class="pointer-events-none absolute inset-0 flex cursor-pointer items-center justify-center bg-primary/40 opacity-0 transition-opacity group-hover:opacity-100">
                                                <x-lucide-icon name="camera" class="text-white w-5 h-5" />
                                            </div>
                                        </div>
                                        <p class="text-[10px] text-center text-on-surface-variant leading-relaxed mb-4 font-medium uppercase tracking-tight">
                                            Upload Pas Foto Formal (3x4)<br />Max size 2MB, format JPG/PNG
                                        </p>
                                        <label for="photo-upload" class="{{ $isReadonly ? 'cursor-not-allowed opacity-50' : 'cursor-pointer hover:bg-primary hover:text-white active:scale-[0.98]' }} rounded-lg bg-surface-container-highest px-4 py-2 text-xs font-bold text-primary shadow-sm transition-all focus-within:outline-none focus-within:ring-2 focus-within:ring-secondary/60">
                                            Pilih Foto
                                            <input id="photo-upload" type="file" name="photo" accept=".jpg,.jpeg,.png" class="sr-only" />
                                        </label>
                                        @error('photo')
                                            <p class="mt-3 text-center text-xs font-semibold text-error">{{ $message }}</p>
                                        @enderror
                                        <p id="photo-file-name" class="mt-3 text-center text-[10px] font-semibold text-on-surface-variant"></p>
                                    </div>
                                </div>

                                <div class="lg:col-span-2 space-y-6">
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold text-primary uppercase tracking-wider">Nama Lengkap</label>
                                        <input
                                            type="text"
                                            name="full_name"
                                            value="{{ old('full_name', $applicant->full_name) }}"
                                            placeholder="Masukkan nama sesuai KTP"
                                            class="w-full p-4 bg-surface-container-low border-none rounded-xl ghost-border text-primary font-medium focus:ring-1 focus:ring-primary"
                                        />
                                        <span class="text-[10px] text-error font-medium flex items-center gap-1">
                                            <x-lucide-icon name="alert-circle" class="w-3.5 h-3.5" />
                                            Wajib diisi sesuai identitas resmi
                                        </span>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="text-xs font-bold text-primary uppercase tracking-wider">Alamat Sesuai KTP</label>
                                        <textarea
                                            name="address"
                                            rows="3"
                                            class="w-full p-4 bg-surface-container-low border-none rounded-xl ghost-border text-primary font-medium focus:ring-1 focus:ring-primary"
                                        >{{ old('address', $applicant->address) }}</textarea>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="text-xs font-bold text-primary uppercase tracking-wider">Alamat Domisili Saat Ini</label>
                                        <textarea
                                            name="current_address"
                                            rows="3"
                                            placeholder="Masukkan alamat lengkap saat ini"
                                            class="w-full p-4 bg-surface-container-low border-none rounded-xl ghost-border text-primary font-medium focus:ring-1 focus:ring-primary"
                                        >{{ old('current_address', $applicant->current_address) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-6">
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-primary uppercase tracking-wider">Kecamatan</label>
                                    <input name="district" value="{{ old('district', $applicant->district) }}" placeholder="Kecamatan" class="w-full p-4 bg-surface-container-low border-none rounded-xl ghost-border text-primary font-medium focus:ring-1 focus:ring-primary" />
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-primary uppercase tracking-wider">Kabupaten / Kota</label>
                                    <div class="relative">
                                        <select id="city-select" name="city" data-selected-city="{{ $selectedCity }}" class="w-full p-4 bg-surface-container-low border-none rounded-xl ghost-border text-primary font-medium appearance-none focus:ring-1 focus:ring-primary">
                                            <option value="">Pilih Kabupaten / Kota</option>
                                            @foreach ($selectedCities as $city)
                                                <option value="{{ $city }}" {{ $selectedCity === $city ? 'selected' : '' }}>{{ $city }}</option>
                                            @endforeach
                                            @if ($selectedCity && ! in_array($selectedCity, $selectedCities, true))
                                                <option value="{{ $selectedCity }}" selected>{{ $selectedCity }}</option>
                                            @endif
                                        </select>
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">
                                            <x-lucide-icon name="chevron-down" class="w-3.5 h-3.5" />
                                        </div>
                                    </div>
                                    @error('city')
                                        <p class="text-xs font-semibold text-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-2 relative">
                                    <label class="text-xs font-bold text-primary uppercase tracking-wider">Provinsi</label>
                                    <div class="relative">
                                        <select id="province-select" name="province" class="w-full p-4 bg-surface-container-low border-none rounded-xl ghost-border text-primary font-medium appearance-none focus:ring-1 focus:ring-primary">
                                            <option value="">Pilih Provinsi</option>
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province }}" {{ $selectedProvince === $province ? 'selected' : '' }}>{{ $province }}</option>
                                            @endforeach
                                        </select>
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">
                                            <x-lucide-icon name="chevron-down" class="w-3.5 h-3.5" />
                                        </div>
                                    </div>
                                    @error('province')
                                        <p class="text-xs font-semibold text-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-primary uppercase tracking-wider">Telepon Rumah</label>
                                    <input name="home_phone" value="{{ old('home_phone', $applicant->home_phone) }}" placeholder="021xxxxxx" type="tel" inputmode="numeric" pattern="[0-9]*" data-numeric-only class="w-full p-4 bg-surface-container-low border-none rounded-xl ghost-border text-primary font-medium focus:ring-1 focus:ring-primary" />
                                    @error('home_phone')
                                        <p class="text-xs font-semibold text-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-primary uppercase tracking-wider">Nomor Handphone</label>
                                    <input name="phone" value="{{ old('phone', $applicant->phone) }}" placeholder="08xxxxxxx" type="tel" inputmode="numeric" pattern="[0-9]*" data-numeric-only class="w-full p-4 bg-surface-container-low border-none rounded-xl ghost-border text-primary font-medium focus:ring-1 focus:ring-primary" />
                                    @error('phone')
                                        <p class="text-xs font-semibold text-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-primary uppercase tracking-wider">Alamat Email</label>
                                    <input name="email" type="email" value="{{ old('email', $applicant->email) }}" placeholder="contoh@mail.com" class="w-full p-4 bg-surface-container-low border-none rounded-xl ghost-border text-primary font-medium focus:ring-1 focus:ring-primary" />
                                </div>

                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-primary uppercase tracking-wider">Asal Sekolah</label>
                                    <input name="asal_sekolah" value="{{ old('asal_sekolah', $applicant->asal_sekolah) }}" placeholder="Nama SMA/SMK/MA asal" class="w-full p-4 bg-surface-container-low border-none rounded-xl ghost-border text-primary font-medium focus:ring-1 focus:ring-primary" />
                                    @error('asal_sekolah')
                                        <p class="text-xs font-semibold text-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-4">
                                    <label class="text-xs font-bold text-primary uppercase tracking-wider block">Kewarganegaraan</label>
                                    <div class="flex gap-6">
                                        @foreach ($citizens as $citizen)
                                            <label class="group flex cursor-pointer items-center gap-3 rounded-lg transition-colors focus-within:text-secondary">
                                                <input type="radio" name="citizen" value="{{ $citizen }}" class="w-5 h-5 text-secondary border-outline-variant focus:ring-secondary transition-all" {{ old('citizen', $applicant->citizen ?? 'WNI') === $citizen ? 'checked' : '' }} />
                                                <span class="text-sm font-medium group-hover:text-secondary transition-colors">{{ $citizen }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-primary uppercase tracking-wider">Tempat Lahir</label>
                                    <input name="birth_place" value="{{ old('birth_place', $applicant->birth_place) }}" placeholder="Kota Kelahiran" class="w-full p-4 bg-surface-container-low border-none rounded-xl ghost-border text-primary font-medium focus:ring-1 focus:ring-primary" />
                                </div>

                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-primary uppercase tracking-wider">Tanggal Lahir</label>
                                    <div class="grid grid-cols-3 gap-3">
                                        <select name="birth_day" class="p-4 bg-surface-container-low border-none rounded-xl ghost-border text-primary font-medium appearance-none focus:ring-1 focus:ring-primary">
                                            <option>Tgl</option>
                                            @for ($i = 1; $i <= 31; $i++)
                                                @php $dayValue = sprintf('%02d', $i); @endphp
                                                <option value="{{ $dayValue }}" {{ old('birth_day', $applicant->birth_day) === $dayValue ? 'selected' : '' }}>{{ $dayValue }}</option>
                                            @endfor
                                        </select>
                                        <select name="birth_month" class="p-4 bg-surface-container-low border-none rounded-xl ghost-border text-primary font-medium appearance-none focus:ring-1 focus:ring-primary">
                                            <option>Bulan</option>
                                            @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $month)
                                                <option value="{{ $month }}" {{ old('birth_month', $applicant->birth_month) === $month ? 'selected' : '' }}>{{ $month }}</option>
                                            @endforeach
                                        </select>
                                        <select name="birth_year" class="p-4 bg-surface-container-low border-none rounded-xl ghost-border text-primary font-medium appearance-none focus:ring-1 focus:ring-primary">
                                            <option>Tahun</option>
                                            @for ($i = 0; $i < 20; $i++)
                                                @php $yearValue = (string) (2010 - $i); @endphp
                                                <option value="{{ $yearValue }}" {{ old('birth_year', $applicant->birth_year) === $yearValue ? 'selected' : '' }}>{{ $yearValue }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <label class="text-xs font-bold text-primary uppercase tracking-wider block">Jenis Kelamin</label>
                                    <div class="flex gap-6">
                                        @foreach ($genders as $gender)
                                            <label class="group flex cursor-pointer items-center gap-3 rounded-lg transition-colors focus-within:text-secondary">
                                                <input type="radio" name="gender" value="{{ $gender }}" class="w-5 h-5 text-secondary border-outline-variant focus:ring-secondary transition-all" {{ old('gender', $applicant->gender) === $gender ? 'checked' : '' }} />
                                                <span class="text-sm font-medium group-hover:text-secondary transition-colors">{{ $gender }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <label class="text-xs font-bold text-primary uppercase tracking-wider block">Status Menikah</label>
                                    <div class="flex gap-6">
                                        @foreach ($maritals as $marital)
                                            <label class="group flex cursor-pointer items-center gap-3 rounded-lg transition-colors focus-within:text-secondary">
                                                <input type="radio" name="marital" value="{{ $marital }}" class="w-5 h-5 text-secondary border-outline-variant focus:ring-secondary transition-all" {{ old('marital', $applicant->marital ?? 'Belum Menikah') === $marital ? 'checked' : '' }} />
                                                <span class="text-sm font-medium group-hover:text-secondary transition-colors">{{ $marital }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="space-y-2 relative">
                                    <label class="text-xs font-bold text-primary uppercase tracking-wider">Agama</label>
                                    <div class="relative">
                                        <select name="religion" class="w-full p-4 bg-surface-container-low border-none rounded-xl ghost-border text-primary font-medium appearance-none focus:ring-1 focus:ring-primary">
                                            @foreach ($religions as $religion)
                                                <option value="{{ $religion }}" {{ old('religion', $applicant->religion) === $religion ? 'selected' : '' }}>{{ $religion }}</option>
                                            @endforeach
                                        </select>
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">
                                            <x-lucide-icon name="chevron-down" class="w-4 h-4" />
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-2 relative">
                                    <label class="text-xs font-bold text-primary uppercase tracking-wider">Program Studi Pilihan</label>
                                    <div class="relative">
                                        <select name="program_studi_id" class="w-full p-4 bg-surface-container-low border-none rounded-xl ghost-border text-primary font-medium appearance-none focus:ring-1 focus:ring-primary">
                                            <option value="">Pilih Program Studi</option>
                                            @foreach ($programStudi as $program)
                                                <option value="{{ $program->id }}" {{ (string) old('program_studi_id', $applicant->program_studi_id) === (string) $program->id ? 'selected' : '' }}>
                                                    {{ $program->displayName() }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">
                                            <x-lucide-icon name="chevron-down" class="w-4 h-4" />
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-2 relative">
                                    <label class="text-xs font-bold text-primary uppercase tracking-wider">Gelombang Pendaftaran</label>
                                    <div class="relative">
                                        <select name="gelombang_pendaftaran_id" class="w-full p-4 bg-surface-container-low border-none rounded-xl ghost-border text-primary font-medium appearance-none focus:ring-1 focus:ring-primary">
                                            <option value="">Pilih Gelombang</option>
                                            @foreach ($gelombangPendaftaran as $gelombang)
                                                <option value="{{ $gelombang->id }}" {{ (string) old('gelombang_pendaftaran_id', $applicant->gelombang_pendaftaran_id) === (string) $gelombang->id ? 'selected' : '' }}>
                                                    {{ $gelombang->nama }} - {{ $gelombang->tahun_akademik }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">
                                            <x-lucide-icon name="chevron-down" class="w-4 h-4" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </fieldset>
                        </form>
                    </div>

                    <div class="bg-surface-container-low p-8 flex items-center justify-between gap-4">
                        <a href="{{ route('dashboard') }}" class="flex cursor-pointer items-center gap-2 rounded-xl border-2 border-primary px-8 py-4 font-bold text-primary transition-all hover:bg-primary/5 active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/60">
                            <x-lucide-icon name="arrow-left" class="w-5 h-5" />
                            Kembali
                        </a>
                        @if ($isReadonly)
                            <a href="{{ route('form.step2') }}" class="flex cursor-pointer items-center gap-2 rounded-xl bg-secondary px-10 py-4 font-bold text-white shadow-lg shadow-secondary/20 transition-all hover:brightness-105 active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/60">
                                Lanjut
                                <x-lucide-icon name="arrow-right" class="w-5 h-5" />
                            </a>
                        @else
                            <button type="submit" form="form-step1" class="flex cursor-pointer items-center gap-2 rounded-xl bg-secondary px-10 py-4 font-bold text-white shadow-lg shadow-secondary/20 transition-all hover:scale-[1.02] hover:brightness-105 active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/60">
                                Simpan & Lanjut
                                <x-lucide-icon name="arrow-right" class="w-5 h-5" />
                            </button>
                        @endif
                    </div>
                </div>

                <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-6 bg-white rounded-xl shadow-editorial flex gap-4 border border-outline-variant/10">
                        <div class="w-10 h-10 rounded-full bg-primary/5 flex items-center justify-center text-primary shrink-0">
                            <x-lucide-icon name="shield-check" class="w-5 h-5" />
                        </div>
                        <div>
                            <h5 class="font-bold text-sm text-primary">Data Terenkripsi</h5>
                            <p class="text-xs text-on-surface-variant mt-1 leading-relaxed">Seluruh data yang Anda masukkan dilindungi secara ketat.</p>
                        </div>
                    </div>
                    <div class="p-6 bg-white rounded-xl shadow-editorial flex gap-4 border border-outline-variant/10">
                        <div class="w-10 h-10 rounded-full bg-primary/5 flex items-center justify-center text-primary shrink-0">
                            <x-lucide-icon name="clock" class="w-5 h-5" />
                        </div>
                        <div>
                            <h5 class="font-bold text-sm text-primary">Draft Otomatis</h5>
                            <p class="text-xs text-on-surface-variant mt-1 leading-relaxed">Anda dapat melanjutkan pendaftaran kapan saja.</p>
                        </div>
                    </div>
                    <div class="p-6 bg-white rounded-xl shadow-editorial flex gap-4 border border-outline-variant/10">
                        <div class="w-10 h-10 rounded-full bg-primary/5 flex items-center justify-center text-primary shrink-0">
                            <x-lucide-icon name="message-circle" class="w-5 h-5" />
                        </div>
                        <div>
                            <h5 class="font-bold text-sm text-primary">Butuh Bantuan?</h5>
                            <p class="text-xs text-on-surface-variant mt-1 leading-relaxed">Hubungi helpdesk kami di (021) 123-4567.</p>
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

        const indonesiaRegions = @json($regions);
        const provinceSelect = document.getElementById('province-select');
        const citySelect = document.getElementById('city-select');

        function renderCityOptions(province, selectedCity = '') {
            if (!citySelect) {
                return;
            }

            const cities = indonesiaRegions[province] || [];
            citySelect.innerHTML = '';
            citySelect.append(new Option('Pilih Kabupaten / Kota', ''));

            cities.forEach(function (city) {
                citySelect.append(new Option(city, city, false, city === selectedCity));
            });
        }

        provinceSelect?.addEventListener('change', function () {
            renderCityOptions(provinceSelect.value);
        });

        document.querySelectorAll('[data-numeric-only]').forEach(function (input) {
            input.addEventListener('input', function () {
                input.value = input.value.replace(/\D/g, '');
            });
        });

        @if (! $isReadonly)
        document.getElementById('photo-upload')?.addEventListener('change', function (event) {
            const file = event.target.files?.[0];
            const preview = document.getElementById('photo-preview');
            const fileName = document.getElementById('photo-file-name');

            if (!file || !preview) {
                return;
            }

            preview.src = URL.createObjectURL(file);
            preview.classList.remove('grayscale', 'opacity-40');

            if (fileName) {
                fileName.textContent = file.name;
            }
        });
        @endif
    </script>
</x-app-layout>
