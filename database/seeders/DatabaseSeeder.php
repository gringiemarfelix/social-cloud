<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Friendship;
use Illuminate\Database\Seeder;
use App\Models\SettingsNotification;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create Base Users
        User::factory(
            [
                'first_name' =>  'Jane',
                'last_name' =>  'Doe',
                'email' => 'jane@doe.com',
            ]
        )->create();

        User::factory(
            [
                'first_name' =>  'John',
                'last_name' =>  'Doe',
                'email' => 'john@doe.com',
            ]
        )->create();

        User::factory(
            [
                'first_name' =>  'Jane',
                'last_name' =>  'Smith',
                'email' => 'jane@smith.com',
            ]
        )->create();

        User::factory(
            [
                'first_name' =>  'John',
                'last_name' =>  'Smith',
                'email' => 'john@smith.com',
            ]
        )->create();

        User::factory(
            [
                'first_name' =>  'Gringiemar',
                'last_name' =>  'Felix',
                'email' => 'gringiemar@felix.com',
            ]
        )->create();

        User::factory(25)->create();

        // Create Notification Settings and Friendships
        $users = User::all();
        for ($x=0; $x < count($users); $x++) {
            for ($y=0; $y < count($users); $y++) { 
                if($x == $y){
                    continue;
                }

                $isFriends = Friendship::where('first_user', $users[$x]->id)
                                        ->where('second_user', $users[$y]->id)
                                        ->where('acted_user', $users[$x]->id)
                                        ->get()->count();
                if(!$isFriends){
                    Friendship::create([
                        'first_user' => $users[$y]->id,
                        'second_user' => $users[$x]->id,
                        'acted_user' => $users[$y]->id,
                        'status' => 'confirmed'
                    ]);
                }
            }
            SettingsNotification::create(['user_id' => $users[$x]->id]);
        }

        // Post::factory(6)->create();
    }
}
