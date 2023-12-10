<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectorEmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table("sector_empresas")->insert([
            "nombre"=>"Tienda de mercancias generales"
        ]);
        \DB::table("sector_empresas")->insert([
            "nombre"=>"Servicios de comida y lugares para beber"
        ]);
    }
}
