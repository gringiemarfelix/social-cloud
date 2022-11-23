    <div class="modal fade" id="commentsModal" tabindex="-1" aria-labelledby="commentsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down mt-4 mt-lg-0 py-5 pt-lg-0 p-3 p-lg-0">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="commentsModalLabel">Comments</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="commentsContainer">
                </div>
                <div class="modal-footer d-flex justify-content-center border-0 pb-3">
                    <form action="{{url('')}}/api/comments/submit" method="POST" onsubmit="submitComment(this)" id="commentForm" data-token="{{session()->get('_apiToken')}}">
                        <div class="d-flex align-items-center" style="height: 4.5rem">
                            <div class="rounded-circle border border-1 border-primary shadow-sm comment-user-photo me-3" style="background-image: url('{{asset('storage/' . auth()->user()->photo)}}')"></div>
                            <textarea class="form-control border-0 rounded-3 shadow-sm h-100" style="resize: none;"
                                name="comment" placeholder="Type your comment here..." id="comment"></textarea>
                            <button class="btn btn-primary text-uppercase h-100">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    version="1.1" id="mdi-send-circle-outline" width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M8,7.71L18,12L8,16.29V12.95L15.14,12L8,11.05V7.71M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4Z"
                                        fill="currentColor" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>