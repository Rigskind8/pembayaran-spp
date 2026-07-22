@if ($paginator->hasPages())
    <div class="page-links">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span style="padding:6px 11px;border-radius:8px;border:1px solid #e8eaf0;font-size:12px;font-weight:600;color:#9ca3af;cursor:not-allowed;opacity:0.5;">
                &lsaquo;
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" style="padding:6px 11px;border-radius:8px;border:1px solid #e8eaf0;font-size:12px;font-weight:600;text-decoration:none;color:#6b7280;display:inline-block;transition:all .15s;" 
               onmouseover="this.style.background='#fff7ed';this.style.borderColor='#ea580c';this.style.color='#ea580c';" 
               onmouseout="this.style.background='transparent';this.style.borderColor='#e8eaf0';this.style.color='#6b7280';">
                &lsaquo;
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span style="padding:6px 11px;border-radius:8px;border:1px solid #e8eaf0;font-size:12px;font-weight:600;color:#9ca3af;">
                    {{ $element }}
                </span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span style="padding:6px 11px;border-radius:8px;border:1px solid #ea580c;background:#ea580c;color:white;font-size:12px;font-weight:600;display:inline-block;">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" style="padding:6px 11px;border-radius:8px;border:1px solid #e8eaf0;font-size:12px;font-weight:600;text-decoration:none;color:#6b7280;display:inline-block;transition:all .15s;"
                           onmouseover="this.style.background='#fff7ed';this.style.borderColor='#ea580c';this.style.color='#ea580c';" 
                           onmouseout="this.style.background='transparent';this.style.borderColor='#e8eaf0';this.style.color='#6b7280';">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" style="padding:6px 11px;border-radius:8px;border:1px solid #e8eaf0;font-size:12px;font-weight:600;text-decoration:none;color:#6b7280;display:inline-block;transition:all .15s;"
               onmouseover="this.style.background='#fff7ed';this.style.borderColor='#ea580c';this.style.color='#ea580c';" 
               onmouseout="this.style.background='transparent';this.style.borderColor='#e8eaf0';this.style.color='#6b7280';">
                &rsaquo;
            </a>
        @else
            <span style="padding:6px 11px;border-radius:8px;border:1px solid #e8eaf0;font-size:12px;font-weight:600;color:#9ca3af;cursor:not-allowed;opacity:0.5;">
                &rsaquo;
            </span>
        @endif
    </div>
@endif
