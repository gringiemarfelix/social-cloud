
        <div class="col-lg-2 position-sticky shadow-sm d-none d-lg-block"
            style="min-height: calc(100vh - 61px); top: 61px;">
            <div class="position-sticky" style="top: 77px;">
                <div class="position-relative text-muted">
                    <input type="text" class="form-control border-secondary" placeholder="Search..." onkeyup="searchFriends(this)" data-token="{{session()->get('_apiToken')}}">
                    <span style="position: absolute; top: 6px; right: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            version="1.1" id="mdi-magnify" width="24" height="24" viewBox="0 0 24 24">
                            <path
                                d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z"
                                fill="currentColor" />
                        </svg>
                    </span>
                </div>
                <h6 class="text-black-50 my-3">FRIENDS</h6>
                <div class="pb-3" style="max-height: calc(100vh - 80px); overflow-y: scroll;" id="right-nav-friends">
                    @if (auth()->user()->friends->count())
                        @foreach (auth()->user()->friends->take(50) as $friend)
                            <x-right-nav-friend :friend="$friend"/>
                        @endforeach
                    @else
                        <div class="text-center">
                            <small class="text-black-50">Empty friends list. <br> Add your friends now!</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>