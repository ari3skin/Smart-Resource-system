<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('task_id')->unsigned()->nullable();
            $table->bigInteger('member_1')->unsigned()->nullable();
            $table->bigInteger('member_2')->unsigned()->nullable();
            $table->bigInteger('member_3')->unsigned()->nullable();
            $table->bigInteger('member_4')->unsigned()->nullable();
            $table->bigInteger('member_5')->unsigned()->nullable();
            $table->timestamps();

            //relationships
            $table->foreign("task_id")->references("id")->on("tasks");
            $table->foreign("member_1")->references('id')->on('users');
            $table->foreign("member_2")->references('id')->on('users');
            $table->foreign("member_3")->references('id')->on('users');
            $table->foreign("member_4")->references('id')->on('users');
            $table->foreign("member_5")->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
};
