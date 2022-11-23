@if ($paginator->hasPages())
<ul class="pagination">
   
    @if ($paginator->onFirstPage())
        <li class="page-item disabled"><span class="page-link" role="button">Previous</span></li>
    @else
        <li class="page-item"><span class="page-link" role="button" onclick="comments(this, {{$post}}, {{ $paginator->currentPage() - 1 }})" data-token="{{$token}}">Previous</span></li>
    @endif


    @foreach ($elements as $element)
       
        @if (is_string($element))
            <li class="disabled"><span>{{ $element }}</span></li>
        @endif
       
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="page-item active"><span class="page-link" role="button" onclick="comments(this, {{$post}}, {{$paginator->currentPage()}})" data-token="{{$token}}">{{ $page }}</span></li>
                @else
                    <li class="page-item"><span class="page-link" role="button" onclick="comments(this, {{$post}}, {{$page}})" data-token="{{$token}}">{{ $page }}</span></li>
                @endif
            @endforeach
        @endif
    @endforeach


    @if ($paginator->hasMorePages())
        <li class="page-item"><span class="page-link" role="button" onclick="comments(this, {{$post}}, {{ $paginator->currentPage() + 1 }})" data-token="{{$token}}">Next</span></li>
    @else
        <li class="page-item disabled"><span class="page-link">Next</span></li>
    @endif
</ul>
@endif 