<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cnpj',
        'email',
        'telefone',
        'endereco',
        'cidade',
        'estado',
        'cep',
        'empresa_id',
    ];


    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
