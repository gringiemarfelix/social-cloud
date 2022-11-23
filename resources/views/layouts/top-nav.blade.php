<nav class="bg-white shadow-sm py-2 container-fluid border-bottom border-3 border-primary position-sticky top-0"
    style="z-index: 2000!important;">
    <div class="row gx-0">
        <div class="col-2 d-none d-lg-block">
            <div class="d-flex align-items-center">
                <a class="navbar-brand fw-bold d-flex align-items-center" href="{{url('')}}/">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                        id="mdi-account-supervisor-circle" width="32" height="32" viewBox="0 0 24 24">
                        <path
                            d="M12,2C6.47,2 2,6.5 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M15.6,8.34C16.67,8.34 17.53,9.2 17.53,10.27C17.53,11.34 16.67,12.2 15.6,12.2A1.93,1.93 0 0,1 13.67,10.27C13.66,9.2 14.53,8.34 15.6,8.34M9.6,6.76C10.9,6.76 11.96,7.82 11.96,9.12C11.96,10.42 10.9,11.5 9.6,11.5C8.3,11.5 7.24,10.42 7.24,9.12C7.24,7.81 8.29,6.76 9.6,6.76M9.6,15.89V19.64C7.2,18.89 5.3,17.04 4.46,14.68C5.5,13.56 8.13,13 9.6,13C10.13,13 10.8,13.07 11.5,13.21C9.86,14.08 9.6,15.23 9.6,15.89M12,20C11.72,20 11.46,20 11.2,19.96V15.89C11.2,14.47 14.14,13.76 15.6,13.76C16.67,13.76 18.5,14.15 19.44,14.91C18.27,17.88 15.38,20 12,20Z"
                            fill="currentColor" />
                    </svg>
                    <span class="ms-1">SocialCloud</span>
                </a>
            </div>
        </div>
        <div class="col-3 d-none align-items-center d-lg-flex">
            <form class="w-100" action="{{url('')}}/search" method="GET">
                <div class="position-relative text-muted">
                    <input type="text" class="form-control border-secondary"
                        placeholder="Search for something here..." name="search">
                    <span style="position: absolute; top: 6px; right: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            version="1.1" id="mdi-magnify" width="24" height="24" viewBox="0 0 24 24">
                            <path
                                d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z"
                                fill="currentColor" />
                        </svg>
                    </span>
                </div>
            </form>
        </div>
        {{-- Mobile --}}
        <div class="col-5 d-lg-none">
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-menu" width="24" height="24" viewBox="0 0 24 24"><path d="M3,6H21V8H3V6M3,11H21V13H3V11M3,16H21V18H3V16Z" fill="currentColor" /></svg>
            </button>              
        </div>
        <div class="col-7 d-flex justify-content-end pe-lg-5">
            <ul class="nav">
                <li class="nav-item ps-3 d-flex align-items-center">
                    @if (!empty(auth()->user()->middle_name))
                        <span class="h6 mb-0 me-2">{{auth()->user()->first_name}} {{substr(auth()->user()->middle_name, 0, 1)}}. {{auth()->user()->last_name}}</span>
                    @else
                        <span class="h6 mb-0 me-2">{{auth()->user()->first_name}} {{auth()->user()->last_name}}</span>
                    @endif
                    <div class="nav-user-photo rounded-circle shadow-sm"
                        style="background-image: url('{{asset('storage/' . auth()->user()->photo)}}')"></div>
                </li>
            </ul>
        </div>
    </div>
</nav>