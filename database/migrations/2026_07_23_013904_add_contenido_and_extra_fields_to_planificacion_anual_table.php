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
        Schema::table('planificacion_anual', function (Blueprint $table) {
            $table->json('contenido')->nullable()->after('diagnostico');
            $table->string('grado')->nullable()->after('contenido');
            $table->string('ciclo')->nullable()->after('grado');
            $table->string('anio')->nullable()->after('ciclo');
            $table->longText('saberes_transversales')->nullable()->after('anio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('planificacion_anual', function (Blueprint $table) {
            $table->dropColumn(['contenido', 'grado', 'ciclo', 'anio', 'saberes_transversales']);
        });
    }
};