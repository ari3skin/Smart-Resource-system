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
            $table->id();
            $table->bigInteger('task_id')->unsigned();
            $table->bigInteger('individuals_id')->unsigned()->nullable();
            $table->bigInteger('team_id')->unsigned()->nullable();
            $table->enum('task_status', ['completed', 'ongoing', 'closed'])->default('ongoing');
            $table->timestamps();

            //relationships
            $table->foreign("task_id")->references("id")->on("tasks");
            $table->foreign('individuals_id')->references('id')->on('users');
            $table->foreign('team_id')->references('id')->on('teams');
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
