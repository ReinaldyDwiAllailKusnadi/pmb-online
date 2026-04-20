@php
    $provinces = ['DKI Jakarta', 'Jawa Barat', 'Jawa Tengah'];
    $religions = ['Pilih Agama', 'Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha'];
    $citizens = ['WNI', 'WNA'];
    $genders = ['Laki-laki', 'Perempuan'];
    $maritals = ['Belum Menikah', 'Menikah'];
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
                <div class="fixed top-20 right-8 z-50 flex items-center gap-4 bg-white p-4 rounded-xl shadow-xl border-l-4 border-secondary">
                    <div class="w-10 h-10 bg-secondary/10 rounded-full flex items-center justify-center text-secondary">
                        <x-lucide-icon name="info" class="w-5 h-5" />
                    </div>
                    <div class="flex-1 min-w-50">
                        <h4 class="font-bold text-sm">Draft Saved</h4>
                        <p class="text-xs text-on-surface-variant">Your progress is automatically saved.</p>
                    </div>
                    <button class="text-on-surface-variant hover:text-primary transition-colors">
                        <x-lucide-icon name="x" class="w-4 h-4" />
                    </button>
                </div>

                <div class="flex items-center justify-between mb-12 relative px-4">
                    <div class="absolute top-1/2 left-0 w-full h-0.5 bg-surface-container-high -translate-y-1/2 -z-10"></div>
                    <div class="flex flex-col items-center gap-3 bg-background px-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-extrabold text-sm bg-secondary text-white shadow-lg shadow-secondary/30">1</div>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-primary">Data Pribadi</span>
                    </div>
                    <div class="flex flex-col items-center gap-3 bg-background px-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-extrabold text-sm bg-outline-variant/40 text-on-surface-variant">2</div>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Akademik</span>
                    </div>
                    <div class="flex flex-col items-center gap-3 bg-background px-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-extrabold text-sm bg-outline-variant/40 text-on-surface-variant">3</div>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Konfirmasi</span>
                    </div>
                </div>

                <div class="bg-surface-container-lowest rounded-2xl shadow-editorial overflow-hidden">
                    <div class="p-8 lg:p-10">
                        <div class="mb-10 inline-block">
                            <h2 class="text-2xl font-headline font-bold tracking-tight">Data Pribadi</h2>
                            <div class="h-1 w-1/2 bg-primary mt-1 rounded-full"></div>
                        </div>

                        <form id="form-step1" class="space-y-8" method="POST" action="{{ route('form.step1.store') }}">
                            @csrf
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                                <div class="lg:col-span-1">
                                    <div class="flex flex-col items-center p-6 bg-surface-container-low rounded-xl border-2 border-dashed border-outline-variant/50">
                                        <div class="w-40 h-52 bg-white rounded-lg mb-4 shadow-inner overflow-hidden relative group">
                                            <img
                                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuA5jCo7jDM0a6C6YagsVkp_MGZe53QJbFpO_nRu1PL2nNArvAPiYUXfq5-0LRZPwrEVUW-MqWPd6_QcCQS7KMwRyXHA5gNTZnAVDOenGeAiu-8Uj-dzmC31JzmaszbQ-gZlQ7_VvH-qFYRo1_C-MS5xIOPCkYSBSlJVBr08AHdu0GXdgoWJFAVMlUwFafxk7iPt8ZX6ya7dNiZ5PHk0_p3JoBjINMkaJDIZarCkoFudWWS831MIuCp-kcFGMQQZ_gMPxdmD2L9MaSA"
                                                alt="Placeholder"
                                                referrerpolicy="no-referrer"
                                                class="w-full h-full object-cover grayscale opacity-40"
                                            />
                                            <div class="absolute inset-0 bg-primary/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                                                <x-lucide-icon name="camera" class="text-white" />
                                            </div>
                                        </div>
                                        <p class="text-[10px] text-center text-on-surface-variant leading-relaxed mb-4 font-medium uppercase tracking-tight">
                                            Upload Pas Foto Formal (3x4)<br />Max size 2MB, format JPG/PNG
                                        </p>
                                        <button type="button" class="px-4 py-2 bg-surface-container-highest text-primary text-xs font-bold rounded-lg hover:bg-primary hover:text-white transition-all shadow-sm">
                                            Pilih Foto
                                        </button>
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
                                            <x-lucide-icon name="alert-circle" class="w-3 h-3" />
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
                                    <input name="city" value="{{ old('city', $applicant->city) }}" placeholder="Kabupaten / Kota" class="w-full p-4 bg-surface-container-low border-none rounded-xl ghost-border text-primary font-medium focus:ring-1 focus:ring-primary" />
                                </div>

                                <div class="space-y-2 relative">
                                    <label class="text-xs font-bold text-primary uppercase tracking-wider">Provinsi</label>
                                    <div class="relative">
                                        <select name="province" class="w-full p-4 bg-surface-container-low border-none rounded-xl ghost-border text-primary font-medium appearance-none focus:ring-1 focus:ring-primary">
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province }}" {{ old('province', $applicant->province) === $province ? 'selected' : '' }}>{{ $province }}</option>
                                            @endforeach
                                        </select>
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">
                                            <x-lucide-icon name="chevron-down" class="w-4 h-4" />
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-primary uppercase tracking-wider">Telepon Rumah</label>
                                    <input name="home_phone" value="{{ old('home_phone', $applicant->home_phone) }}" placeholder="021-xxxxxx" type="tel" class="w-full p-4 bg-surface-container-low border-none rounded-xl ghost-border text-primary font-medium focus:ring-1 focus:ring-primary" />
                                </div>

                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-primary uppercase tracking-wider">Nomor Handphone</label>
                                    <input name="phone" value="{{ old('phone', $applicant->phone) }}" placeholder="08xxxxxxx" type="tel" class="w-full p-4 bg-surface-container-low border-none rounded-xl ghost-border text-primary font-medium focus:ring-1 focus:ring-primary" />
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-primary uppercase tracking-wider">Alamat Email</label>
                                    <input name="email" type="email" value="{{ old('email', $applicant->email) }}" placeholder="contoh@mail.com" class="w-full p-4 bg-surface-container-low border-none rounded-xl ghost-border text-primary font-medium focus:ring-1 focus:ring-primary" />
                                </div>

                                <div class="space-y-4">
                                    <label class="text-xs font-bold text-primary uppercase tracking-wider block">Kewarganegaraan</label>
                                    <div class="flex gap-6">
                                        @foreach ($citizens as $citizen)
                                            <label class="flex items-center gap-3 cursor-pointer group">
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
                                            <label class="flex items-center gap-3 cursor-pointer group">
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
                                            <label class="flex items-center gap-3 cursor-pointer group">
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
                            </div>
                        </form>
                    </div>

                    <div class="bg-surface-container-low p-8 flex items-center justify-between gap-4">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-8 py-4 border-2 border-primary text-primary font-bold rounded-xl hover:bg-primary/5 transition-all">
                            <x-lucide-icon name="arrow-left" class="w-5 h-5" />
                            Kembali
                        </a>
                        <button type="submit" form="form-step1" class="flex items-center gap-2 px-10 py-4 bg-secondary text-white font-bold rounded-xl shadow-lg shadow-secondary/20 hover:scale-[1.02] transition-all">
                            Simpan & Lanjut
                            <x-lucide-icon name="arrow-right" class="w-5 h-5" />
                        </button>
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
</x-app-layout>