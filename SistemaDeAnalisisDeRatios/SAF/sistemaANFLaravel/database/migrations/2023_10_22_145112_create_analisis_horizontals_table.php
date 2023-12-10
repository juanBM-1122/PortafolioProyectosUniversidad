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
        Schema::create('analisis_horizontals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('valor_cuenta_id');
            $table->float('variacionAbsoluta',8,4);
            $table->float('variacionRelativa',8,4);
            $table->integer('yearInicial');
            $table->integer('yearFinal');

            $table->foreign('valor_cuenta_id')->references('id')->on('valor_cuentas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('analisis_horizontals');
    }
};
