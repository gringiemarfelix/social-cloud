<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFriendshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('friendships')){
            Schema::create('friendships', function (Blueprint $table) {
                $table->id();
                
                $table->unsignedBigInteger('first_user');
                $table->foreign('first_user')->references('id')->on('users')->onDelete('cascade');

                $table->unsignedBigInteger('second_user');
                $table->foreign('second_user')->references('id')->on('users')->onDelete('cascade');

                $table->unsignedBigInteger('acted_user');
                $table->foreign('acted_user')->references('id')->on('users')->onDelete('cascade');

                $table->enum('status', ['pending', 'confirmed']);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('friendships');
    }
}
