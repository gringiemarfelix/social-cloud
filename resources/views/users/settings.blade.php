<x-layout>
    <div class="col-12 col-lg-8 bg-light rounded-3" style="z-index: 0!important;">
        <div class="p-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row gx-0 gx-lg-3" style="min-height: 85vh;">
                        <div class="col-12 col-lg-2 border-end">
                            <ul class="nav nav-pills nav-fill flex-row flex-lg-column flex-nowrap mb-3 mb-lg-0" style="overflow-x: scroll;">
                                @php
                                    $active = 'text-primary fw-bold';
                                    $item = 'text-black-50';
                                @endphp
                                <li class="nav-item">
                                    <a class="nav-link d-flex justify-content-center justify-content-lg-start align-items-center {{ (request()->is('settings')) || (request()->is('settings/profile')) ? $active : $item;}}"
                                        aria-current="page" href="{{url('')}}/settings/profile">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                                            id="mdi-account-outline" width="24" height="24" viewBox="0 0 24 24">
                                            <path
                                                d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,6A2,2 0 0,0 10,8A2,2 0 0,0 12,10A2,2 0 0,0 14,8A2,2 0 0,0 12,6M12,13C14.67,13 20,14.33 20,17V20H4V17C4,14.33 9.33,13 12,13M12,14.9C9.03,14.9 5.9,16.36 5.9,17V18.1H18.1V17C18.1,16.36 14.97,14.9 12,14.9Z"
                                                fill="currentColor" />
                                        </svg> <span class="ms-1 d-none d-lg-block">Edit Profile</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex justify-content-center justify-content-lg-start align-items-center {{ (request()->is('settings/notifications')) ? $active : $item;}}" href="{{url('')}}/settings/notifications">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                                            id="mdi-bell-outline" width="24" height="24" viewBox="0 0 24 24">
                                            <path
                                                d="M10 21H14C14 22.1 13.1 23 12 23S10 22.1 10 21M21 19V20H3V19L5 17V11C5 7.9 7 5.2 10 4.3V4C10 2.9 10.9 2 12 2S14 2.9 14 4V4.3C17 5.2 19 7.9 19 11V17L21 19M17 11C17 8.2 14.8 6 12 6S7 8.2 7 11V18H17V11Z"
                                                fill="currentColor"></path>
                                        </svg>
                                        <span class="ms-1 d-none d-lg-block">Notifications</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex justify-content-center justify-content-lg-start align-items-center {{ (request()->is('settings/security')) ? $active : $item;}}" href="{{url('')}}/settings/security">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                                            id="mdi-lock-outline" width="24" height="24" viewBox="0 0 24 24">
                                            <path
                                                d="M12,17C10.89,17 10,16.1 10,15C10,13.89 10.89,13 12,13A2,2 0 0,1 14,15A2,2 0 0,1 12,17M18,20V10H6V20H18M18,8A2,2 0 0,1 20,10V20A2,2 0 0,1 18,22H6C4.89,22 4,21.1 4,20V10C4,8.89 4.89,8 6,8H7V6A5,5 0 0,1 12,1A5,5 0 0,1 17,6V8H18M12,3A3,3 0 0,0 9,6V8H15V6A3,3 0 0,0 12,3Z"
                                                fill="currentColor" />
                                        </svg>
                                        <span class="ms-1 d-none d-lg-block">Security</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        @if ( request()->is('settings') || request()->is('settings/profile') )
                            <div class="col-12 col-lg-10">
                                @if (session()->has('message'))
                                    <div class="alert alert-primary shadow-sm alert-dismissible fade show" role="alert">
                                        {{session('message')}}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                @if ($errors->any())
                                    <div class="alert alert-primary shadow-sm alert-dismissible fade show">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                <h5>Edit Profile</h5>
                                <form class="d-inline-block position-relative" action="{{url('')}}/profile" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="profile-photo rounded-circle shadow-sm" style="background-image: url('{{asset('storage/'. $user->photo)}}');">
                                    </div>
                                    <div
                                        class="btn btn-light position-absolute bottom-0 end-0 shadow-sm p-2 rounded-circle"
                                        onclick="document.getElementById('profilePhotoSettings').click();">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-pencil-outline" width="24" height="24" viewBox="0 0 24 24"><path d="M14.06,9L15,9.94L5.92,19H5V18.08L14.06,9M17.66,3C17.41,3 17.15,3.1 16.96,3.29L15.13,5.12L18.88,8.87L20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18.17,3.09 17.92,3 17.66,3M14.06,6.19L3,17.25V21H6.75L17.81,9.94L14.06,6.19Z" fill="currentColor" /></svg>
                                        <input type="file" name="profilePhotoSettings" id="profilePhotoSettings" hidden="" onchange="form.submit();">
                                    </div>
                                </form>
                                <form class="row my-3" action="{{url('')}}/profile" method="POST">
                                    @csrf
                                    @method('put')
                                    <div class="col-12 col-lg-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label h6">First Name</label>
                                            <input type="text"
                                                class="form-control rounded-3 border border-opacity-10" name="first_name"
                                                id="" placeholder="Enter your first name" value="{{$user->first_name}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label h6">Middle Name</label>
                                            <input type="text"
                                                class="form-control rounded-3 border border-opacity-10" name="middle_name"
                                                id="" placeholder="Enter your middle name" value="{{$user->middle_name}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label h6">Last Name</label>
                                            <input type="text"
                                                class="form-control rounded-3 border border-opacity-10" name="last_name"
                                                id="" placeholder="Enter your last name" value="{{$user->last_name}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label h6">Phone Number</label>
                                            <input type="text"
                                                class="form-control rounded-3 border border-opacity-10" name="phone"
                                                id="" placeholder="Enter your phone number"  value="{{$user->phone}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label h6">Email</label>
                                            <input type="email"
                                                class="form-control rounded-3 border border-opacity-10" name="email"
                                                id="" placeholder="Enter your email"  value="{{$user->email}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label h6">Gender</label>
                                            <div
                                                class="d-flex align-items-center rounded-3 border border-opacity-10 p-2">
                                                <div class="form-check d-flex ms-1">
                                                    <input class="form-check-input" type="radio"
                                                        name="gender" id="male" value="male" {{$user->gender == 'male' ? 'checked' : null}}>
                                                    <label class="form-check-label ms-1"
                                                        for="male">
                                                        Male
                                                    </label>
                                                </div>
                                                <div class="form-check d-flex ms-3">
                                                    <input class="form-check-input" type="radio"
                                                        name="gender" id="female" value="female" {{$user->gender == 'female' ? 'checked' : null}}>
                                                    <label class="form-check-label ms-1"
                                                        for="female">
                                                        Female
                                                    </label>
                                                </div>
                                                <div class="form-check d-flex ms-3">
                                                    <input class="form-check-input" type="radio"
                                                        name="gender" id="unset" value="" {{$user->gender == '' ? 'checked' : null}}>
                                                    <label class="form-check-label ms-1"
                                                        for="unset">
                                                        Unset
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="mb-3">
                                            <label for="birthday" class="form-label h6">Birthday</label>
                                            <input type="date"
                                                class="form-control rounded-3 border border-opacity-10" name="birthday"
                                                id="birthday" value="{{$user->birthday}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="mb-3">
                                            <label for="location" class="form-label h6">Location</label>
                                            <input type="text"
                                                class="form-control rounded-3 border border-opacity-10" name="location"
                                                id="location" placeholder="Enter your location" value="{{$user->location}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="mb-3">
                                            <label for="website" class="form-label h6">Website</label>
                                            <input type="text"
                                                class="form-control rounded-3 border border-opacity-10" name="website"
                                                id="website" placeholder="Enter your website" value="{{$user->website}}">
                                        </div>
                                    </div>

                                    <h5 class="mt-3">Social Links</h5>

                                    <div class="col-12 col-lg-6">
                                        <div class="mb-3">
                                            <label for="facebook" class="form-label h6">Facebook</label>
                                            <input type="text"
                                                class="form-control rounded-3 border border-opacity-10" name="facebook"
                                                id="facebook" placeholder="Enter your Facebook handle" value="{{$user->facebook}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="mb-3">
                                            <label for="youtube" class="form-label h6">YouTube</label>
                                            <input type="text"
                                                class="form-control rounded-3 border border-opacity-10" name="youtube"
                                                id="youtube" placeholder="Enter your YouTube handle" value="{{$user->youtube}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="mb-3">
                                            <label for="twitter" class="form-label h6">Twitter</label>
                                            <input type="text"
                                                class="form-control rounded-3 border border-opacity-10" name="twitter"
                                                id="twitter" placeholder="Enter your Twitter handle" value="{{$user->twitter}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="mb-3">
                                            <label for="instagram" class="form-label h6">Instagram</label>
                                            <input type="text"
                                                class="form-control rounded-3 border border-opacity-10" name="instagram"
                                                id="instagram" placeholder="Enter your Instagram handle" value="{{$user->instagram}}">
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary rounded-3">Save</button>
                                    </div>
                                </form>
                            </div>
                        @elseif(request()->is('settings/notifications'))
                            <div class="col-12 col-lg-10">
                                @if (session()->has('message'))
                                    <div class="alert alert-primary shadow-sm alert-dismissible fade show" role="alert">
                                        {{session('message')}}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                <h5>Notifications</h5>
                                <form action="{{url('')}}/profile" method="POST">
                                    @csrf
                                    @method('put')
                                    <ul class="list-group list-group-flush mb-3">
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between">
                                                <span>Notify me about new posts</span>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        name="posts" {{$settingsNotifications->posts == 'on' ? 'checked' : null }}>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between">
                                                <span>Notify me when someones likes my posts</span>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        name="likes" {{$settingsNotifications->likes == 'on' ? 'checked' : null }}>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between">
                                                <span>Notify me when someones comments on my posts</span>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        name="comments" {{$settingsNotifications->comments == 'on' ? 'checked' : null }}>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between">
                                                <span>Notify me when someones shares on my posts</span>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        name="shares" {{$settingsNotifications->shares == 'on' ? 'checked' : null }}>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        @elseif(request()->is('settings/security'))
                            <div class="col-12 col-lg-10">
                                @if (session()->has('message'))
                                    <div class="alert alert-primary shadow-sm alert-dismissible fade show" role="alert">
                                        {!! session('message') !!}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                @if (session('status') == 'two-factor-authentication-enabled')
                                    <div class="alert alert-primary shadow-sm alert-dismissible fade show" role="alert">
                                        Please finish configuring two factor authentication below.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                @if (session('status') == 'two-factor-authentication-confirmed')
                                    <div class="alert alert-primary shadow-sm alert-dismissible fade show" role="alert">
                                        Two factor authentication confirmed and enabled successfully.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                @if ($errors->any())
                                    <div class="alert alert-primary shadow-sm alert-dismissible fade show">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                <h5>Security</h5>
                                <h6 class="mt-3">Change Password</h6>
                                <form class="row" action="{{url('')}}/profile" method="POST">
                                    @csrf
                                    @method('put')
                                    <div class="col-12 col-lg-6 mb-3">
                                        <label for="" class="form-label">Current Password</label>
                                        <input type="password" class="form-control" name="current_password" id="">
                                    </div>
                                    <div class="col-12 col-lg-6"></div>
                                    <div class="col-12 col-lg-6 mb-3">
                                        <label for="" class="form-label">New Password</label>
                                        <input type="password" class="form-control" name="new_password" id="">
                                    </div>
                                    <div class="col-12 col-lg-6"></div>
                                    <div class="col-12 col-lg-6 mb-3">
                                        <label for="" class="form-label">Confirm New Password</label>
                                        <input type="password" class="form-control" name="new_password_confirmation" id="">
                                    </div>
                                    <div class="col-12 col-lg-6"></div>
                                    <div class="col-12 col-lg-6 text-end">
                                        <button type="submit" class="btn btn-primary rounded-3">Save</button>
                                    </div>
                                </form>

                                <h6 class="mt-3">Two-Factor Authentication</h6>
                                @if (auth()->user()->two_factor_confirmed_at)
                                    <div class="row">
                                        <div class="col-12 col-lg-6 mb-3">
                                            <p>Two factor authentication is now enabled. Scan the QR code below using your phone's authenticator application.</p>
                                            {!! auth()->user()->twoFactorQrCodeSvg() !!}
                                        </div>
                                        <div class="col-12 col-lg-6 mb-3"></div>
                                        <div class="col-12 col-lg-6 mb-3">
                                            <h6>Recovery Codes</h6>
                                            <p>Store these recovery codes in a secure password manager or print it out. These recovery codes can be used to recover your access to your account in the event that you lost the two factor authentication device.</p>
                                            <div class="card bg-secondary border-0 shadow-sm rounded-3">
                                                <div class="card-body">
                                                    <ul class="list-unstyled mb-0">
                                                        @foreach (auth()->user()->recoveryCodes() as $code)
                                                            <li>
                                                                {{$code}}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 mb-3"></div>
                                        <div class="col-12 col-lg-6 mb-3 d-flex">
                                            <form action="{{url('')}}/user/two-factor-recovery-codes" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary rounded-3">Regenerate Codes</button>
                                            </form>
                                            <form class="ms-3" action="{{ route('two-factor.disable') }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn rounded-3">Disable 2FA</button>
                                            </form>
                                        </div>
                                    </div>
                                @elseif(auth()->user()->two_factor_secret)
                                    <p>Validate 2FA by scanning the QR Code and entering the OTP.</p>
                                    {!! auth()->user()->twoFactorQrCodeSvg() !!}
                                    <form class="row mt-3" action="{{ route('two-factor.confirm') }}" method="POST">
                                        @csrf
                                        <div class="col-12 col-lg-6 mb-3">
                                            <label for="code" class="form-label">Authentication Code</label>
                                            <input type="text" class="form-control" name="code" id="code">
                                        </div>
                                        <div class="col-12 col-lg-6"></div>
                                        <div class="col-12 col-lg-6">
                                            <button type="submit" class="btn btn-primary rounded-3">Confirm 2FA</button>
                                        </div>
                                    </form>
                                @else
                                    <form class="row" action="{{ route('two-factor.enable') }}" method="POST">
                                        @csrf
                                        <div class="col-12 col-lg-6 mb-3">
                                            <button type="submit" class="btn btn-primary rounded-3">Enable 2FA</button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>