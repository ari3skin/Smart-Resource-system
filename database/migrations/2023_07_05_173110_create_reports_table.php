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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('submitter_id')->unsigned();
            $table->bigInteger('project_id')->unsigned()->nullable();
            $table->bigInteger('task_id')->unsigned()->nullable();
            $table->enum('report_type', ['project_documentation', 'task_report']);
            $table->string('report_title');
            $table->string('report_summary');
            $table->string('report_file')->nullable();
            $table->timestamps();

            //relationships
            $table->foreign('submitter_id')->references('id')->on('users');
            $table->foreign("project_id")->references("id")->on("projects");
            $table->foreign('task_id')->references('id')->on('tasks');
        });

        DB::update("ALTER TABLE reports AUTO_INCREMENT=101; ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
};
