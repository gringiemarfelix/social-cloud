@include('layouts.header')
    <main class="d-flex align-items-center" style="min-height: 100vh;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center text-center mb-3 mb-lg-0">
                    <div class="text-center">
                        <div class="d-flex justify-content-center align-items-center text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                                id="mdi-account-supervisor-circle" width="64" height="64" viewBox="0 0 24 24">
                                <path
                                    d="M12,2C6.47,2 2,6.5 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M15.6,8.34C16.67,8.34 17.53,9.2 17.53,10.27C17.53,11.34 16.67,12.2 15.6,12.2A1.93,1.93 0 0,1 13.67,10.27C13.66,9.2 14.53,8.34 15.6,8.34M9.6,6.76C10.9,6.76 11.96,7.82 11.96,9.12C11.96,10.42 10.9,11.5 9.6,11.5C8.3,11.5 7.24,10.42 7.24,9.12C7.24,7.81 8.29,6.76 9.6,6.76M9.6,15.89V19.64C7.2,18.89 5.3,17.04 4.46,14.68C5.5,13.56 8.13,13 9.6,13C10.13,13 10.8,13.07 11.5,13.21C9.86,14.08 9.6,15.23 9.6,15.89M12,20C11.72,20 11.46,20 11.2,19.96V15.89C11.2,14.47 14.14,13.76 15.6,13.76C16.67,13.76 18.5,14.15 19.44,14.91C18.27,17.88 15.38,20 12,20Z"
                                    fill="currentColor"></path>
                            </svg>
                            <span class="h1 display-4 fw-bold mb-0">
                                SocialCloud
                            </span>
                        </div>
                        <p class="h4 lead mb-0">
                            Socialize with your friends in the cloud.
                        </p>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card rounded-3 border-0 shadow">
                        <form action="{{url('')}}/forgot-password" method="POST" class="card-body">
                            @if (session()->has('message'))
                                <div class="alert alert-primary shadow-sm alert-dismissible fade show" role="alert">
                                    {{session('message')}}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            @if (session('status'))
                                <div class="alert alert-primary shadow-sm alert-dismissible fade show" role="alert">
                                    {{session('status')}}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control rounded-3 border border-opacity-10" name="email"
                                    id="email" value="{{old('email')}}">
                                @error('email')
                                    <small class="form-text text-danger text-opacity-75">{{$message}}</small>
                                @enderror
                            </div>
                            <hr>
                            <div class="mb-3">
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary rounded-3 fs-5 fw-bold" type="submit">Send Password Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@include('layouts.footer')