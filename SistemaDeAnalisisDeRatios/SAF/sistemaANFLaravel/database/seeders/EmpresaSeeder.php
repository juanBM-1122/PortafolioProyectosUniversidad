<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table("empresas")->insert([
            "sector_empresa_id"=>1,
            "nombre"=>"Empresa1"
        ]);
        \DB::table("empresas")->insert([
            "sector_empresa_id"=>2,
            "nombre"=> "Empresa2"
        ]);
    }
}
