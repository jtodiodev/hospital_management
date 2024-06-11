<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalRecordsTable extends Migration
{
    public function up()
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->string('patient_name');
            $table->date('date');
            $table->string('eent')->nullable();
            $table->string('heart')->nullable();
            $table->string('lungs')->nullable();
            $table->string('abdomen')->nullable();
            $table->string('genitalia')->nullable();
            $table->string('extremities')->nullable();
            $table->text('impression')->nullable();
            $table->text('treatment')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('medical_records');
    }
}
