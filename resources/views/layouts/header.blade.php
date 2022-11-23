<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{asset('/img/social-cloud.png')}}" type="image/gif">

    <link rel="stylesheet" href="{{asset('/css/main.css')}}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">

    @php
        $title = 'SocialCloud';
        if(request()->is('/')){
            $title .= ' - Login';
        }else if(request()->is('register')){
            $title .= ' - Create Account';
        }else if(request()->is('feed')){
            $title .= ' - Feed';
        }else if(request()->is('notifications')){
            $title .= ' - Notifications';
        }else if(request()->is('friends')){
            $title .= ' - Friends';
        }else if(request()->is('friends/pending')){
            $title .= ' - Sent Requests';
        }else if(request()->is('friends/requests')){
            $title .= ' - Friend Requests';
        }else if(request()->is('profile')){
            $title .= ' - Profile';
        }else if(request()->is('profile/*')){
            $title .= ' - ' . $user->first_name . ' ' . $user->last_name;
        }else if(request()->is('settings')){
            $title .= ' - Edit Profile';
        }else if(request()->is('settings/notifications')){
            $title .= ' - Notification Settings';
        }else if(request()->is('settings/security')){
            $title .= ' - Security Settings';
        }else if(request()->is('search')){
            $title .= ' - Search';
        }
    @endphp

    <title>{{$title}}</title>
</head>

<body>