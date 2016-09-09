<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
//use Illuminate\Support\Facades;
class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create("posts",function(Blueprint $table){
            $table->increments("id");
            $table->string("title")->unique();
            $table->string('description',500);
            $table->string('caption');
            $table->string('permalink')->unique();
            $table->string('image');
            $table->string('audio');
            $table->string("video"); 
            $table->string("document") ;
            $table->string("author") ;
            $table->string("p_content") ;
            $table->string("has_parent") ;
            $table->string("parent_id") ;
            $table->string("target") ;
            $table->enum("status",array('published','drafted','unpublished','archived'));
            $table->boolean("featured");
            $table->string("meta_title") ;
            $table->string("meta_description") ;
            $table->string("meta_keyword") ;
            $table->string("type") ;
            $table->string("post_meta") ;
            $table->enum("post_type",array('page','post','post category','menu','slider','page block','event','event category'));
            $table->date("start_date");
            $table->date("end_date");
            $table->time("start_time");
            $table->time("end_time");
            $table->string("frequency") ;
            $table->string("venue") ;
            $table->string("address") ;
            $table->string("created_by") ;
            $table->enum("view_status",array('visible','hidden'));
            $table->integer("sort_order");
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
        //
        Schema::drop("posts");
    }
}
