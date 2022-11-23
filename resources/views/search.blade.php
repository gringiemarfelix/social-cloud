<x-layout>
    <div class="col-12 col-lg-8 bg-light rounded-3" style="z-index: 0!important;">
        <div class="p-lg-3">
            @if (!request()->is('search/posts'))  
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5>Users</h5>
                    </div>
                    <div class="card-body px-1 px-lg-3">
                        <div class="row gx-0 gx-lg-4 bg-light py-3">
                            @if (!count($users))
                                <h6 class="text-black-50 text-center mb-0 py-5">No users found.</h6>
                            @else
                                @foreach ($users as $user)
                                    <div class="col-12 col-lg-3 mb-3">
                                        <div class="card border-0 shadow-sm">
                                            <a class="card-body d-flex align-items-center text-decoration-none" href="{{url('')}}/profile/{{$user->id}}">
                                                <div class="friends-photo rounded-circle shadow-sm me-3" style="background-image: url('{{asset('storage/' . $user->photo)}}');"></div>
                                                <h6>{{$user->first_name}} {{$user->last_name}}</h6>
                                            </a>
                                            <div class="card-footer d-flex justify-content-center bg-white border-0">
                                                @if ($statuses[$user->id] == 'confirmed' || $statuses[$user->id] == 'requested')
                                                    <form class="w-100" action="{{url('')}}/friends/{{$user->id}}/remove" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <input type="text" name="user_id" value="{{$user->id}}" hidden>
                                                        <button class="btn btn-secondary w-100 mx-1" type="submit">
                                                            @if ($statuses[$user->id] == 'confirmed')
                                                                Remove Friend 
                                                            @else
                                                                Cancel Request
                                                            @endif
                                                        </button>
                                                    </form>
                                                @elseif($statuses[$user->id] == 'pending')
                                                    <form class="w-100" action="{{url('')}}/friends/{{$user->id}}/accept" method="POST">
                                                        @csrf
                                                        @method('put')
                                                        <input type="text" name="user_id" value="{{$user->id}}" hidden>
                                                        <button class="btn btn-primary w-100 mx-1" type="submit">
                                                            Accept
                                                        </button>
                                                    </form>
                                                    <form class="w-100" action="{{url('')}}/friends/{{$user->id}}/reject" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <input type="text" name="user_id" value="{{$user->id}}" hidden>
                                                        <button class="btn btn-secondary w-100 mx-1" type="submit">
                                                            Reject
                                                        </button>
                                                    </form>
                                                @else
                                                    <form class="w-100" action="{{url('')}}/friends/{{$user->id}}/add" method="POST">
                                                        @csrf
                                                        <input type="text" name="user_id" value="{{$user->id}}" hidden>
                                                        <button class="btn btn-secondary w-100 mx-1" type="submit">
                                                            Add Friend
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            @if (count($users) > 12 && !request('page'))
                                <div class="col-12">
                                    <a class="btn btn-lg btn-primary w-100" href="{{url('')}}/search/users?search={{request('search')}}&page=1">View All</a>
                                </div>
                            @elseif(request('page'))
                                <div class="col-12">
                                    <div class="d-flex justify-content-center mt-4">
                                        {{$users->withQueryString()->links('vendor.pagination.custom')}}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            @if (!request()->is('search/users'))
                <div class="card border-0 shadow-sm my-3">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5>Posts</h5>
                    </div>
                    <div class="card-body px-0 px-lg-3">
                        <div class="post-container mx-auto">
                            @if (!count($posts))
                                <h6 class="text-black-50 text-center mb-0 py-5">No posts found.</h6>
                            @else
                                @foreach ($posts as $post)
                                    <x-post :post="$post" />
                                @endforeach
                            @endif
                            @if (count($posts) > 1 && !request('page'))
                                <a class="btn btn-lg btn-primary w-100 my-3" href="{{url('')}}/search/posts?search={{request('search')}}&page=1">View All</a>
                            @elseif(request('page'))
                                <div class="d-flex justify-content-center mt-4">
                                    {{$posts->withQueryString()->links('vendor.pagination.custom')}}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layout>