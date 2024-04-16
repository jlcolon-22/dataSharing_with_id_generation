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
        Schema::create('cashier_student_tuitions', function (Blueprint $table) {
            $table->id();
            $table->string('student_id');
            $table->bigInteger('partition');
            $table->bigInteger('total_school_fee')->default(0);
            $table->bigInteger('total_payable_fee')->default(0);
            $table->string('school_year_semester');
            $table->string('section')->nullable();
            $table->string('student_name');
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
        Schema::dropIfExists('cashier_student_tuitions');
    }
};
