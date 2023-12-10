<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValorSectorRatio extends Model
{
    use HasFactory;
    protected $fillable = [
        'valor'
    ];

    public function ratio(){
        return $this->belongsTo(Ratio::class);
    }

    public function sectorEmpresa(){
        return $this->belongsTo(SectorEmpresa::class);
    }
}
