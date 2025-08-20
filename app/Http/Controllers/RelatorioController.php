<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Movimento;
use App\Models\Patrimonio;
use App\Models\Relatorio;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $empresaId = session('empresa_id');

        $movimentos = Movimento::query()
            ->when($empresaId, function ($query) use ($empresaId) {
                return $query->where('empresa_id', $empresaId);
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('data', [$startDate, $endDate]);
            })
            ->selectRaw("DATE_FORMAT(data, '%Y-%m') as mes, tipo, SUM(valor) as total")
            ->groupBy('mes', 'tipo')
            ->orderBy('mes')
            ->get();

        // Preparando os dados para o gráfico
        $meses = $movimentos->pluck('mes')->unique()->sort()->values();
        $receitas = $movimentos->where('tipo', 'receita')->pluck('total', 'mes');
        $despesas = $movimentos->where('tipo', 'despesa')->pluck('total', 'mes');

        // Convertendo para formato compatível com o Chart.js
        $dadosGrafico = [
            'meses' => $meses->toArray(),
            'receitas' => $meses->map(fn($mes) => $receitas[$mes] ?? 0)->toArray(),
            'despesas' => $meses->map(fn($mes) => $despesas[$mes] ?? 0)->toArray(),
        ];

        return view('relatorio.index', compact('dadosGrafico'));
    }


    public function gerarPdf(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $reportType = $request->input('report_type');
        $empresaId = session('empresa_id');

        if ($reportType === 'geral') {
            $pdf = $this->gerarRelatorioGeral($startDate, $endDate, $empresaId);

            // return $pdf->stream("relatorio_{$reportType}.pdf");
            return $pdf->stream("relatorio_geral.pdf");
        }

        switch ($reportType) {
            case 'dre':
                $view = 'relatorio.dre';
                $dados = $this->gerarRelatorioDre($startDate, $endDate, $empresaId);
                break;

            case 'cmv':
                $view = 'relatorio.cmv';
                $dados = $this->gerarRelatorioCmv($startDate, $endDate, $empresaId);
                break;

            case 'despesas':
                $view = 'relatorio.despesas';
                $dados = $this->gerarRelatorioDespesas($startDate, $endDate, $empresaId);
                break;
            case 'receitas':
                $view = 'relatorio.receitas';
                $dados = $this->gerarRelatorioReceitas($startDate, $endDate, $empresaId);
                break;

            case 'patrimonio':
                $view = 'relatorio.patrimonio';
                $dados = $this->gerarRelatorioPatrimonio($empresaId);
                break;

            default:
                return redirect()->back()->withErrors(['error' => 'Tipo de relatório inválido']);
        }


        $pdf = FacadePdf::loadView($view, compact('dados', 'reportType', 'startDate', 'endDate'));

        return $pdf->stream("relatorio_{$reportType}.pdf");
    }


    protected function gerarRelatorioDre($startDate, $endDate, $empresaId)
    {

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

        $lucroAntesImpostos = $totalReceita - $totalDespesa; // - $totalDespesasOperacionais - $DespesasCompras;
        $impostosSobreLucro = $lucroAntesImpostos * 0; //0.15;
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

        return $dre;
    }

    protected function gerarRelatorioGeral($startDate, $endDate, $empresaId)
    {



        // Inicializar o conteúdo do PDF
        $html = '';
        $empresa = Empresa::find($empresaId);
        // Capa do relatório
        $capaHtml = view('relatorio.capa', compact('startDate', 'endDate', 'empresa'))->render();
        $html .= $capaHtml;

        // Relatório DRE
        $dados = $this->gerarRelatorioDre($startDate, $endDate, $empresaId);
        $dreView = view('relatorio.dre', compact('dados', 'startDate', 'endDate'))->render();
        $html .= $dreView;

        // Relatório CMV
        $dados = $this->gerarRelatorioCmv($startDate, $endDate, $empresaId);
        $cmvView = view('relatorio.cmv', compact('dados', 'startDate', 'endDate'))->render();
        $html .= $cmvView;

        // Relatório Despesas
        $dados = $this->gerarRelatorioDespesas($startDate, $endDate, $empresaId);
        $despesasView = view('relatorio.despesas', compact('dados', 'startDate', 'endDate'))->render();
        $html .= $despesasView;

        // Relatório Receitas
        $dados = $this->gerarRelatorioReceitas($startDate, $endDate, $empresaId);
        $receitasView = view('relatorio.receitas', compact('dados', 'startDate', 'endDate'))->render();
        $html .= $receitasView;

        // Relatório Patrimônio
        $dados = $this->gerarRelatorioPatrimonio($empresaId);
        $patrimonioView = view('relatorio.patrimonio', compact('dados'))->render();
        $html .= $patrimonioView;

        // Gerar e retornar o PDF
        return FacadePdf::loadHTML($html);
    }

    protected function gerarRelatorioCmv($startDate, $endDate, $empresaId)
    {
        return Movimento::whereBetween('data', [$startDate, $endDate])
            ->where('tipo', 'cmv')
            ->where('empresa_id', $empresaId)
            ->get()
            ->map(function ($movimento) {
                return [
                    'descricao' => $movimento->descricao,
                    'valor' => $movimento->valor,
                    'data' => $movimento->data,
                ];
            });
    }

    protected function gerarRelatorioDespesas($startDate, $endDate, $empresaId)
    {
        return Movimento::whereBetween('data', [$startDate, $endDate])
            ->where('tipo', 'despesa')
            ->where('empresa_id', $empresaId)
            ->get();
    }
    protected function gerarRelatorioReceitas($startDate, $endDate, $empresaId)
    {
        return Movimento::whereBetween('data', [$startDate, $endDate])
            ->where('tipo', 'receita')
            ->where('empresa_id', $empresaId)
            ->get();
    }

    protected function gerarRelatorioPatrimonio($empresaId)
    {
        return Patrimonio::where('empresa_id', $empresaId)->get();
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
