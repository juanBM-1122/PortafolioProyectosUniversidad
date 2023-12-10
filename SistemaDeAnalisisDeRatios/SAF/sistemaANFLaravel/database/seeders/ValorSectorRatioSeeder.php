<?php

namespace Database\Seeders;

use App\Models\Ratio;
use App\Models\ValorSectorRatio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ValorSectorRatioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$ratios = Ratio::all();
        $min = 1;
        $max = 3;
        foreach ($ratios as $ratio) {
            ValorSectorRatio::create([
                'ratio_id' => $ratio->id,
                'sector_empresa_id' => 1,
                'valor'=> $min + ($max - $min) * (rand() / getrandmax())
            ]);
        }

        foreach ($ratios as $ratio) {
            ValorSectorRatio::create([
                'ratio_id' => $ratio->id,
                'sector_empresa_id' => 2,
                'valor'=> $min + ($max - $min) * (rand() / getrandmax())
            ]);
        }
*/
        $valoresEmpresa1 = [
            [
                'ratio_id' =>1,
                'sector_empresa_id' => 1,
                'valor'=> 1.7
            ],
            [
                'ratio_id' =>2,
                'sector_empresa_id' => 1,
                'valor'=> 0.7
            ],
            [
                'ratio_id' =>3,
                'sector_empresa_id' => 1,
                'valor'=> 0.32
            ],
            [
                'ratio_id' =>4,
                'sector_empresa_id' => 1,
                'valor'=> 6.7
            ],
            [
                'ratio_id' =>5,
                'sector_empresa_id' => 1,
                'valor'=> 6.4
            ],
            [
                'ratio_id' =>6,
                'sector_empresa_id' => 1,
                'valor'=> 57
            ],
            [
                'ratio_id' =>7,
                'sector_empresa_id' => 1,
                'valor'=> 106
            ],
            [
                'ratio_id' =>8,
                'sector_empresa_id' => 1,
                'valor'=> 3.43
            ],
            [
                'ratio_id' =>9,
                'sector_empresa_id' => 1,
                'valor'=> 1.7
            ],
            [
                'ratio_id' =>10,
                'sector_empresa_id' => 1,
                'valor'=> 215
            ],
        ];

        foreach($valoresEmpresa1 as $valor){
            ValorSectorRatio::create($valor);
        }

        $valoresEmpresa2 = [
            [
                'ratio_id' =>1,
                'sector_empresa_id' => 2,
                'valor'=> 1.2
            ],
            [
                'ratio_id' =>2,
                'sector_empresa_id' => 2,
                'valor'=> 0.9
            ],
            [
                'ratio_id' =>3,
                'sector_empresa_id' => 2,
                'valor'=> -0.38
            ],
            [
                'ratio_id' =>4,
                'sector_empresa_id' => 2,
                'valor'=> 6.1
            ],
            [
                'ratio_id' =>5,
                'sector_empresa_id' => 2,
                'valor'=> 34.2
            ],
            [
                'ratio_id' =>6,
                'sector_empresa_id' => 2,
                'valor'=> 10.67
            ],
            [
                'ratio_id' =>7,
                'sector_empresa_id' => 2,
                'valor'=> 28.6
            ],
            [
                'ratio_id' =>8,
                'sector_empresa_id' => 2,
                'valor'=> 5.2
            ],
            [
                'ratio_id' =>9,
                'sector_empresa_id' => 2,
                'valor'=> 2.1
            ],
            [
                'ratio_id' =>10,
                'sector_empresa_id' => 2,
                'valor'=> 173.81
            ],
        ];

        foreach($valoresEmpresa2 as $valor){
            ValorSectorRatio::create($valor);
        }
        
    }
}
