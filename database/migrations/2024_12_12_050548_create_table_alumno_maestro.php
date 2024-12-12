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
        Schema::create('alumno_maestro', function (Blueprint $table) {
            $table->id();
            $table->string('id_alumno');

            $table->foreign('id_alumno')->references('codigo')->on('alumnos');

            $table->unsignedBigInteger('id_tutor');

            $table->foreign('id_tutor')->references('codigo')->on('maestros');
            $table
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
        Schema::dropIfExists('alumno_maestro');
    }
};
