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
            $table->longText('aprendizajes_esperados')->nullable()->change();
            $table->longText('saberes')->nullable()->change();
            $table->longText('criterios')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('planificacion_anual', function (Blueprint $table) {
            $table->longText('aprendizajes_esperados')->nullable(false)->change();
            $table->longText('saberes')->nullable(false)->change();
            $table->longText('criterios')->nullable(false)->change();
        });
    }
};