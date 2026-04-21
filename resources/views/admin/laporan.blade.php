@extends('layouts.admin')

@section('content')
    @include('admin.partials.sidebar', ['activePage' => 'laporan'])
    @include('admin.partials.topbar', ['placeholder' => 'Cari laporan...'])

    <main style="margin-left:260px; padding-top:64px;" class="p-8">
        <div class="bg-white rounded-3xl border border-slate-200/60 shadow-sm p-8">
            <h2 class="text-2xl font-extrabold" style="color:#1E3A5F;">Laporan</h2>
            <p class="mt-2" style="color:#64748B;">
                Halaman laporan admin sedang disiapkan. Silakan beri tahu section yang ingin ditampilkan terlebih dahulu.
            </p>
        </div>
    </main>
@endsection
