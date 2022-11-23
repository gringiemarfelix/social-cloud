<x-layout>
    <div class="col-12 col-lg-8 bg-light rounded-3" style="z-index: 0!important;">
        <div class="p-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <h5>Notifications</h5>
                </div>
                <div class="card-body">
                    @if (count($notifications))
                        @foreach ($notifications as $notification)
                            <x-notification :notification="$notification"/>
                        @endforeach
                        <div class="d-flex justify-content-center mt-4">
                            {{$notifications->withQueryString()->links('vendor.pagination.custom')}}
                        </div>
                    @else
                        <h6 class="text-black-50 text-center">No notifications found.</h6>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout>