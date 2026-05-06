@if ($paginator->hasPages())
<nav aria-label="Navigasi halaman">
    <ul style="display: flex; gap: 6px; list-style: none; padding: 0; margin: 0; justify-content: center; flex-wrap: wrap;">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <li>
                <span style="display: inline-flex; align-items: center; justify-content: center; width: 38px; height: 38px; border: 1px solid #ddd; color: #ccc; cursor: not-allowed; font-size: 1rem;">&lsaquo;</span>
            </li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                   style="display: inline-flex; align-items: center; justify-content: center; width: 38px; height: 38px; border: 1px solid rgba(212,175,55,0.4); color: var(--accent-gold); text-decoration: none; font-size: 1rem; transition: all 0.2s;"
                   onmouseover="this.style.background='var(--accent-gold)';this.style.color='var(--primary-dark)'"
                   onmouseout="this.style.background='transparent';this.style.color='var(--accent-gold)'"
                   aria-label="Sebelumnya">&lsaquo;</a>
            </li>
        @endif

        {{-- Pages --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li>
                    <span style="display: inline-flex; align-items: center; justify-content: center; width: 38px; height: 38px; color: #aaa; font-size: 0.9rem;">{{ $element }}</span>
                </li>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li aria-current="page">
                            <span style="display: inline-flex; align-items: center; justify-content: center; width: 38px; height: 38px; background: var(--primary-dark); color: var(--accent-gold); font-weight: 700; font-size: 0.9rem; border: 1px solid var(--primary-dark);">{{ $page }}</span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $url }}"
                               style="display: inline-flex; align-items: center; justify-content: center; width: 38px; height: 38px; border: 1px solid #ddd; color: var(--primary-dark); text-decoration: none; font-size: 0.9rem; transition: all 0.2s;"
                               onmouseover="this.style.borderColor='var(--accent-gold)';this.style.color='var(--accent-gold)'"
                               onmouseout="this.style.borderColor='#ddd';this.style.color='var(--primary-dark)'">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                   style="display: inline-flex; align-items: center; justify-content: center; width: 38px; height: 38px; border: 1px solid rgba(212,175,55,0.4); color: var(--accent-gold); text-decoration: none; font-size: 1rem; transition: all 0.2s;"
                   onmouseover="this.style.background='var(--accent-gold)';this.style.color='var(--primary-dark)'"
                   onmouseout="this.style.background='transparent';this.style.color='var(--accent-gold)'"
                   aria-label="Berikutnya">&rsaquo;</a>
            </li>
        @else
            <li>
                <span style="display: inline-flex; align-items: center; justify-content: center; width: 38px; height: 38px; border: 1px solid #ddd; color: #ccc; cursor: not-allowed; font-size: 1rem;">&rsaquo;</span>
            </li>
        @endif

    </ul>
</nav>
@endif
