<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename("city", "cities");
        Schema::rename("comment", "comments");
        Schema::rename("flag_comment", "flag_comments");
        Schema::rename("flag_post", "flag_posts");
        Schema::rename("flag_user", "flag_users");
        Schema::rename("following", "followings");
        Schema::rename("user", "users");
        Schema::rename("university", "universities");
        Schema::rename("post", "posts");
        Schema::rename("vote", "votes");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename("cities","city");
        Schema::rename("comments","comment");
        Schema::rename("flag_comments","flag_comment");
        Schema::rename("flag_posts","flag_post");
        Schema::rename("flag_users","flag_user");
        Schema::rename("followings","following");
        Schema::rename("users","user");
        Schema::rename("universities","university");
        Schema::rename("posts","post");
        Schema::rename("votes","vote");
    }
}
