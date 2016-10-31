<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("post_id",false,true);
            $table->string("comment");
            $table->integer("user_id",false,true);
            $table->string("name");
            $table->enum("has_comment",array("yes","no"));
            $table->integer("comment_parent_id");
            $table->string("photo");
            $table->foreign("post_id")->references("id")->on("posts")->onDelete("cascade");
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('comments');
    }
}
