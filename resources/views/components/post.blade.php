@props(['post', 'edit', 'newPost'])

@php
if(!function_exists('timeAgo')){
    function timeAgo($time) {
      $diff = time() - $time;
        
      // Time difference in seconds
      $sec = $diff;
      // Convert time difference in minutes
      $min = round($diff / 60 );
      // Convert time difference in hours
      $hrs = round($diff / 3600);
      // Convert time difference in days
      $days = round($diff / 86400 );
      // Convert time difference in weeks
      $weeks = round($diff / 604800);
      // Convert time difference in months
      $mnths = round($diff / 2600640 );
      // Convert time difference in years
      $yrs = round($diff / 31207680 );
        
      // Check for seconds
      if($sec <= 60) {
          echo $sec . "s ago";
      }
      // Check for minutes
      else if($min <= 60) {
        echo $min . "m ago";
      }
      // Check for hours
      else if($hrs <= 24) {
          if($hrs == 1) { 
              echo "1 hour ago";
          }
          else {
              echo "$hrs hours ago";
          }
      }
      // Check for days
      else if($days <= 7) {
          if($days == 1) {
              echo "Yesterday";
          }
          else {
              echo "$days days ago";
          }
      }
        
      // Check for weeks
      else if($weeks <= 4.3) {
          if($weeks == 1) {
              echo "a week ago";
          }
          else {
              echo "$weeks weeks ago";
          }
      }
      // Check for months
      else if($mnths <= 12) {
          if($mnths == 1) {
              echo "a month ago";
          }
          else {
              echo "$mnths months ago";
          }
      }
      // Check for years
      else {
          if($yrs == 1) {
              echo "one year ago";
          }
          else {
              echo "$yrs years ago";
          }
      }
    }
}
@endphp

