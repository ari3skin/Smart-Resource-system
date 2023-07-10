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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('project_id')->unsigned();
            $table->bigInteger('team_manager')->unsigned();
            $table->enum('type', ['individual', 'team']);
            $table->string('task_title');
            $table->string('task_description');
            $table->enum('status', ['completed', 'ongoing', 'closed'])->default('ongoing');
            $table->timestamps();

            //relationships
            $table->foreign("project_id")->references("id")->on("projects");
            $table->foreign("team_manager")->references('id')->on('users');
        });

        DB::update("ALTER TABLE tasks AUTO_INCREMENT=101; ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
