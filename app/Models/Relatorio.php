<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relatorio extends Model
{
    use HasFactory;

    protected $fillable = ['descricao', 'valor', 'data', 'tipo'];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function scopeDataRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('data', [$startDate, $endDate]);
    }

    public function scopeReportType($query, $reportType)
    {
        return $query->where('tipo', $reportType);
    }
}
