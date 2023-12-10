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
        Schema::create('valor_sector_ratios', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('ratio_id');
            $table->unsignedBigInteger('sector_empresa_id');
            $table->float('valor',8,2);

            $table->foreign('ratio_id')->references('id')->on('ratios')->onDelete('cascade');
            $table->foreign('sector_empresa_id')->references('id')->on('sector_empresas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('valor_sector_ratios');
    }
};
