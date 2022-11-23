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

@if (count($comments))
    @foreach ($comments as $comment)
        <div class="d-flex mb-3">
            <a href="{{url('')}}/profile/{{$comment->user->id}}">
                <div class="rounded-circle shadow-sm comment-photo me-3" style="background-image: url('{{asset('storage/' . $comment->user->photo)}}');"></div>
            </a>
            <div class="card rounded-3 border-0 w-100">
                <div class="card-body bg-secondary shadow-sm p-2">
                    <div class="d-flex justify-content-between">
                        <a class="text-decoration-none" href="{{url('')}}/profile/{{$comment->user->id}}">
                            <p class="h6 mb-0">{{$comment->user->first_name}} {{$comment->user->last_name}} <small class="ms-1 text-black-50">{{timeAgo(strtotime($comment->created_at))}}</small></p>
                        </a>
                        @if (auth()->id() == $comment->user_id)
                            <form class="deleteCommentForm" action="{{url('')}}/posts/comments/delete" method="POST" onsubmit="deleteComment(this)" data-token="{{session()->get('_apiToken')}}" data-comment="{{$comment->id}}">
                                <button class="btn btn-sm btn-danger" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-trash-can" width="16" height="16" viewBox="0 0 24 24"><path d="M9,3V4H4V6H5V19A2,2 0 0,0 7,21H17A2,2 0 0,0 19,19V6H20V4H15V3H9M9,8H11V17H9V8M13,8H15V17H13V8Z" fill="currentColor" /></svg>
                                </button>
                            </form>
                        @endif
                    </div>
                    <small>{{$comment->description}}</small>
                </div>
            </div>
        </div>
        @php
            $post = $comment->post_id
        @endphp
    @endforeach
    <div class="d-flex justify-content-center">
        {{$comments->links('vendor.pagination.api', [
            'post' => $post,
            'token' => session()->get('_apiToken')
            ])}}
    </div>
@else
    <div class="text-center text-black-50">
        <h6>No comments yet.</h6>
    </div>
@endif