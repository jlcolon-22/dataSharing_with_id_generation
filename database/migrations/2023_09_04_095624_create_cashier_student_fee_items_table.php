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
        Schema::create('cashier_student_fee_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cashier_student_tuition_id');
            $table->string('fee_type');
            $table->bigInteger('amount');
            $table->tinyInteger('type')->default(0);
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('cashier_student_fee_items');
    }
};
