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
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id');
            $table->string('titulo');
            $table->text('resumen');
            $table->text('contenido');
            $table->string('imagen');
            $table->tinyInteger('estatus');
            $table->date('inicia')->nullable();
            $table->date('termina')->nullable();
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
        Schema::dropIfExists('notices');
    }
};
