<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Friendship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class FriendController extends Controller
{
    public function index(){
        $friends = auth()->user()->friends->pluck('id')->toArray();
        $friends = User::whereIn('id', $friends)->paginate(16);

        return view('friends', [
            'friends' => $friends,
            'requests' => count(auth()->user()->friend_requests()->get())
        ]);
    }

    public function pending(){
        $friends = auth()->user()->pending()->paginate(20);
        $friendsArray = [];

        foreach($friends as $friend){
            $friendsArray[] = User::find($friend->second_user)->id;
        }

        $friends = User::whereIn('id', $friendsArray)->paginate(16);

        return view('friends', [
            'friends' => $friends,
            'requests' => count(auth()->user()->friend_requests()->get())
        ]);
    }

    public function requests(){
        $friends = auth()->user()->friend_requests()->get();
        $friendsArray = [];

        foreach($friends as $friend){
            $friendsArray[] = User::find($friend->first_user)->id;
        }

        $friends = User::whereIn('id', $friendsArray)->paginate(16);

        return view('friends', [
            'friends' => $friends,
            'requests' => count(auth()->user()->friend_requests()->get())
        ]);
    }
    
    public function store(Request $request){
        $friendRequest = [
            'first_user' => auth()->id(),
            'second_user' => $request->input('user_id'),
            'acted_user' => auth()->id(),
            'status' => 'pending'
        ];

        Friendship::create($friendRequest);

        return redirect('/friends/pending')->with('message', 'Friend request sent.');
    }

    public function update(Request $request, Friendship $friendship){
        $friendship->where(function($query) use ($request){
            $query->where('first_user', $request->user_id)
                  ->where('second_user', auth()->id());
                })->orWhere(function($query) use ($request){
            $query->where('second_user', $request->user_id)
                  ->where('first_user', auth()->id());
                    })->update(['status' => 'confirmed']);

        return redirect('/friends')->with('message', 'Friend accepted');
    }

    public function destroy(Request $request, Friendship $friendship){
        $friendship->findRecord(auth()->id(), $request->user_id)->delete();

        if(Route::is('cancel')){
            return redirect('/friends/pending')->with('message', 'Friend request cancelled successfully.');
        }

        if(Route::is('reject')){
            return redirect('/friends/requests')->with('message', 'Friend request rejected successfully.');
        }

        return redirect('/friends')->with('message', 'Friend removed successfully.');
    }
}
