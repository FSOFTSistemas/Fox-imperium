<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimento extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao',
        'tipo',
        'data',
        'forma_pagamento',
        'valor',
        'produto_servico_id',
        'empresa_id',
        'planodecontas_id',
    ];


    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function produtoServico()
    {
        return $this->belongsTo(Produto::class, 'produto_servico_id')->withDefault();
    }
}
