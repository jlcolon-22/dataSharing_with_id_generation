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
        Schema::create('clinic_student_records', function (Blueprint $table) {
            $table->id();
            $table->string('student_id');
            $table->string('school_year_semester');
            $table->string('student_name');
            $table->string('section')->nullable();
            $table->string('temp');
            $table->string('bp');
            $table->string('rr');
            $table->string('pr');
            $table->text('chief_complain');
            $table->text('medication_given');
            $table->string('adviser')->nullable();
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
        Schema::dropIfExists('clinic_student_records');
    }
};
