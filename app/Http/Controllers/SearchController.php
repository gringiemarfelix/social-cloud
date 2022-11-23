<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Friendship;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request){
        $search = $request->search;
        $users = User::where(function($query) use ($search){
            $query->where('first_name', 'like', '%' . $search . '%')
                ->orWhere('middle_name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%');
                })
            ->where('id', '!=', auth()->id())->latest()->take(12)->get();

        // Get User IDs from Collection
        $userIDs = $users->pluck('id')->toArray();

        $posts = Post::where('description', 'like', '%' . $request->search . '%')
        ->orWhereIn('user_id', $userIDs)->latest()->take(10)->get();

        return view('search', [
            'users' => $users,
            'statuses' => $this->getFriendshipStatuses($userIDs),
            'posts' => $posts,
        ]);
    }

    public function users(Request $request){
        $search = $request->search;
        $users = User::where(function($query) use ($search){
            $query->where('first_name', 'like', '%' . $search . '%')
                ->orWhere('middle_name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%');
                })
            ->where('id', '!=', auth()->id())->latest()->paginate(12);

        // Get User IDs from Collection
        $userIDs = $users->pluck('id')->toArray();

        return view('search', [
            'users' => $users,
            'statuses' => $this->getFriendshipStatuses($userIDs),
            'posts' => [],
        ]);
    }

    public function posts(Request $request){
        $search = $request->search;
        $users = User::where(function($query) use ($search){
            $query->where('first_name', 'like', '%' . $search . '%')
                ->orWhere('middle_name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%');
                })
            ->where('id', '!=', auth()->id())->get();

        // Get User IDs from Collection
        $userIDs = $users->pluck('id')->toArray();

        $posts = Post::where('description', 'like', '%' . $request->search . '%')
        ->orWhereIn('user_id', $userIDs)->paginate(10);

        return view('search', [
            'posts' => $posts,
        ]);
    }

    // Helper Functions
    public function getFriendshipStatuses($userIDs){
        $statuses = array();

        foreach($userIDs as $userID){
            $statuses[$userID] = Friendship::findRecord(auth()->id(), $userID);

            if($statuses[$userID] == null){
                continue;
            }

            if($statuses[$userID]->acted_user == auth()->id() && $statuses[$userID]->status == 'pending'){
                $statuses[$userID] = 'requested';
            }else{
                $statuses[$userID] = $statuses[$userID]->status;
            }
        }

        return $statuses;
    }
}
