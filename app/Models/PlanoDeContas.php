<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanoDeContas extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'descricao',
        'tipo',
    ];

    /**
     * Relacionamento: O Plano de Contas pertence a uma Empresa.
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
