<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\PostLike;
use App\Models\PostComment;
use App\Models\Notification;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    // Posts
    public function like(Request $request){
        $findPost = PostLike::where([
            'post_id' => $request->post,
            'user_id' => auth()->id()
        ]);

        if($findPost->exists()){
            $post = $findPost->first();

            if($post->status == 'liked'){
                $post->update(['status' => 'unliked']);
            }else{
                $post->update(['status' => 'liked']);
            }

            return response()->json([
                'status' => $post->status
            ]);
        }else{
            $PostLike = PostLike::create([
                'post_id' => $request->post,
                'user_id' => auth()->user()->id,
                'status' => 'liked'
            ]);

            if(auth()->id() != $PostLike->post->user_id){
                if(User::find($PostLike->post->user_id)->settingsNotifications()->first()->likes == 'on'){
                    Notification::create([
                        'user_id' => $PostLike->post->user_id,
                        'from_id' => auth()->id(),
                        'post_id' => $request->post,
                        'description' => 'liked your post',
                    ]);
                }
            }

            return response()->json([
                'status' => 'liked'
            ]);
        }
    }

    public function comments(Request $request){
        session(['_apiToken' => $request->bearerToken()]);

        return response()->json([
            'comments' => view('components.comments', [
                'comments' => PostComment::where('post_id', $request->post)->latest()->paginate(5)
            ])->render(),
        ]);
    }

    public function storeComment(Request $request){
        session(['_apiToken' => $request->bearerToken()]);

        if(empty($request->description)){
            return request()->json([
                'message' => 'Please enter a comment.'
            ]);
        }

        $formFields = [
            'post_id' => $request->post_id,
            'user_id' => auth()->id(),
            'description' => $request->description
        ];

        PostComment::create($formFields);

        $postOwner = Post::find($request->post_id)->user_id;

        if(auth()->id() != $postOwner){
            if(User::find($postOwner)->settingsNotifications()->first()->comments == 'on'){
                Notification::create([
                    'user_id' => $postOwner,
                    'from_id' => auth()->id(),
                    'post_id' => $request->post_id,
                    'description' => 'commented on your post',
                ]);
            }
        }

        return response()->json([
            'comments' => view('components.comments', [
                'comments' => PostComment::where('post_id', $request->post_id)->latest()->paginate(5)
            ])->render(),
        ]);
    }

    public function deleteComment(Request $request){
        session(['_apiToken' => $request->bearerToken()]);

        $comment = PostComment::where('id', $request->comment_id)->first();

        if(auth()->id() != $comment->user_id){
            return response('Unauthorized', 403);
        }

        PostComment::where('id', $request->comment_id)->delete();

        return response()->json([
            'message' => 'Comment deleted',
            'comments' => view('components.comments', [
                'comments' => PostComment::where('post_id', $comment->post_id)->latest()->paginate(5)
            ])->render(),
        ]);
    }

    public function share(Request $request, Post $post){
        return response()->json([
            'post' => view('components.share-post', [
                'post' => Post::where('id', $request->post_id)->first()
            ])->render(),
        ]);
    }

    // Notifications
    public function read(Request $request){
        Notification::where('id', $request->notification_id)
                    ->where('user_id', auth()->id())->update(['status' => 'read']);

        return response()->json([
            'status' => 'read'
        ]);
    }

    // Friends
    public function friendsSearch(Request $request){
        $search = $request->search;

        $friends = auth()->user()->friends;
        if(!empty($search)){
            $friends = $friends->pluck('id')->toArray();
            
            $friends = User::where(function($query) use ($search){
                                $query->where('first_name', 'like', '%' . $search . '%')
                                ->orWhere('middle_name', 'like', '%' . $search . '%')
                                ->orWhere('last_name', 'like', '%' . $search . '%');
                            })
                            ->whereIn('id', $friends)
                            ->get();
        }

        return response()->json([
            'friends' => view('components.right-nav-friends', [
                'friends' => $friends
            ])->render()
        ]);
    }
}
