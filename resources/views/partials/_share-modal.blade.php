    <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down mt-4 mt-lg-0 py-5 pt-lg-0 p-3 p-lg-0">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="shareModalLabel">Share Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- <a href="#"
                        class="text-decoration-none text-body d-flex justify-content-between align-items-center mb-3 d-none">
                        <div class="d-flex align-items-center">
                            <div class="share-photo rounded-circle border border-1 border-primary shadow-sm me-2" style="background-image: url('{{asset('storage/' . auth()->user()->photo)}}');"></div>
                            <p class="mb-0">Jane Doe</p>
                        </div>
                    </a> --}}

                    <form action="{{url('')}}/posts/share" method="POST">
                        @csrf
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle shadow-sm comment-user-photo me-3" style="background-image: url('{{asset('storage/' . auth()->user()->photo)}}');"></div>
                            <textarea class="form-control border-0 rounded-3 shadow-sm" style="resize: none;"
                                name="description" placeholder="Enter a caption..." rows="2"></textarea>
                            <input type="hidden" name="post_id" id="sharePost">
                        </div>
                        <div id="shareContainer">
                        </div>
                        <button class="btn btn-primary w-100 py-3">
                            Share
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>