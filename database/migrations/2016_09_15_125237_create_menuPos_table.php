<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuPosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menupos', function (Blueprint $table) {
            //
            $table->increments("id");
            $table->integer("menu_id",false,true);
            $table->string("menu_title")->unique();
            $table->string("menu_jsondata");
            $table->foreign("menu_id")->references("id")->on("menus")->onDelete("cascade");
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
        Schema::drop('menupos');

    }
}
