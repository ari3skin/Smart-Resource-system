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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employer_id')->nullable()->unsigned();
            $table->bigInteger('employee_id')->nullable()->unsigned();
            $table->enum('role', ['admin', 'employer', 'employee'])->default('admin');
            $table->string('username');
            $table->string('password')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            //relationships
            $table->foreign("employer_id")->references("id")->on("employers");
            $table->foreign("employee_id")->references("id")->on("employees");
        });

        DB::update("ALTER TABLE users AUTO_INCREMENT=101; ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
