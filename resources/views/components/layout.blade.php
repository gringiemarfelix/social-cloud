@include('layouts.header')
    @include('layouts.top-nav')
    <main class="container-fluid px-0 px-lg-3">
        <div class="row gx-0 gx-lg-4">
            @include('layouts.left-nav')

            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-body">  
                    <ul class="nav flex-column mt-3 mx-1 position-sticky" style="top: 77px;">
                        <li class="nav-item ">
                            <form class="w-100" action="{{url('')}}/search" method="GET">
                                <div class="position-relative text-muted">
                                    <input type="text" class="form-control border-secondary py-2"
                                        placeholder="Search for something here..." name="search">
                                    <span style="position: absolute; top: 8px; right: 8px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            version="1.1" id="mdi-magnify" width="24" height="24" viewBox="0 0 24 24">
                                            <path
                                                d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                </div>
                            </form>
                        </li>
                        <hr>
                        <li class="nav-item">
                            @php
                                $active = 'text-light d-flex align-items-center bg-primary rounded-3';
                                $item = 'text-black-50 d-flex align-items-center';
                            @endphp
                            <a class="nav-link py-3 {{ (request()->is('')) || (request()->is('feed')) ? $active : $item;}}" href="{{url('')}}/">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    version="1.1" id="mdi-post-outline" width="24" height="24" viewBox="0 0 24 24">
                                    <path
                                        d="M19 5V19H5V5H19M21 3H3V21H21V3M17 17H7V16H17V17M17 15H7V14H17V15M17 12H7V7H17V12Z"
                                        fill="currentColor" />
                                </svg>
                                <span class="h6 mb-0 ms-2">Feed</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-3 {{ (request()->is('notifications')) ? $active : $item }}" href="{{url('')}}/notifications">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    version="1.1" id="mdi-bell-outline" width="24" height="24" viewBox="0 0 24 24">
                                    <path
                                        d="M10 21H14C14 22.1 13.1 23 12 23S10 22.1 10 21M21 19V20H3V19L5 17V11C5 7.9 7 5.2 10 4.3V4C10 2.9 10.9 2 12 2S14 2.9 14 4V4.3C17 5.2 19 7.9 19 11V17L21 19M17 11C17 8.2 14.8 6 12 6S7 8.2 7 11V18H17V11Z"
                                        fill="currentColor" />
                                </svg>
                                @php
                                    $unread = auth()->user()->unreadNotifications()->count();
                                    $badge = null;
                                    if($unread){
                                        $badge = "<span class=\"ms-1 badge rounded-circle bg-secondary text-danger\" id=\"notification\">$unread</span>";
                                    }
                                @endphp
                                <span class="h6 mb-0 ms-2">Notifications {!! $badge !!}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-3 {{ (request()->is('friends*')) ? $active : $item }}" href="{{url('')}}/friends">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    version="1.1" id="mdi-account-group-outline" width="24" height="24" viewBox="0 0 24 24">
                                    <path
                                        d="M12,5A3.5,3.5 0 0,0 8.5,8.5A3.5,3.5 0 0,0 12,12A3.5,3.5 0 0,0 15.5,8.5A3.5,3.5 0 0,0 12,5M12,7A1.5,1.5 0 0,1 13.5,8.5A1.5,1.5 0 0,1 12,10A1.5,1.5 0 0,1 10.5,8.5A1.5,1.5 0 0,1 12,7M5.5,8A2.5,2.5 0 0,0 3,10.5C3,11.44 3.53,12.25 4.29,12.68C4.65,12.88 5.06,13 5.5,13C5.94,13 6.35,12.88 6.71,12.68C7.08,12.47 7.39,12.17 7.62,11.81C6.89,10.86 6.5,9.7 6.5,8.5C6.5,8.41 6.5,8.31 6.5,8.22C6.2,8.08 5.86,8 5.5,8M18.5,8C18.14,8 17.8,8.08 17.5,8.22C17.5,8.31 17.5,8.41 17.5,8.5C17.5,9.7 17.11,10.86 16.38,11.81C16.5,12 16.63,12.15 16.78,12.3C16.94,12.45 17.1,12.58 17.29,12.68C17.65,12.88 18.06,13 18.5,13C18.94,13 19.35,12.88 19.71,12.68C20.47,12.25 21,11.44 21,10.5A2.5,2.5 0 0,0 18.5,8M12,14C9.66,14 5,15.17 5,17.5V19H19V17.5C19,15.17 14.34,14 12,14M4.71,14.55C2.78,14.78 0,15.76 0,17.5V19H3V17.07C3,16.06 3.69,15.22 4.71,14.55M19.29,14.55C20.31,15.22 21,16.06 21,17.07V19H24V17.5C24,15.76 21.22,14.78 19.29,14.55M12,16C13.53,16 15.24,16.5 16.23,17H7.77C8.76,16.5 10.47,16 12,16Z"
                                        fill="currentColor" />
                                </svg>
                                <span class="h6 mb-0 ms-2">Friends</span>
                            </a>
                        </li>
                        <li class="nav-item d-none">
                            <a class="nav-link py-3 text-black-50 d-flex align-items-center" href="{{url('')}}/notifications">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    version="1.1" id="mdi-chat-processing-outline" width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M12 3C6.5 3 2 6.58 2 11C2.05 13.15 3.06 15.17 4.75 16.5C4.75 17.1 4.33 18.67 2 21C4.37 20.89 6.64 20 8.47 18.5C9.61 18.83 10.81 19 12 19C17.5 19 22 15.42 22 11S17.5 3 12 3M12 17C7.58 17 4 14.31 4 11S7.58 5 12 5 20 7.69 20 11 16.42 17 12 17M17 12V10H15V12H17M13 12V10H11V12H13M9 12V10H7V12H9Z"
                                        fill="currentColor" />
                                </svg>
                                <span class="h6 mb-0 ms-2">Messages</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-3 {{ (request()->is('profile')) ? $active : $item }}" href="{{url('')}}/profile">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    version="1.1" id="mdi-account-circle-outline" width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M7.07,18.28C7.5,17.38 10.12,16.5 12,16.5C13.88,16.5 16.5,17.38 16.93,18.28C15.57,19.36 13.86,20 12,20C10.14,20 8.43,19.36 7.07,18.28M18.36,16.83C16.93,15.09 13.46,14.5 12,14.5C10.54,14.5 7.07,15.09 5.64,16.83C4.62,15.5 4,13.82 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,13.82 19.38,15.5 18.36,16.83M12,6C10.06,6 8.5,7.56 8.5,9.5C8.5,11.44 10.06,13 12,13C13.94,13 15.5,11.44 15.5,9.5C15.5,7.56 13.94,6 12,6M12,11A1.5,1.5 0 0,1 10.5,9.5A1.5,1.5 0 0,1 12,8A1.5,1.5 0 0,1 13.5,9.5A1.5,1.5 0 0,1 12,11Z"
                                        fill="currentColor" />
                                </svg>
                                <span class="h6 mb-0 ms-2">Profile</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-3 {{ (request()->is('settings*')) ? $active : $item }}" href="{{url('')}}/settings">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    version="1.1" id="mdi-cog-outline" width="24" height="24" viewBox="0 0 24 24">
                                    <path
                                        d="M12,8A4,4 0 0,1 16,12A4,4 0 0,1 12,16A4,4 0 0,1 8,12A4,4 0 0,1 12,8M12,10A2,2 0 0,0 10,12A2,2 0 0,0 12,14A2,2 0 0,0 14,12A2,2 0 0,0 12,10M10,22C9.75,22 9.54,21.82 9.5,21.58L9.13,18.93C8.5,18.68 7.96,18.34 7.44,17.94L4.95,18.95C4.73,19.03 4.46,18.95 4.34,18.73L2.34,15.27C2.21,15.05 2.27,14.78 2.46,14.63L4.57,12.97L4.5,12L4.57,11L2.46,9.37C2.27,9.22 2.21,8.95 2.34,8.73L4.34,5.27C4.46,5.05 4.73,4.96 4.95,5.05L7.44,6.05C7.96,5.66 8.5,5.32 9.13,5.07L9.5,2.42C9.54,2.18 9.75,2 10,2H14C14.25,2 14.46,2.18 14.5,2.42L14.87,5.07C15.5,5.32 16.04,5.66 16.56,6.05L19.05,5.05C19.27,4.96 19.54,5.05 19.66,5.27L21.66,8.73C21.79,8.95 21.73,9.22 21.54,9.37L19.43,11L19.5,12L19.43,13L21.54,14.63C21.73,14.78 21.79,15.05 21.66,15.27L19.66,18.73C19.54,18.95 19.27,19.04 19.05,18.95L16.56,17.95C16.04,18.34 15.5,18.68 14.87,18.93L14.5,21.58C14.46,21.82 14.25,22 14,22H10M11.25,4L10.88,6.61C9.68,6.86 8.62,7.5 7.85,8.39L5.44,7.35L4.69,8.65L6.8,10.2C6.4,11.37 6.4,12.64 6.8,13.8L4.68,15.36L5.43,16.66L7.86,15.62C8.63,16.5 9.68,17.14 10.87,17.38L11.24,20H12.76L13.13,17.39C14.32,17.14 15.37,16.5 16.14,15.62L18.57,16.66L19.32,15.36L17.2,13.81C17.6,12.64 17.6,11.37 17.2,10.2L19.31,8.65L18.56,7.35L16.15,8.39C15.38,7.5 14.32,6.86 13.12,6.62L12.75,4H11.25Z"
                                        fill="currentColor" />
                                </svg>
                                <span class="h6 mb-0 ms-2">Settings</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <form action="{{url('')}}/logout" method="post" id="logout-form">
                                @csrf
                                <div class="nav-link py-3 text-black-50 d-flex align-items-center" role="button" onclick="document.getElementById('logout-form').submit();">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        version="1.1" id="mdi-logout" width="24" height="24" viewBox="0 0 24 24">
                                        <path
                                            d="M16,17V14H9V10H16V7L21,12L16,17M14,2A2,2 0 0,1 16,4V6H14V4H5V20H14V18H16V20A2,2 0 0,1 14,22H5A2,2 0 0,1 3,20V4A2,2 0 0,1 5,2H14Z"
                                            fill="currentColor" />
                                    </svg>
                                    <span class="h6 mb-0 ms-2">Logout</span>
                                </div>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            {{$slot}}

            @include('layouts.right-nav')
        </div>
    </main>
@include('layouts.footer')