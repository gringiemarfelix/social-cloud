@props(['post'])

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

<div class="card border-1 shadow-sm rounded-3 my-3">
    <div class="card-body">
        <div class="card border-0">
            <div class="card-header border-0 bg-transparent d-flex justify-content-between pb-0">
                <div class="d-flex flex-grow-1">
                    <a href="{{url('')}}/profile/{{$post->user->id}}">
                        <div class="post-user-photo rounded-circle shadow-sm me-3" style="background-image: url('{{asset('storage/' . $post->user->photo)}}');">
                        </div>
                    </a>
                    <div class="d-flex align-items-center">
                        <div>
                            <a href="{{url('')}}/profile/{{$post->user->id}}" class="d-block text-decoration-none h6 mb-0">{{$post->user->first_name}} {{$post->user->last_name}}</a>
                            <small>{{timeAgo(strtotime($post->created_at))}}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if (!empty($post['image']) && !empty($post['description']))
                    <p>
                        {{$post['description']}}
                    </p>
                    <img class="w-100 rounded-3 shadow-sm me-3"
                        src="{{asset('/storage/' . $post['image'])}}" alt="Post Image">
                @elseif(empty($post['image']))
                    <p class="mb-0">
                        {{$post['description']}}
                    </p>
                @elseif(empty($post['description']))
                    <img class="w-100 rounded-3 shadow-sm me-3"
                        src="{{asset('/storage/' . $post['image'])}}" alt="Post Image">     
                @endif
            </div>
        </div>
    </div>
</div>