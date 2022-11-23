<x-layout>
    <div class="col-12 col-lg-8 bg-light rounded-3" style="z-index: 0!important;">
        <div class="p-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    @if (session()->has('message'))
                        <div class="alert alert-primary shadow-sm alert-dismissible fade show my-3" role="alert">
                            {{session('message')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <h5>Friends</h5>
                </div>
                <div class="card-body px-0 px-lg-3">
                    <ul class="nav nav-pills nav-fill mb-3">
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('friends')) ? 'active' : '' }}" aria-current="page" href="{{url('')}}/friends">Friends</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('friends/pending')) ? 'active' : '' }}" href="{{url('')}}/friends/pending">Pending</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('friends/requests')) ? 'active' : '' }}" href="{{url('')}}/friends/requests">Requests <span class="ms-1 badge rounded-circle bg-secondary text-danger {{$requests > 0 ? null : 'd-none';}}">{{$requests}}</span></a>
                        </li>
                    </ul>
                    <div class="row gx-0 gx-lg-4 bg-light py-3">
                        @if (!count($friends))
                            @php
                                if(request()->is('friends')){
                                    $empty = 'Your friends list is empty. Add your friends now!';
                                }else if(request()->is('friends/pending')){
                                    $empty = 'No pending sent friend requests.';
                                }else{
                                    $empty = 'No pending received friend requests.';
                                }
                            @endphp
                            <h6 class="text-black-50 text-center mb-0 py-5">{{$empty}}</h6>
                        @else
                            @foreach ($friends as $friend)
                                <div class="col-12 col-lg-3 mb-3">
                                    <div class="card border-0 shadow-sm">
                                        <a class="card-body d-flex align-items-center text-decoration-none" href="{{url('')}}/profile/{{$friend->id}}">
                                            <div class="friends-photo rounded-circle shadow-sm me-3" style="background-image: url('{{asset('storage/' . $friend->photo)}}');"></div>
                                            <h6>{{$friend->first_name}} {{$friend->last_name}}</h6>
                                        </a>
                                        <div class="card-footer d-flex justify-content-center bg-white border-0">
                                            @php
                                                if(request()->is('friends') || request()->is('friends/pending')){
                                                    $action = 'remove';
                                                    $method = 'delete';
                                                }
                                            @endphp
                                            @if (request()->is('friends') || request()->is('friends/pending'))
                                                <form class="w-100" action="{{url('')}}/friends/{{$friend->id}}/remove" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="text" name="user_id" value="{{$friend->id}}" hidden>
                                                    <button class="btn btn-secondary w-100 mx-1" type="submit">
                                                        @if (request()->is('friends'))
                                                            Remove Friend
                                                        @else
                                                            Cancel Request
                                                        @endif
                                                    </button>
                                                </form>
                                            @else
                                                <form class="w-100" action="{{url('')}}/friends/{{$friend->id}}/accept" method="POST">
                                                    @csrf
                                                    @method('put')
                                                    <input type="text" name="user_id" value="{{$friend->id}}" hidden>
                                                    <button class="btn btn-primary w-100 mx-1" type="submit">
                                                        Accept
                                                    </button>
                                                </form>
                                                <form class="w-100" action="{{url('')}}/friends/{{$friend->id}}/reject" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="text" name="user_id" value="{{$friend->id}}" hidden>
                                                    <button class="btn btn-secondary w-100 mx-1" type="submit">
                                                        Reject
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-12">
                                <div class="d-flex justify-content-center mt-4">
                                    {{$friends->links('vendor.pagination.custom')}}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>