<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_registration_requests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employer_id')->nullable()->unsigned();
            $table->bigInteger('employee_id')->nullable()->unsigned();
            $table->date('request_date');
            $table->enum('status', ['pending', 'approved', 'rejected']);
            $table->timestamps();

            //relationships
            $table->foreign("employer_id")->references("id")->on("employers");
            $table->foreign("employee_id")->references("id")->on("employees");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_registration_requests');
    }
};
