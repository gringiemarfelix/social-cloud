<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\LastVisit;
use App\Models\Friendship;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use App\Models\SettingsNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller{
    // Show Register Form
    public function create(){
        return view('users.register');
    }

    // Store User Data
    public function store(Request $request){
        $formFields = $request->validate([
            'first_name' => ['required', 'min:2'],
            'last_name' => ['required', 'min:2'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', Password::min(8)->mixedCase()->numbers()],
        ]);

        // Hash Password
        $formFields['password'] = bcrypt($formFields['password']);

        // Create User
        $formFields['photo'] = 'users/default.svg';
        $user = User::create($formFields);

        // Log In
        Auth::login($user);
        SettingsNotification::create([
            'user_id' => $user->id,
        ]);

        // Send Verification Email
        dd(auth()->user()->sendEmailVerificationNotification());

        return redirect('/');
    }

    // Show Login Form
    public function login(){
        return view('users.login');
    }

    // Log User In
    public function authenticate(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Create API Token
            $user = User::where('email', $request->input('email'))->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;
            session(['_apiToken' => $token]);
 
            return redirect()->to('/');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Log User Out
    public function logout(Request $request){    
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect('/')->with('message', 'Logged out successfully.');
    }

    // Profile
    public function profile(User $user){
        if(!$user->id){
            $user = auth()->user();
            $posts = auth()->user()->posts()->latest()->paginate(10);
            $friends = auth()->user()->friends;
            $isFriend = null;
        }else{
            $posts = $user->posts()->latest()->paginate(10);
            $friends = $user->friends;
            $isFriend = Friendship::findRecord(auth()->id(), $user->id);
            
            if($isFriend){
                $isFriend = $isFriend->status == 'pending' && auth()->id() == $isFriend->acted_user ? 'requested' : $isFriend->status;
            }
        }

        return view('users.profile', [
            'user' => $user,
            'friends' => $friends->slice(0, 6),
            'posts' => $posts,
            'isFriend' => $isFriend
        ]);
    }

    public function profileFriends(User $user){
        $isFriend = Friendship::findRecord(auth()->id(), $user->id);
        
        if($isFriend){
            $isFriend = $isFriend->status;
        }

        $friends = $user->friends->pluck('id')->toArray();
        $friends = User::whereIn('id', $friends)->paginate(16);

        return view('users.profile-friends', [
            'user' => $user,
            'friends' => $friends,
            'isFriend' => $isFriend
        ]);
    }

    public function settings(){
        return view('users.settings', [
            'user' => auth()->user()
        ]);
    }

    public function settingsNotifications(){
        return view('users.settings', [
            'settingsNotifications' => auth()->user()->settingsNotifications()->first()
        ]);
    }

    public function settingsSecurity(Request $request){
        return view('users.settings');
    }

    public function update(Request $request){
        $formFields = [];

        // Profile Page
        if($request->hasFile('profilePhoto')){
            $validate = Validator::make($request->all(), [
                'profilePhoto' => 'image|mimes:jpeg,png,jpg|max:5120',
            ]);

            if($validate->fails()){
                $page = 'profile';
                $message = $validate->errors()->toArray();
                $message = $message['profilePhoto'][0];
            }else{
                $formFields['photo'] = $request->file('profilePhoto')->store('users', 'public');
                $page = 'profile';
                $message = 'Profile photo updated successfully.';
            }
        }

        if($request->hasFile('coverPhoto')){
            $validate = Validator::make($request->all(), [
                'coverPhoto' => 'image|mimes:jpeg,png,jpg|max:5120',
            ]);

            if($validate->fails()){
                $page = 'profile';
                $message = $validate->errors()->toArray();
                $message = $message['coverPhoto'][0];
            }else{
                $formFields['cover'] = $request->file('coverPhoto')->store('covers', 'public');
                $page = 'profile';
                $message = 'Cover photo updated successfully.';
            }
        }

        // Settings Page
        if($request->hasFile('profilePhotoSettings')){
            $validate = Validator::make($request->all(), [
                'profilePhotoSettings' => 'image|mimes:jpeg,png,jpg|max:5120',
            ], ['mimes' => 'The profile photo must be a file of type: jpeg, png, jpg.']);

            if($validate->fails()){
                $page = 'settings';
                $message = $validate->errors()->toArray();
                $message = $message['profilePhotoSettings'][0];
            }else{
                $formFields['photo'] = $request->file('profilePhotoSettings')->store('users', 'public');
                $page = 'settings';
                $message = 'Profile photo updated successfully.';
            }
        }

        if($request->input('last_name')){
            $formFields = $request->validate([
                'first_name' => 'required|min:2',
                'middle_name' => 'nullable|min:2',
                'last_name' => 'required|min:2',
                'phone' => 'nullable|digits:11',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore(auth()->id())
                ],
                'gender' => 'nullable',
                'birthday' => 'nullable|date',
                'location' => 'nullable',
                'website' => 'nullable|url',

                'facebook' => 'nullable',
                'youtube' => 'nullable',
                'twitter' => 'nullable',
                'instagram' => 'nullable'
            ]);

            $page = 'settings/profile';
            $message = 'Profile updated successfully.';
        }
        
        // Settings Notifications
        if($request->header('referer') == url('settings/notifications')){
            $formFields = [
                'posts' => $request->posts == null ? 'off' : 'on',
                'likes' => $request->likes == null ? 'off' : 'on',
                'comments' => $request->comments == null ? 'off' : 'on',
                'shares' => $request->shares == null ? 'off' : 'on',
            ];
    
            if(auth()->user()->settingsNotifications()->get()->count()){
                SettingsNotification::where('user_id', auth()->id())->update($formFields);
            }else{
                $formFields['user_id'] = auth()->id();
                SettingsNotification::create($formFields);
            }

            $page = 'settings/notifications';
            $message = 'Notification settings updated.';

            return redirect($page)->with('message', $message);
        }

        // Settings Password
        if($request->header('referer') == url('settings/security')){
            if(!Hash::check($request->input('current_password'), Auth::user()->password)){
                return back()->with('message', '<ul class="mb-0"><li>Your current password does not matches with the password.</li></ul>');
            }

            if(strcmp($request->input('current_password'), $request->input('new_password')) == 0){
                return back()->with('message', '<ul class="mb-0"><li>New Password cannot be same as your current password.</li></ul>');
            }

            $formFields = $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|confirmed|min:8'
            ]);

            $formFields = [];
            $formFields['password'] = bcrypt($request->input('new_password'));

            $page = 'settings/security';
            $message = 'Password changed successfully.';
        }

        $user = auth()->user();
        $user->update($formFields);

        return redirect($page)->with('message', $message);
    }
}