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
        Schema::table('analisis_verticals', function (Blueprint $table) {
            //
            $table->unsignedBigInteger("valor_cuenta_id");
            $table->foreign("valor_cuenta_id")
            ->references("id")
            ->on("valor_cuentas")
            ->onDelete("Cascade")
            ->onUpdate("Cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('analisis_vertical', function (Blueprint $table) {
            //
        });
    }
};
;