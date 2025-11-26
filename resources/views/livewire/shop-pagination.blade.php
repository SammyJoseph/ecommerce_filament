@if ($paginator->hasPages())
    <div class="pro-pagination-style text-center mt-10">
        <ul>
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li><a class="prev" href="javascript:void(0)"><i class="icon-arrow-left"></i></a></li>
            @else
                <li><a class="prev" href="javascript:void(0)" wire:click="previousPage" wire:loading.attr="disabled"><i class="icon-arrow-left"></i></a></li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li><a href="javascript:void(0)">{{ $element }}</a></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><a class="active" href="javascript:void(0)">{{ $page }}</a></li>
                        @else
                            <li><a href="javascript:void(0)" wire:click="gotoPage({{ $page }})">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li><a class="next" href="javascript:void(0)" wire:click="nextPage" wire:loading.attr="disabled"><i class="icon-arrow-right"></i></a></li>
            @else
                <li><a class="next" href="javascript:void(0)"><i class="icon-arrow-right"></i></a></li>
            @endif
        </ul>
    </div>
@endif
