<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    use HasFactory;

    public static function findRecord($user1, $user2){
        return Friendship::where(function($query) use ($user1, $user2){
            $query->where('first_user', $user2)
                  ->where('second_user', $user1);
                })->orWhere(function($query) use ($user1, $user2){
            $query->where('second_user', $user2)
                  ->where('first_user', $user1);
                    })->first();
    }

    public static function getFriends($userID){
        return Friendship::where(function($query) use ($userID){
            $query->where('first_user', $userID)
                  ->where('status', 'confirmed');
                })->orWhere(function($query) use ($userID){
            $query->where('second_user', $userID)
                  ->where('status', 'confirmed');
                    });
    }
}
