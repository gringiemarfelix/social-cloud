@props(['notification'])

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

@php
    if($notification->status == 'unread'){
        $status = 'bg-secondary border border-primary';
        $mouseEnter = "onmouseenter=readNotification(this,$notification->id)";
    }else{
        $status = null;
        $mouseEnter = null;
    }
@endphp

<div class="shadow-sm p-2 rounded-3 d-flex align-items-center mb-2 {{$status}}" {{$mouseEnter}} data-token="{{session()->get('_apiToken')}}">
    <a class="text-decoration-none" href="{{url('')}}/profile/{{$notification->from->id}}">
        <div class="comment-user-photo rounded-circle shadow-sm me-3" style="background-image: url('{{asset('storage/' . $notification->from->photo)}}');">
        </div>
    </a>
    <div class="flex-fill">
        <p class="h6 mb-0"><a class="text-decoration-none" href="{{url('')}}/profile/{{$notification->from->id}}">{{$notification->from->first_name}} {{$notification->from->last_name}}</a> • <a class="text-decoration-none" href="{{url('')}}/posts/{{$notification->post_id}}">{{$notification->description}}</a></p>
        <small class="text-black-50">{{timeAgo(strtotime($notification->created_at))}}</small>
    </div>
</div>