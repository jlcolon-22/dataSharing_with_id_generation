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
        Schema::create('student_id__positions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('saso_id');
           //firstname
           $table->string('firstname_x');
           $table->string('firstname_y');
           $table->string('firstname_fw')->nullable();
           $table->string('firstname_ff')->nullable();
           $table->string('firstname_b')->nullable();

           //middlename
           $table->string('middlename_x')->nullable();
           $table->string('middlename_y')->nullable();
           $table->string('middlename_fw')->nullable();
           $table->string('middlename_ff')->nullable();
           $table->string('middlename_b')->nullable();

            //lastname
            $table->string('lastname_x');
            $table->string('lastname_y');
            $table->string('lastname_fw')->nullable();
            $table->string('lastname_ff')->nullable();
            $table->string('lastname_b')->nullable();

            //student number
            $table->string('student_number_x');
            $table->string('student_number_y');
            $table->string('student_number_fw')->nullable();
            $table->string('student_number_ff')->nullable();
            $table->string('student_number_b')->nullable();

            //course
            $table->string('course_x');
            $table->string('course_y');
            $table->string('course_fw')->nullable();
            $table->string('course_ff')->nullable();
            $table->string('course_b')->nullable();

            //year_sem
            $table->string('year_sem_x');
            $table->string('year_sem_y');
            $table->string('year_sem_fw')->nullable();
            $table->string('year_sem_ff')->nullable();
            $table->string('year_sem_b')->nullable();
            //contact form
            $table->string('contact_form_x');
            $table->string('contact_form_y');
            $table->string('contact_form_fw')->nullable();
            $table->string('contact_form_ff')->nullable();
            $table->string('contact_form_b')->nullable();
            //address
            $table->string('address_x');
            $table->string('address_y');
            $table->string('address_fw')->nullable();
            $table->string('address_ff')->nullable();
            $table->string('address_b')->nullable();
            $table->string('address_w')->nullable();
            $table->string('address_h')->nullable();
            //number
            $table->string('number_x');
            $table->string('number_y');
            $table->string('number_fw')->nullable();
            $table->string('number_ff')->nullable();
            $table->string('number_b')->nullable();

             //profile
             $table->string('profile_x');
             $table->string('profile_y');
             $table->string('profile_w')->nullable();
             $table->string('profile_h')->nullable();

             //signature
             $table->string('signature_x');
             $table->string('signature_y');
             $table->string('signature_w')->nullable();
             $table->string('signature_h')->nullable();

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
        Schema::dropIfExists('student_id__positions');
    }
};
