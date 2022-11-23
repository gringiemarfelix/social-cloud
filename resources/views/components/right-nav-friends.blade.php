@if (count($friends))
    @foreach ($friends as $friend)    
        <a href="{{url('')}}/profile/{{$friend->id}}"
            class="text-decoration-none text-body d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
                <div class="nav-friends-photo rounded-circle shadow-sm me-2" style="background-image: url('{{asset('storage/'. $friend->photo)}}');"></div>
                <p class="mb-0">{{$friend->first_name}} {{$friend->last_name}}</p>
            </div>
            <div>
                @php
                    $newPosts = auth()->user()->newPosts($friend->id)->count();
                @endphp
                @if ($newPosts)
                    <span class="badge rounded-pill bg-secondary text-primary fw-bold">•{{$newPosts}} {{$newPosts > 1 ? 'posts' : 'post'}}</span>
                @else
                    <span class="badge text-black-50">No new posts</span>
                @endif
            </div>
        </a>
    @endforeach
@else
    <div class="text-center">
        <small class="text-black-50 fw-bold">No results found.</small>
    </div>
@endif