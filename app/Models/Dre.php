<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dre extends Model
{
    public static function obterDre($empresaId, $dataInicio = null, $dataFim = null)
    {
        $query = Movimento::where('empresa_id', $empresaId);

        if ($dataInicio) {
            $query->where('data', '>=', $dataInicio);
        }

        if ($dataFim) {
            $query->where('data', '<=', $dataFim);
        }

        $receitas = $query->where('tipo', 'receita')->get();
        $despesas = $query->where('tipo', 'despesa')->get();


        $totalReceitasDinheiro = $receitas->where('forma_pagamento', 'dinheiro')->sum('valor');
        $totalReceitasCartao = $receitas->where('forma_pagamento', 'cartao')->sum('valor');

        $despesasAgrupadas = $despesas->groupBy('categoria')->map(function($item) {
            return $item->sum('valor');
        });

        $totalDespesas = $despesas->sum('valor');
        $lucroOuPrejuizo = $totalReceitasDinheiro + $totalReceitasCartao - $totalDespesas;

        return [
            'receita_bruta_dinheiro' => $totalReceitasDinheiro,
            'receita_bruta_cartao' => $totalReceitasCartao,
            'despesas_agrupadas' => $despesasAgrupadas,
            'lucroOuPrejuizo' => $lucroOuPrejuizo,
            'totalGeral' => $lucroOuPrejuizo
        ];
    }
}
