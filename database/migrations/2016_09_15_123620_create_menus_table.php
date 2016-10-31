<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            //
            $table->increments("id");
            $table->string("title")->unique();
            $table->string("position");
            $table->string("menu_type");
            $table->integer("post_id",false,true);
            $table->string("link")->unique();
            $table->string("has_child");
            $table->integer("parent_id");
            $table->boolean("sort_order");
            $table->foreign("post_id")->references("id")->on("posts")->onDelete("cascade");
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
        Schema::drop('menus');
    }
}