<div class="card p-2 shadow rounded-3 mb-3 {{isset($newPost) ? $newPost : 'border-0'}}">
    <div class="card-header px-0 px-lg-3 border-0 bg-transparent d-flex justify-content-between pb-0">
        <div class="d-flex flex-grow-1">
            <a href="{{url('')}}/profile/{{$post->user->id}}">
                <div class="post-user-photo rounded-circle shadow-sm me-3"
                    style="background-image: url('{{asset('storage/' . $post->user->photo)}}');"></div>
            </a>
            <div class="d-flex align-items-center">
                <div>
                    <a href="{{url('')}}/profile/{{$post->user->id}}" class="d-block text-decoration-none h6 mb-0">{{$post->user->first_name}} {{$post->user->last_name}}</a>
                    <small>{{timeAgo(strtotime($post->created_at))}}</small>
                </div>
            </div>
        </div>
        @if (auth()->id() == $post->user->id)
            <div class="dropdown">
                <div class="" role="button" id="postDrop{{$post->id}}" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        version="1.1" id="mdi-dots-horizontal" width="24" height="24" viewBox="0 0 24 24">
                        <path
                            d="M16,12A2,2 0 0,1 18,10A2,2 0 0,1 20,12A2,2 0 0,1 18,14A2,2 0 0,1 16,12M10,12A2,2 0 0,1 12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12M4,12A2,2 0 0,1 6,10A2,2 0 0,1 8,12A2,2 0 0,1 6,14A2,2 0 0,1 4,12Z"
                            fill="currentColor" />
                    </svg>
                </div>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="postDrop{{$post->id}}">
                    <li><a class="dropdown-item" href="{{url('')}}/posts/{{$post->id}}/edit">Edit</a></li>
                </ul>
            </div>
        @endif
    </div>
    <div class="card-body px-0 px-lg-3">
        @if($post->type == 'share')
            @if(!empty($post['description']))
            <p class="mb-0">
                {{$post['description']}}
            </p>
            @endif
            <x-shared-post :post="$post->share()" />
        @else
            @if (!empty($post['image']) && !empty($post['description']))
                <p>
                    {{$post['description']}}
                </p>
                <div class="text-center">
                    <img class="w-75 rounded-3 shadow-sm"
                        src="{{asset('/storage/' . $post['image'])}}" alt="Post Image">
                </div>
            @elseif(empty($post['image']))
                <p class="mb-0">
                    {{$post['description']}}
                </p>
            @elseif(empty($post['description']))
                <div class="text-center">
                    <img class="w-75 rounded-3 shadow-sm"
                        src="{{asset('/storage/' . $post['image'])}}" alt="Post Image">
                </div>
            @endif
        @endif
    </div>
    <div class="card-footer px-0 px-lg-3 border-0 bg-transparent pb-0">
        <div class="d-flex justify-content-between mb-3">
            <div>
                <small><span id="likes{{$post->id}}">{{count($post->likes)}}</span> Likes</small>
            </div>
            <div>
                <small><span id="comments{{$post->id}}">{{count($post->comments)}}</span> Comments</small>
                <small><span id="shares{{$post->id}}" class="ms-3">{{count($post->shares)}}</span> Shares</small>
            </div>
        </div>
        <div class="d-flex post-btns">
            <button
                class="btn btn-white rounded-0 rounded-start flex-fill d-flex justify-content-start align-items-center {{$post->liked() ? 'text-primary' : null;}}"
                onclick="like(this, {{$post->id}})" data-token="{{session()->get('_apiToken')}}">
                @if ($post->liked())
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-heart" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5C2,5.41 4.42,3 7.5,3C9.24,3 10.91,3.81 12,5.08C13.09,3.81 14.76,3 16.5,3C19.58,3 22,5.41 22,8.5C22,12.27 18.6,15.36 13.45,20.03L12,21.35Z" 
                        fill="currentColor" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        version="1.1" id="mdi-heart-outline" width="24" height="24" viewBox="0 0 24 24">
                        <path
                            d="M12.1,18.55L12,18.65L11.89,18.55C7.14,14.24 4,11.39 4,8.5C4,6.5 5.5,5 7.5,5C9.04,5 10.54,6 11.07,7.36H12.93C13.46,6 14.96,5 16.5,5C18.5,5 20,6.5 20,8.5C20,11.39 16.86,14.24 12.1,18.55M16.5,3C14.76,3 13.09,3.81 12,5.08C10.91,3.81 9.24,3 7.5,3C4.42,3 2,5.41 2,8.5C2,12.27 5.4,15.36 10.55,20.03L12,21.35L13.45,20.03C18.6,15.36 22,12.27 22,8.5C22,5.41 19.58,3 16.5,3Z"
                            fill="currentColor" />
                    </svg>
                @endif
                <small class="ms-1">Like</small>
            </button>
            <button
                class="btn btn-white rounded-0 border-start flex-fill d-flex justify-content-center align-items-center"
                data-bs-toggle="modal" data-bs-target="#commentsModal" onclick="comments(this, {{$post->id}})" data-token="{{session()->get('_apiToken')}}">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    version="1.1" id="mdi-comment-text-outline" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path
                        d="M9,22A1,1 0 0,1 8,21V18H4A2,2 0 0,1 2,16V4C2,2.89 2.9,2 4,2H20A2,2 0 0,1 22,4V16A2,2 0 0,1 20,18H13.9L10.2,21.71C10,21.9 9.75,22 9.5,22V22H9M10,16V19.08L13.08,16H20V4H4V16H10M6,7H18V9H6V7M6,11H15V13H6V11Z"
                        fill="currentColor" />
                </svg>
                <small class="ms-1">Comments</small>
            </button>
            @if ($post->type != 'share')
                <button
                    class="btn btn-white rounded-0 border-start rounded-end flex-fill d-flex justify-content-end align-items-center"
                    data-bs-toggle="modal" data-bs-target="#shareModal" onclick="share(this, {{$post->id}})" data-token="{{session()->get('_apiToken')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        version="1.1" id="mdi-share-outline" width="24" height="24" viewBox="0 0 24 24">
                        <path
                            d="M14,5V9C7,10 4,15 3,20C5.5,16.5 9,14.9 14,14.9V19L21,12L14,5M16,9.83L18.17,12L16,14.17V12.9H14C11.93,12.9 10.07,13.28 8.34,13.85C9.74,12.46 11.54,11.37 14.28,11L16,10.73V9.83Z"
                            fill="currentColor" />
                    </svg>
                    <small class="ms-1">Share</small>
                </button>
            @endif
        </div>
    </div>
</div>
