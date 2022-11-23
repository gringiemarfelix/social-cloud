<x-layout>
    <div class="col-12 col-lg-8 bg-light rounded-3" style="z-index: 0!important;">
        <div class="post-container mx-auto">
            @if (session()->has('message'))
                <div class="alert alert-primary shadow-sm alert-dismissible fade show my-3" role="alert">
                    {{session('message')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="my-4">
                @include('partials._create-post')
            </div>

            <h5>Recent Posts</h5>
            @if (count($posts))
                @foreach ($posts as $post)
                    <x-post :post="$post" />
                @endforeach
            @else
                <div class="text-center text-black-50 mt-3">
                    <p class="h5">No posts found.</p>
                    <p class="h5">Add your friends now to view posts!</p>
                </div>
            @endif
            <div class="d-flex justify-content-center mt-4">
                {{$posts->links('vendor.pagination.custom')}}
            </div>
        </div>
    </div>
    
    @include('partials._comments-modal')
    @include('partials._share-modal')
</x-layout>
