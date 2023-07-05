<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_lists', function (Blueprint $table) {
            $table->bigInteger('task_id')->unsigned();
            $table->bigInteger('team_member')->unsigned();
            $table->timestamps();

            //relationships
            $table->foreign("task_id")->references("id")->on("tasks");
            $table->foreign('team_member')->references('id')->on('users');
        });

        DB::update("ALTER TABLE task_lists AUTO_INCREMENT=101; ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_lists');
    }
};
