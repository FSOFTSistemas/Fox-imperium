<?php

namespace App\Http\Controllers;

use App\Models\Dre;
use App\Http\Controllers\Controller;
use App\Models\Movimento;
use Illuminate\Http\Request;

class DreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $empresaId = session('empresa_id');


        $dataInicio = $request->input('data_inicio');
        $dataFim = $request->input('data_fim');


        $dre = Dre::obterDre($empresaId, $dataInicio, $dataFim);

        return view('DRE.index', ['dre' => $dre]);
    }


    public function dre(Request $request)
    {
        $empresaId = session('empresa_id');

        $startDate = $request->input('data_inicio');
        $endDate = $request->input('data_fim');

        $dataRange = $request->only(['data_inicio', 'data_fim']);
        $startDate = $dataRange['data_inicio'];
        $endDate = $dataRange['data_fim'];



        $totalReceita = $this->getMovimentoSum($empresaId, $startDate, $endDate, 'receita');
        $totalCartao = $this->getMovimentoSum($empresaId, $startDate, $endDate, 'receita', 'cartao');
        $totalDinheiro = $this->getMovimentoSum($empresaId, $startDate, $endDate, 'receita', 'dinheiro');
        $totalDespesa = $this->getMovimentoSum($empresaId, $startDate, $endDate, 'despesa');

        $totalDespesasOperacionais = Movimento::join('plano_de_contas', 'movimentos.planodecontas_id', '=', 'plano_de_contas.id')
            ->where('plano_de_contas.codigo', '>', 3)
            ->where('plano_de_contas.codigo', '<', 4)
            ->where('movimentos.empresa_id', $empresaId)
            ->whereBetween('movimentos.data', [$startDate, $endDate])
            ->sum('movimentos.valor');

        $impostos = Movimento::join('plano_de_contas', 'movimentos.planodecontas_id', '=', 'plano_de_contas.id')
            ->where('plano_de_contas.codigo', '2.1.3')
            ->where('movimentos.empresa_id', $empresaId)
            ->whereBetween('movimentos.data', [$startDate, $endDate])
            ->sum('movimentos.valor');

        $DespesasCompras = Movimento::join('plano_de_contas', 'movimentos.planodecontas_id', '=', 'plano_de_contas.id')
            ->where('plano_de_contas.codigo', '2.1.1')
            ->where('movimentos.empresa_id', $empresaId)
            ->whereBetween('movimentos.data', [$startDate, $endDate])
            ->sum('movimentos.valor');

        $lucroAntesImpostos = $totalReceita - $totalDespesa;// - $totalDespesasOperacionais - $DespesasCompras;
        $impostosSobreLucro = $lucroAntesImpostos * 0;//0.15;
        $lucroLiquido = $lucroAntesImpostos - $impostosSobreLucro;

        $dre = [
            'receita_bruta' => $totalReceita,
            'receita_cartao' => $totalCartao,
            'receita_dinheiro' => $totalDinheiro,
            'impostos' => $impostos,
            'receita_liquida' => $totalReceita - $impostos,
            'custos' => $totalDespesa,
            'despesas_operacionais' => $totalDespesasOperacionais,
            'despesas_financeiras' => $DespesasCompras,
            'lucro_bruto' => $totalReceita - $totalDespesa,
            'lucro_antes_impostos' => $lucroAntesImpostos,
            'impostos_sobre_lucro' => $impostosSobreLucro,
            'lucro_liquido' => $lucroLiquido,
        ];

        return view('DRE.rel', compact('dre'));
    }

    public function cmv()
    {

        $resultados = [];
        return view('DRE.cmv', compact('resultados'));
    }

    public function cmv_filtro(Request $request)
    {
        $empresaId = session('empresa_id');

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $dataRange = $request->only(['start_date', 'end_date']);
        $startDate = $dataRange['start_date'];
        $endDate = $dataRange['end_date'];



        $resultados = Movimento::where('tipo', 'cmv')->where('empresa_id', $empresaId)->get();
        return view('DRE.cmv', compact('resultados'));
    }

    private function getMovimentoSum($empresaId, $startDate, $endDate, $tipo, $formaPagamento = null)
    {
        return Movimento::where('empresa_id', $empresaId)
            ->whereBetween('data', [$startDate, $endDate])
            ->where('tipo', $tipo)
            ->when($formaPagamento, function ($query) use ($formaPagamento) {
                return $query->where('forma_pagamento', $formaPagamento);
            })
            ->sum('valor');
    }
}
