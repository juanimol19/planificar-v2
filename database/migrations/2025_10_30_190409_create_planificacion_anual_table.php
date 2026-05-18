<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('planificacion_anual', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_presentacion');
            $table->longText('aprendizajes_esperados');
            $table->longText('saberes');
            $table->longText('criterios');
            $table->longText('bibliografia');
            $table->longText('diagnostico');
            $table->unsignedBigInteger('areas_id');
            $table->unsignedBigInteger('persona_cargo_cursado_id');
            $table->string('tipo_planificacion');
            $table->timestamps();

            // Claves foráneas
            $table->foreign('areas_id')
                  ->references('id')->on('areas')
                  ->onDelete('cascade');
            $table->foreign('persona_cargo_cursado_id')
                  ->references('id')->on('persona_cargo_cursado')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planificacion_anual');
    }
};
