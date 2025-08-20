<?php

namespace App\Http\Controllers;

use App\Models\cliente;
use App\Models\Empresa;
use App\Models\Fornecedor;
use App\Models\Movimento;
use App\Models\Produto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $empresas = Empresa::all();
        $empresaId = session('empresa_id');

        if (!$empresaId)
        {
            $empresaId = Auth::user()->empresa_id;
        }

        $startDate = Carbon::now()->subMonths(6)->startOfMonth();
        $endDate = Carbon::now();

        $movimentos = Movimento::query()
            ->when($empresaId, function ($query) use ($empresaId) {
                return $query->where('empresa_id', $empresaId);
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('data', [$startDate, $endDate]);
            })
            ->selectRaw("DATE_FORMAT(data, '%m-%Y') as mes, tipo, SUM(valor) as total")
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


        $clientes = Cliente::where('empresa_id', $empresaId)->count();
        $fornecedores = Fornecedor::where('empresa_id', $empresaId)->count();
        $totalDespesas = Movimento::where('tipo', 'despesa')->where('empresa_id', $empresaId)->whereMonth('data', Carbon::now()->month)->whereYear('data', Carbon::now()->year)->sum('valor');
        $totalDespesas = Movimento::where('tipo', 'despesa')->where('empresa_id', $empresaId)->whereMonth('data', Carbon::now()->month)->whereYear('data', Carbon::now()->year)->sum('valor');
        $totalReceitas = Movimento::where('tipo', 'receita')->where('empresa_id', $empresaId)->whereMonth('data', Carbon::now()->month)->whereYear('data', Carbon::now()->year)->sum('valor');
        

        return view('home', [
            'empresas' => $empresas,
            'clientes' => $clientes,
            'fornecedores' => $fornecedores,
            'totalDespesas' => $totalDespesas,
            'totalReceitas' => $totalReceitas,
            'dadosGrafico' => $dadosGrafico,
        ]);
    }
}


