@extends('layouts.admin')

@section('content')
    @include('admin.partials.sidebar', ['activePage' => 'pengaturan'])
    @include('admin.partials.topbar', ['placeholder' => 'Cari pengaturan...'])

    <main style="margin-left:260px; padding-top:64px;" class="p-8">
        <div class="bg-white rounded-3xl border border-slate-200/60 shadow-sm p-8">
            <h2 class="text-2xl font-extrabold" style="color:#1E3A5F;">Pengaturan</h2>
            <p class="mt-2" style="color:#64748B;">
                Halaman pengaturan admin belum memiliki konten. Beri tahu preferensi dan opsi yang ingin ditampilkan.
            </p>
        </div>
    </main>
@endsection
