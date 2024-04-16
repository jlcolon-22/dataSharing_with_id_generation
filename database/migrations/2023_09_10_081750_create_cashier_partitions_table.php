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
        Schema::create('cashier_partitions', function (Blueprint $table) {
            $table->id();
            $table->string('partition');
            $table->string('amount');
            $table->boolean('status')->default(0);
            $table->unsignedBigInteger('cashier_student_tuition_id');
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
        Schema::dropIfExists('cashier_partitions');
    }
};
