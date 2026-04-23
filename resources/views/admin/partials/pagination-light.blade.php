@php
    $paginator = $paginator ?? null;
    $isPaginator = $paginator && method_exists($paginator, 'hasPages');
    $elements = $elements ?? (
        $paginator instanceof \Illuminate\Pagination\LengthAwarePaginator
            ? \Illuminate\Pagination\UrlWindow::make($paginator)
            : []
    );
@endphp

@if ($isPaginator && $paginator->hasPages())
    <div style="background-color: rgba(241,245,249,0.6);" class="px-8 py-5 flex items-center justify-between border-t border-slate-200/60">
        <p class="text-sm font-medium" style="color:#64748B;">
            Menampilkan <span style="color:#1E3A5F;" class="font-bold">{{ $paginator->firstItem() }}</span> - <span style="color:#1E3A5F;" class="font-bold">{{ $paginator->lastItem() }}</span>
            dari <span style="color:#1E3A5F;" class="font-bold">{{ number_format($paginator->total()) }}</span> user
        </p>
        <div class="flex items-center gap-2">
            @if ($paginator->onFirstPage())
                <span class="w-9 h-9 flex items-center justify-center rounded-xl border border-slate-200 text-slate-400">
                    <i class="bi bi-chevron-left w-4 h-4"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="w-9 h-9 flex items-center justify-center rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-100 transition-all">
                    <i class="bi bi-chevron-left w-4 h-4"></i>
                </a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-1 text-slate-400">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span style="background-color:#1E3A5F;" class="w-9 h-9 flex items-center justify-center rounded-xl text-white font-bold text-sm shadow-md">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="w-9 h-9 flex items-center justify-center rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-100 transition-all font-bold text-sm">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="w-9 h-9 flex items-center justify-center rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-100 transition-all">
                    <i class="bi bi-chevron-right w-4 h-4"></i>
                </a>
            @else
                <span class="w-9 h-9 flex items-center justify-center rounded-xl border border-slate-200 text-slate-400">
                    <i class="bi bi-chevron-right w-4 h-4"></i>
                </span>
            @endif
        </div>
    </div>
@endif
