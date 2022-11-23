<x-layout>
    <div class="col-12 col-lg-8 bg-light rounded-3" style="z-index: 0!important;">
        <div class="post-container mx-auto">
            <div class="my-5">
                @include('partials._edit-post', ['post' => $post]);
            </div>
        </div>
    </div>
</x-layout>