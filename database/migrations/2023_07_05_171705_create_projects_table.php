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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('department_id')->unsigned();
            $table->bigInteger('project_manager')->unsigned();
            $table->bigInteger('sub_project_manager')->unsigned()->nullable();
            $table->string('project_title');
            $table->string('project_description', 500);
            $table->enum('status', ['completed', 'ongoing', 'closed'])->default('ongoing');
            $table->timestamps();

            //relationships
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign("project_manager")->references("id")->on("users");
            $table->foreign("sub_project_manager")->references("id")->on("users");
        });

        DB::update("ALTER TABLE projects AUTO_INCREMENT=101; ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
