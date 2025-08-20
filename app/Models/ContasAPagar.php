<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContasAPagar extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'descricao',
        'valor',
        'data_vencimento',
        'status',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
