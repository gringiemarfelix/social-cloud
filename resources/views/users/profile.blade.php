<x-layout :user="$user">
    <div class="col-12 col-lg-8 bg-light rounded-3" style="z-index: 0!important;">
        <div class="pt-5 px-lg-5 pb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 p-0 position-relative">
                    <div class="cover-photo shadow-sm rounded-top rounded-3" style="background-image: url('{{asset('storage/' . $user->cover)}}');">
                    </div>
                    @if (auth()->id() == $user->id)
                        <form action="{{url('')}}/profile" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="btn btn-sm btn-secondary position-absolute bottom-0 end-0 m-3" style="z-index: 3000!important;" role="button" onclick="document.getElementById('coverPhoto').click();">
                                Update Cover Photo
                            </div>
                            <input type="file" name="coverPhoto" id="coverPhoto" hidden="" onchange="form.submit();">
                        </form>
                    @endif
                </div>
                <div class="card-body mt-n5" style="z-index: 2000!important;">
                    <div class="ms-3 mt-n5">
                        <div class="profile-photo rounded-circle shadow mb-3 bg-white" style="background-image: url('{{asset('storage/' . $user->photo)}}');">
                        </div>
                        <div class="d-flex justify-content-between">
                            <h4 class="mb-0">{{$user->first_name}} {{$user->last_name}}</h4>
                            <div>
                                @if ($user->id == auth()->id())
                                    <form action="{{url('')}}/profile" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="btn btn-sm btn-secondary" style="z-index: 3000!important;" role="button" onclick="document.getElementById('profilePhoto').click();">
                                            Update Profile Photo
                                        </div>
                                        <input type="file" name="profilePhoto" id="profilePhoto" hidden="" onchange="form.submit();">
                                    </form>
                                @else
                                    @if ($isFriend == 'confirmed' || $isFriend == 'requested')
                                        <form class="w-100" action="{{url('')}}/friends/{{$user->id}}/remove" method="POST">
                                            @csrf
                                            @method('delete')
                                            <input type="text" name="user_id" value="{{$user->id}}" hidden>
                                            <button class="btn btn-secondary w-100 mx-1" type="submit">
                                                @if ($isFriend == 'confirmed')
                                                    Remove Friend 
                                                @else
                                                    Cancel Request
                                                @endif
                                            </button>
                                        </form>
                                    @elseif($isFriend == 'pending')
                                        <div class="d-flex">
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
                                        </div>
                                    @elseif(!$isFriend)
                                        <form class="w-100" action="{{url('')}}/friends/{{$user->id}}/add" method="POST">
                                            @csrf
                                            <input type="text" name="user_id" value="{{$user->id}}" hidden>
                                            <button class="btn btn-secondary w-100 mx-1" type="submit">
                                                Add Friend
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-lg-5">
            <div class="row gx-0 gx-lg-4">
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-header border-0 bg-white pt-3 pb-0">
                            <h6 class="mb-0">About Me</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-email-outline" width="24" height="24" viewBox="0 0 24 24"><path d="M22 6C22 4.9 21.1 4 20 4H4C2.9 4 2 4.9 2 6V18C2 19.1 2.9 20 4 20H20C21.1 20 22 19.1 22 18V6M20 6L12 11L4 6H20M20 18H4V8L12 13L20 8V18Z" 
                                    fill="currentColor" /></svg>
                                <span class="ms-1">{{$user->email}}</span>
                            </div>
                            @if (!empty($user->gender))
                                <div class="d-flex align-items-center mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-account-outline" width="24" height="24" viewBox="0 0 24 24"><path d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,6A2,2 0 0,0 10,8A2,2 0 0,0 12,10A2,2 0 0,0 14,8A2,2 0 0,0 12,6M12,13C14.67,13 20,14.33 20,17V20H4V17C4,14.33 9.33,13 12,13M12,14.9C9.03,14.9 5.9,16.36 5.9,17V18.1H18.1V17C18.1,16.36 14.97,14.9 12,14.9Z" 
                                        fill="currentColor" /></svg>
                                    <span class="ms-1">{{ucwords($user->gender)}}</span>
                                </div>
                            @endif
                            
                            @if (!empty($user->birthday))
                                <div class="d-flex align-items-center mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-cake-variant-outline" width="24" height="24" 
                                        viewBox="0 0 24 24">
                                        <path d="M12 6C13.11 6 14 5.1 14 4C14 3.62 13.9 3.27 13.71 2.97L12 0L10.29 2.97C10.1 3.27 10 3.62 10 4C10 5.1 10.9 6 12 6M18 9H13V7H11V9H6C4.34 9 3 10.34 3 12V21C3 21.55 3.45 22 4 22H20C20.55 22 21 21.55 21 21V12C21 10.34 19.66 9 18 9M19 20H5V17C5.9 17 6.76 16.63 7.4 16L8.5 14.92L9.56 16C10.87 17.3 13.15 17.29 14.45 16L15.53 14.92L16.6 16C17.24 16.63 18.1 17 19 17V20M19 15.5C18.5 15.5 18 15.3 17.65 14.93L15.5 12.8L13.38 14.93C12.64 15.67 11.35 15.67 10.61 14.93L8.5 12.8L6.34 14.93C6 15.29 5.5 15.5 5 15.5V12C5 11.45 5.45 11 6 11H18C18.55 11 19 11.45 19 12V15.5Z" 
                                        fill="currentColor" /></svg>
                                    <span class="ms-1">{{date('M d, Y', strtotime($user->birthday))}}</span>
                                </div>
                            @endif
                            @if (!empty($user->location))
                                <div class="d-flex align-items-center mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-map-marker-outline" width="24" height="24" viewBox="0 0 24 24"><path d="M12,6.5A2.5,2.5 0 0,1 14.5,9A2.5,2.5 0 0,1 12,11.5A2.5,2.5 0 0,1 9.5,9A2.5,2.5 0 0,1 12,6.5M12,2A7,7 0 0,1 19,9C19,14.25 12,22 12,22C12,22 5,14.25 5,9A7,7 0 0,1 12,2M12,4A5,5 0 0,0 7,9C7,10 7,12 12,18.71C17,12 17,10 17,9A5,5 0 0,0 12,4Z" 
                                        fill="currentColor" /></svg>
                                    <span class="ms-1">{{$user->location}}</span>
                                </div>
                            @endif
                            @if (!empty($user->website))
                                <div class="d-flex align-items-center mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-web" width="24" height="24" viewBox="0 0 24 24"><path d="M16.36,14C16.44,13.34 16.5,12.68 16.5,12C16.5,11.32 16.44,10.66 16.36,10H19.74C19.9,10.64 20,11.31 20,12C20,12.69 19.9,13.36 19.74,14M14.59,19.56C15.19,18.45 15.65,17.25 15.97,16H18.92C17.96,17.65 16.43,18.93 14.59,19.56M14.34,14H9.66C9.56,13.34 9.5,12.68 9.5,12C9.5,11.32 9.56,10.65 9.66,10H14.34C14.43,10.65 14.5,11.32 14.5,12C14.5,12.68 14.43,13.34 14.34,14M12,19.96C11.17,18.76 10.5,17.43 10.09,16H13.91C13.5,17.43 12.83,18.76 12,19.96M8,8H5.08C6.03,6.34 7.57,5.06 9.4,4.44C8.8,5.55 8.35,6.75 8,8M5.08,16H8C8.35,17.25 8.8,18.45 9.4,19.56C7.57,18.93 6.03,17.65 5.08,16M4.26,14C4.1,13.36 4,12.69 4,12C4,11.31 4.1,10.64 4.26,10H7.64C7.56,10.66 7.5,11.32 7.5,12C7.5,12.68 7.56,13.34 7.64,14M12,4.03C12.83,5.23 13.5,6.57 13.91,8H10.09C10.5,6.57 11.17,5.23 12,4.03M18.92,8H15.97C15.65,6.75 15.19,5.55 14.59,4.44C16.43,5.07 17.96,6.34 18.92,8M12,2C6.47,2 2,6.5 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" 
                                        fill="currentColor" /></svg>
                                    <span class="ms-1">{{$user->website}}</span>
                                </div>
                            @endif
                            @if (!empty($user->facebook))
                                <div class="d-flex align-items-center mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-facebook" width="24" height="24" viewBox="0 0 24 24"><path d="M12 2.04C6.5 2.04 2 6.53 2 12.06C2 17.06 5.66 21.21 10.44 21.96V14.96H7.9V12.06H10.44V9.85C10.44 7.34 11.93 5.96 14.22 5.96C15.31 5.96 16.45 6.15 16.45 6.15V8.62H15.19C13.95 8.62 13.56 9.39 13.56 10.18V12.06H16.34L15.89 14.96H13.56V21.96A10 10 0 0 0 22 12.06C22 6.53 17.5 2.04 12 2.04Z" 
                                        fill="currentColor" /></svg>
                                    <span class="ms-1">{{$user->facebook}}</span>
                                </div>
                            @endif
                            @if (!empty($user->youtube))
                                <div class="d-flex align-items-center mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-youtube" width="24" height="24" viewBox="0 0 24 24"><path d="M10,15L15.19,12L10,9V15M21.56,7.17C21.69,7.64 21.78,8.27 21.84,9.07C21.91,9.87 21.94,10.56 21.94,11.16L22,12C22,14.19 21.84,15.8 21.56,16.83C21.31,17.73 20.73,18.31 19.83,18.56C19.36,18.69 18.5,18.78 17.18,18.84C15.88,18.91 14.69,18.94 13.59,18.94L12,19C7.81,19 5.2,18.84 4.17,18.56C3.27,18.31 2.69,17.73 2.44,16.83C2.31,16.36 2.22,15.73 2.16,14.93C2.09,14.13 2.06,13.44 2.06,12.84L2,12C2,9.81 2.16,8.2 2.44,7.17C2.69,6.27 3.27,5.69 4.17,5.44C4.64,5.31 5.5,5.22 6.82,5.16C8.12,5.09 9.31,5.06 10.41,5.06L12,5C16.19,5 18.8,5.16 19.83,5.44C20.73,5.69 21.31,6.27 21.56,7.17Z" 
                                        fill="currentColor" /></svg>
                                    <span class="ms-1">{{$user->youtube}}</span>
                                </div>
                            @endif
                            @if (!empty($user->twitter))
                                <div class="d-flex align-items-center mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-twitter" width="24" height="24" viewBox="0 0 24 24"><path d="M22.46,6C21.69,6.35 20.86,6.58 20,6.69C20.88,6.16 21.56,5.32 21.88,4.31C21.05,4.81 20.13,5.16 19.16,5.36C18.37,4.5 17.26,4 16,4C13.65,4 11.73,5.92 11.73,8.29C11.73,8.63 11.77,8.96 11.84,9.27C8.28,9.09 5.11,7.38 3,4.79C2.63,5.42 2.42,6.16 2.42,6.94C2.42,8.43 3.17,9.75 4.33,10.5C3.62,10.5 2.96,10.3 2.38,10C2.38,10 2.38,10 2.38,10.03C2.38,12.11 3.86,13.85 5.82,14.24C5.46,14.34 5.08,14.39 4.69,14.39C4.42,14.39 4.15,14.36 3.89,14.31C4.43,16 6,17.26 7.89,17.29C6.43,18.45 4.58,19.13 2.56,19.13C2.22,19.13 1.88,19.11 1.54,19.07C3.44,20.29 5.7,21 8.12,21C16,21 20.33,14.46 20.33,8.79C20.33,8.6 20.33,8.42 20.32,8.23C21.16,7.63 21.88,6.87 22.46,6Z" 
                                        fill="currentColor" /></svg>
                                    <span class="ms-1">{{$user->twitter}}</span>
                                </div>
                            @endif
                            @if (!empty($user->instagram))
                                <div class="d-flex align-items-center mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-instagram" width="24" height="24" viewBox="0 0 24 24"><path d="M7.8,2H16.2C19.4,2 22,4.6 22,7.8V16.2A5.8,5.8 0 0,1 16.2,22H7.8C4.6,22 2,19.4 2,16.2V7.8A5.8,5.8 0 0,1 7.8,2M7.6,4A3.6,3.6 0 0,0 4,7.6V16.4C4,18.39 5.61,20 7.6,20H16.4A3.6,3.6 0 0,0 20,16.4V7.6C20,5.61 18.39,4 16.4,4H7.6M17.25,5.5A1.25,1.25 0 0,1 18.5,6.75A1.25,1.25 0 0,1 17.25,8A1.25,1.25 0 0,1 16,6.75A1.25,1.25 0 0,1 17.25,5.5M12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9Z" 
                                        fill="currentColor" /></svg>
                                    <span class="ms-1">{{$user->instagram}}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card border-0 shadow-sm mb-3">
                        <div
                            class="card-header border-0 bg-white pt-3 pb-0 d-flex align-items-center justify-content-between">
                            <h6 class="mb-0">Friends</h6>
                            <a href="{{url('')}}/profile/{{$user->id}}/friends"><small>View all</small></a>
                        </div>
                        <div class="card-body">
                            <div class="row gx-2">
                                @if (!count($friends))
                                    <div class="col-12 text-center">
                                        <p class="h6 mb-0 text-black-50 py-5">Friends list empty.</p>
                                    </div>
                                @endif
                                @foreach ($friends as $friend)
                                <a href="{{url('')}}/profile/{{$friend->id}}" class="col-4 text-decoration-none text-body mb-2">
                                    <div class="card border-0 shadow-sm mb-3 text-center h-100">
                                        <div class="card-header border-0 bg-white p-1">
                                            <div class="profile-friends-photo bg-white rounded-3 shadow-sm mx-auto" style="background-image: url('{{asset('storage/' . $friend->photo)}}');"></div>
                                        </div>
                                        <div class="card-body p-1">
                                            <small class="fw-bold mb-0">{{$friend->first_name}} {{$friend->last_name}}</small>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    @if (session()->has('message'))
                        <div class="alert alert-primary shadow-sm alert-dismissible fade show" role="alert">
                            {{session('message')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if (auth()->id() == $user->id)
                        @include('partials._create-post')
                    @endif
                    
                    @if (count($posts))
                        @foreach ($posts as $post)
                            @php
                                $newPost = 'border-0';
                                if(auth()->id() != $user->id){
                                    $newPosts = auth()->user()->newPosts($user->id)->pluck('id')->toArray();
                                    $friendIDs = auth()->user()->friends->pluck('id')->toArray();
                                    if(in_array($post->id, $newPosts) && in_array($user->id, $friendIDs)){
                                        $newPost = 'border border-primary';
                                        auth()->user()->updateLastVisit($user->id);
                                    }
                                }
                            @endphp
                            <x-post :post="$post" :newPost="$newPost" />
                        @endforeach
                    @else
                        <div class="text-center text-black-50 mt-3">
                            <p class="h5">No posts found.</p>
                        </div>
                    @endif
                    <div class="d-flex justify-content-center mt-4">
                        {{$posts->links('vendor.pagination.custom')}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials._comments-modal')
    @include('partials._share-modal')
</x-layout>