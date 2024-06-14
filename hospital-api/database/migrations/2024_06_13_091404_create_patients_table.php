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
        Schema::create('patients', function (Blueprint $table) {
            $table->string('caseNo', 36)->primary();
            $table->unsignedBigInteger('patient_ID'); 
            $table->foreign('patient_ID')->references('id')->on('users');
            $table->string('name'); 
            $table->string('gender');
            $table->integer('age');
            $table->string('contactNo');
            $table->timestamp('dateAdded')->useCurrent(); 
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
        Schema::dropIfExists('patients');
    }
};