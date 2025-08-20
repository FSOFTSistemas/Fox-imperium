<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'razao_social',
        'fantasia',
        'cnpj',
        'IE',
        'email',
        'telefone',
        'endereco',
        'cidade',
        'estado',
        'cep',
    ];


    public function users()
    {
        return $this->hasMany(User::class);
    }
}
