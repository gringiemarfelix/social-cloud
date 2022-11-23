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
                        <div class="profile-photo rounded-circle shadow border border-1 border-primary mb-3 bg-white" style="background-image: url('{{asset('storage/' . $user->photo)}}');">
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
                                    @if ($isFriend == 'confirmed')
                                        <button class="btn btn-sm btn-secondary" style="z-index: 3000!important;">Remove
                                            Friend</button>
                                    @elseif($isFriend == 'pending')
                                        <button class="btn btn-sm btn-secondary" style="z-index: 3000!important;">Cancel
                                            Request</button>
                                    @elseif(!$isFriend)
                                        <button class="btn btn-sm btn-primary" style="z-index: 3000!important;">Add
                                            Friend</button>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-lg-5">
            <div class="card border-0 shadow-sm mb-5">
                <div class="card-header bg-white border-0 pb-0">
                    <h5>Friends</h5>
                </div>
                <div class="card-body">
                    <div class="row gx-0 gx-lg-4 bg-light py-3">
                        @if (!count($friends))
                            <h6 class="text-black-50 text-center mb-0 py-5">No friends found.</h6>
                        @else
                            @foreach ($friends as $friend)
                                <div class="col-3 mb-3">
                                    <div class="card border-0 shadow-sm">
                                        <a class="card-body d-flex align-items-center text-decoration-none" href="{{url('')}}/profile/{{$friend->id}}">
                                            <div class="friends-photo rounded-circle shadow-sm me-3" style="background-image: url('{{asset('storage/' . $friend->photo)}}');"></div>
                                            <h6>{{$friend->first_name}} {{$friend->last_name}}</h6>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <div class="col-12">
                            <div class="d-flex justify-content-center mt-4">
                                {{$friends->links('vendor.pagination.custom')}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials._comments-modal')
    @include('partials._share-modal')
</x-layout>