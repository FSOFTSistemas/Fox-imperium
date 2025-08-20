@extends('adminlte::page')

@section('title', 'DRE - Demonstrativo de Resultados do Exercício')

@section('content_header')
<h1>Demonstrativo de Resultados do Exercício (DRE)</h1>
@stop

@section('content')

<div class="row" style="margin-bottom: 2%">
    <div class="col">
        <a class="btn btn-primary" href="{{ route('dre.index') }}">Voltar</a>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Resumo Financeiro</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Valor (R$)</th>
                </tr>
            </thead>
            <tbody>
                <tr class="table-primary">
                    <td>Receita Bruta</td>
                    <td>{{ number_format($dre['receita_bruta'], 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Receita Cartão</td>
                    <td>{{ number_format($dre['receita_cartao'], 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Receita à Vista</td>
                    <td>{{ number_format($dre['receita_dinheiro'], 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>(-) Impostos/Descontos</td>
                    <td>{{ number_format($dre['impostos'], 2, ',', '.') }}</td>
                </tr>
                <tr class="table-primary">
                    <td>Receita Líquida</td>
                    <td>{{ number_format($dre['receita_liquida'], 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>(-) Despesas Operacionais</td>
                    <td>{{ number_format($dre['despesas_operacionais'], 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>(-) Despesas Financeiras</td>
                    <td>{{ number_format($dre['despesas_financeiras'], 2, ',', '.') }}</td>
                </tr>
                <tr class="table-primary">
                    <td>Despesas</td>
                    <td>{{ number_format($dre['custos'], 2, ',', '.') }}</td>
                </tr>
                <tr class="table-primary">
                    <td>Lucro Bruto</td>
                    <td>{{ number_format($dre['lucro_bruto'], 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Lucro Antes dos Impostos</td>
                    <td>{{ number_format($dre['lucro_antes_impostos'], 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>(-) Impostos sobre o Lucro</td>
                    <td>{{ number_format($dre['impostos_sobre_lucro'], 2, ',', '.') }}</td>
                </tr>
                <tr class="table-success">
                    <td>Lucro Líquido</td>
                    <td>{{ number_format($dre['lucro_liquido'], 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@stop

@section('css')
{{-- Estilos adicionais podem ser adicionados aqui --}}
<style>
    .table-primary {
        background-color: #d4edda;
        /* Verde claro */
    }

    .table-success {
        background-color: #c3e6cb;
        /* Verde mais destacado */
        font-weight: bold;
    }
</style>
@stop

@section('js')
<script>
    console.log("DRE visualizado na tela do painel!");
</script>
@stop
