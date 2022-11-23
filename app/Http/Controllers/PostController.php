<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class PostController extends Controller
{
    public function index(){
        $friends = auth()->user()->friends;

        // Get Friend IDs
        $friends = $friends->pluck('id')->toArray();
        
        return view('posts.index', [
            'posts' => Post::latest()->whereIn('user_id', $friends)->paginate(20)
        ]);
    }

    public function store(Request $request){
        $formFields = [
            'description' => $request->input('description'),
            'user_id' => auth()->id()
        ];

        if(empty($formFields['description']) && !$request->hasFile('photo')){
            return redirect('/feed')->with('message', 'Please write something or upload something.');
        }

        if($request->hasFile('photo')){
            if($request->file('photo')->getSize() < 5242880){
                $formFields['image'] = $request->file('photo')->store('posts', 'public');
            }else{
                return back()->with('message', 'File too large. Please upload less than 5MB.');
            }
        }

        $formFields['user_id'] = auth()->id();

        $post = Post::create($formFields);

        if($request->header('referer') == url('profile')){
            return redirect('/profile')->with('message', 'Post created successfully.');
        }

        // Notify Friends
        $friends = auth()->user()->friends->pluck('id')->toArray();

        foreach($friends as $friend){
            if(User::find($friend)->settingsNotifications()->first()->posts == 'on'){
                Notification::create([
                    'user_id' => $friend,
                    'from_id' => auth()->id(),
                    'post_id' => $post->id,
                    'description' => 'made a new post.'
                ]);
            }
        }

        return redirect('/feed')->with('message', 'Post created successfully.');
    }

    public function show(Post $post){
        return view('posts.show', [
            'post' => $post
        ]);
    }

    public function edit(Post $post){
        if(auth()->id() != $post->user_id){
            abort(403, 'Unauthorized action.');
        }

        return view('posts.edit', [
            'post' => $post,
            'edit' => true
        ]);
    }

    public function update(Request $request, Post $post){
        if(auth()->id() != $post->user_id){
            abort(403, 'Unauthorized action.');
        }

        $formFields['description'] = $request->input('description');

        $post->update($formFields);

        return redirect('/feed')->with('message', 'Post updated successfully.');
    }

    public function destroy(Post $post){
        if(auth()->id() != $post->user_id){
            abort(403, 'Unauthorized Action.');
        }

        $post->delete();

        return redirect('/feed')->with('message', 'Post deleted successfully.');
    }

    public function share(Request $request, Post $post){
        $formFields = [
            'user_id' => auth()->id(),
            'description' => $request->description,
            'share_id' => $request->post_id,
            'type' => 'share'
        ];

        $post->create($formFields);

        $postOwner = Post::find($request->post_id)->user_id;

        if(auth()->id() != $postOwner){
            if(User::find($postOwner)->settingsNotifications()->first()->shares == 'on'){
                Notification::create([
                    'user_id' => $postOwner,
                    'from_id' => auth()->id(),
                    'post_id' => $request->post_id,
                    'description' => 'shared your post',
                ]);
            }
        }

        return redirect('/profile')->with('message', 'Post shared successfully.');
    }
}
