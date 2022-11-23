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

<div class="card border-0 p-2 shadow rounded-3 mb-3">
    <div class="card-header border-0 bg-transparent d-flex justify-content-between pb-0">
        <div class="d-flex flex-grow-1">
            <a href="{{url('')}}/profile/{{$post->user->id}}">
                <div class="post-user-photo rounded-circle border border-1 border-primary shadow-sm me-3"
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
            <form action="{{url('')}}/posts/{{$post->id}}" method="POST">
                @csrf
                @method('delete')
                <button class="btn btn-danger" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-trash-can" width="24" height="24" viewBox="0 0 24 24"><path d="M9,3V4H4V6H5V19A2,2 0 0,0 7,21H17A2,2 0 0,0 19,19V6H20V4H15V3H9M9,8H11V17H9V8M13,8H15V17H13V8Z" fill="currentColor" /></svg>
                </button>
            </form>
        @endif
    </div>
    <form action="{{url('')}}/posts/{{$post->id}}" method="POST">
        @csrf
        @method('put')
        
        <div class="card-body">
            <textarea class="form-control border-0 rounded-3 shadow-sm mb-3" style="resize: none;" name="description" placeholder="What's on your mind?" rows="3">{{$post->description}}</textarea>
            
            @if (!empty($post['image']))
                <img class="w-100 rounded-3 shadow-sm me-3"
                    src="{{asset('/storage/' . $post['image'])}}" alt="Post Image">
            @endif
        </div>
        <div class="card-footer border-0 bg-transparent">
            <div class="d-grid gap-2">
                <button class="btn btn-primary fs-5" type="submit">Save Changes</button>
            </div>
        </div>
    </form>
</div>
