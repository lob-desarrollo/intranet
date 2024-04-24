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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('genero', 2);
            $table->date('nacimiento')->nullable();
            $table->date('ingreso');
            $table->string('puesto')->nullable();
            $table->string('no_empleado');
            $table->foreignId('departamento_id');
            $table->string('movil', 10)->nullable();
            $table->string('telefono', 10)->nullable();
            $table->string('extension', 6)->nullable();
            $table->string('avatar')->nullable();
            $table->string('fondo')->nullable();
            $table->tinyInteger('estatus');
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
        Schema::dropIfExists('profiles');
    }
};
