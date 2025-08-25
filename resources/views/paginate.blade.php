@if ($paginator->hasPages())
    <ul class="flex justify-center items-center space-x-2">
        @if ($paginator->onFirstPage())
            <li class="cursor-not-allowed px-2 py-1 text-gray-500 bg-gray-200 rounded-md"><i class="fa-solid fa-angles-right rotate-180"></i>Previous</li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" class="px-2 py-1 text-white bg-blue-500 rounded-md"><i class="fa-solid fa-angles-right rotate-180"></i>Previous</a></li>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="px-2 py-1 text-gray-700 bg-gray-200 rounded-md cursor-not-allowed">{{ $element }}</li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="px-2 py-1 text-white bg-blue-500 rounded-md cursor-not-allowed">{{ $page }}</li>
                    @else
                        <li><a href="{{ $url }}" class="px-2 py-1 text-blue-500 hover:text-white hover:bg-blue-500 rounded-md transition duration-300">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" class="px-2 py-1 text-white bg-blue-500 rounded-md">Next <i class="fa-solid fa-angles-right"></i></a></li>
        @else
            <li class="cursor-not-allowed px-2 py-1 text-gray-500 bg-gray-200 rounded-md">Next <i class="fa-solid fa-angles-right"></i></li>
        @endif
    </ul>
@endif
