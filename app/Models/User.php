<?php

namespace App\Models;

use App\Models\Post;
use App\Models\Notification;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts(){
        return $this->hasMany(Post::class, 'user_id');
    }
    
    public function notifications(){
        return $this->hasMany(Notification::class, 'user_id');
    }
    
    public function unreadNotifications(){
        return $this->hasMany(Notification::class, 'user_id')->where('status', 'unread');
    }

    public function settingsNotifications(){
        return $this->hasOne(SettingsNotification::class, 'user_id');
    }

    public function lastVisit($friend_id){
        $lastVisit = LastVisit::where('visitor_id', auth()->id())->where('user_id', $friend_id)->first();
    
        if($lastVisit == null){
            $lastVisit = LastVisit::create([
                'user_id' => $friend_id,
                'visitor_id' => auth()->id()
            ]);
        }

        return $lastVisit->updated_at;
    }

    public function updateLastVisit($friend_id){
        $lastVisit = LastVisit::where('visitor_id', auth()->id())->where('user_id', $friend_id)->first();
    
        if($lastVisit == null){
            LastVisit::create([
                'user_id' => $friend_id,
                'visitor_id' => auth()->id()
            ]);
        }else{
            $lastVisit->update(['updated_at' => Carbon::now()]);
        }
    }

    public function newPosts($friend_id){
        $last_visit = $this->lastVisit($friend_id);

        if($last_visit == null){
            return array();
        }

        return Post::where('user_id', $friend_id)
            ->where('created_at', '>', $last_visit)
            ->get();
    }

    // friendship that this user started
	protected function friendsOfThisUser()
	{
		return $this->belongsToMany(User::class, 'friendships', 'first_user', 'second_user')
		->withPivot('status')
		->wherePivot('status', 'confirmed');
	}

	// friendship that this user was asked for
	protected function thisUserFriendOf()
	{
		return $this->belongsToMany(User::class, 'friendships', 'second_user', 'first_user')
		->withPivot('status')
		->wherePivot('status', 'confirmed');
	}

	// accessor allowing you call $user->friends
	public function getFriendsAttribute()
	{
		if (!array_key_exists('friends', $this->relations)){
            $this->loadFriends();
        }
		return $this->getRelation('friends');
	}

    public function pending()
    {
		return $this->hasMany(Friendship::class, 'acted_user')
		->where('status', 'pending');
    }

	protected function loadFriends()
	{
		if (!array_key_exists('friends', $this->relations)){
            $friends = $this->mergeFriends();
            $this->setRelation('friends', $friends);
	    }
	}

	protected function mergeFriends()
	{
		if($temp = $this->friendsOfThisUser){
            return $temp->merge($this->thisUserFriendOf);
        }else{
            return $this->thisUserFriendOf;
        }
	}

    public function friend_requests()
    {
        return $this->hasMany(Friendship::class, 'second_user')
        ->where('status', 'pending');
    }
}
