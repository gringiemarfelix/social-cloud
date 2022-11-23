<div class="card border-0 shadow rounded-3 mb-4">
    <form action="{{url('')}}/posts" method="POST" enctype="multipart/form-data" class="card-body">
        @csrf
        <div class="d-flex align-items-center mb-3">
            <div class="rounded-circle shadow-sm post-form-photo"
                style="background-image: url('{{asset('storage/' . auth()->user()->photo)}}')"></div>
            <textarea class="form-control border-0 rounded-3 shadow-sm ms-3"
                style="resize: none;" name="description" placeholder="What's on your mind?"
                rows="2"></textarea>
        </div>

        <div class="d-flex justify-content-between">
            <div>
                <div class="btn btn-sm text-black-50 d-flex align-items-center" role="button"
                    onclick="document.getElementById('photo').click();">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                        id="mdi-image-outline" width="24" height="24" viewBox="0 0 24 24">
                        <path
                            d="M19,19H5V5H19M19,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3M13.96,12.29L11.21,15.83L9.25,13.47L6.5,17H17.5L13.96,12.29Z"
                            fill="currentColor" />
                    </svg>
                    <span class="ms-1">Photo/Video</span>
                </div>
                <input type="file" name="photo" id="photo" hidden>
            </div>
            <button class="btn btn-primary text-uppercase" type="submit">Post</button>
        </div>
    </form>
</div>