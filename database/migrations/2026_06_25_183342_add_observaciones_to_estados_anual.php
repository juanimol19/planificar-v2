<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('estados_anual', function (Blueprint $table) {
            $table->longText('observaciones')->nullable()->after('fecha');
        });
    }

    public function down(): void
    {
        Schema::table('estados_anual', function (Blueprint $table) {
            $table->dropColumn('observaciones');
        });
    }
};