<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('apartado_items', function (Blueprint $table) {
            $table->string('numero_lote')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('apartado_items', function (Blueprint $table) {
            $table->dropColumn('numero_lote');
        });
    }
};
