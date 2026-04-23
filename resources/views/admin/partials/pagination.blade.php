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
    <div style="background-color:#1E3A5F;" class="px-8 py-5 flex items-center justify-between">
        <p class="text-slate-300 text-xs font-medium">
            Menampilkan <span class="text-white font-bold">{{ $paginator->firstItem() }}</span>-<span class="text-white font-bold">{{ $paginator->lastItem() }}</span>
            dari <span class="text-white font-bold">{{ number_format($paginator->total()) }}</span> data pendaftaran
        </p>
        <div class="flex items-center gap-2">
            @if ($paginator->onFirstPage())
                <span class="w-8 h-8 flex items-center justify-center bg-white/10 rounded-lg text-white/50 cursor-not-allowed">
                    <i class="bi bi-chevron-left"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center bg-white/20 text-white rounded-lg hover:bg-white/30 transition-colors">
                    <i class="bi bi-chevron-left"></i>
                </a>
            @endif

            <div class="flex items-center gap-1.5">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="text-white/30 px-1">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span style="background-color:#F0A500;" class="w-8 h-8 flex items-center justify-center text-white rounded-lg font-bold text-xs shadow-lg">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center text-white/60 hover:text-white hover:bg-white/10 rounded-lg font-bold text-xs transition-colors">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center bg-white/20 text-white rounded-lg hover:bg-white/30 transition-colors">
                    <i class="bi bi-chevron-right"></i>
                </a>
            @else
                <span class="w-8 h-8 flex items-center justify-center bg-white/10 rounded-lg text-white/50 cursor-not-allowed">
                    <i class="bi bi-chevron-right"></i>
                </span>
            @endif
        </div>
    </div>
@endif
