<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patrimonio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'valor',
        'descricao',
        'data_aquisicao',
        'empresa_id',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
