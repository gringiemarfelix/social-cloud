<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use App\Actions\Fortify\UpdateUserProfileInformation;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);    
        
        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });

        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password');
        });    
        
        Fortify::resetPasswordView(function ($request) {
            return view('auth.reset-password', ['request' => $request]);
        });

        Fortify::confirmPasswordView(function () {
            return view('auth.confirm-password');
        });    
        
        Fortify::twoFactorChallengeView(function () {
            return view('auth.two-factor-challenge');
        });
        
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            $key = $email.$request->ip();
            $decay = 60;

            if(RateLimiter::remaining($key, $perMinute = 5) > 1){
                RateLimiter::hit($key);
                $attempts = RateLimiter::retriesLeft($key, 5);
                if(!auth()->check()){
                    session()->flash('attempts', "You have $attempts attempts left.");
                }
            }else{
                $avail = RateLimiter::availableIn($key) . 's';
                session()->flash('message', "Too much login attempts. Please wait $avail and try again.");
                return back()->withInput();
            }
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();
     
            if($user && Hash::check($request->password, $user->password)){
                $token = $user->createToken('auth_token')->plainTextToken;
                session(['_apiToken' => $token]);
                return $user;
            }
        });
    }
}
