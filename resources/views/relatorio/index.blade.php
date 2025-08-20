@extends('adminlte::page')

@section('title', 'Relatórios')

@section('content_header')
    <h1>Relatórios</h1>
@stop

@section('content')
<div class="card">
    <div class="card-title">
        <div style="text-align: center">
            <small>Relátorios em PDF</small>
        </div>
    </div>
    <div class="card-body">
    <form action="{{ route('relatorios.pdf') }}" method="POST" target="_blank">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <label for="start_date">Data Início</label>
                <input type="date" name="start_date" id="start_date" class="form-control"
                    value="{{ request()->get('start_date') }}">
            </div>
            <div class="col-md-6">
                <label for="end_date">Data Fim</label>
                <input type="date" name="end_date" id="end_date" class="form-control"
                    value="{{ request()->get('end_date') }}">
            </div>
            <div class="col-md-12 mt-2">
                <label for="report_type">Tipo de Relatório</label>
                <select name="report_type" id="report_type" class="form-control">
                    <option value="" disabled selected>Selecione...</option>
                    <option value="dre">DRE</option>
                    <option value="geral">Geral</option>
                    <option value="cmv">CMV</option>
                    <option value="despesas">Despesas</option>
                    <option value="receitas">Receitas</option>
                    <option value="patrimonio">Patrimonio</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Gerar Relatório</button>
    </form>
</div>
</div>
<br>
<div class="card">
    <div class="card-title">
        <div style="text-align: center">
            <small>Filtrar gráficos</small>
        </div>
    </div>
    <div class="card-body">
    <form action="{{ route('relatorios.index') }}" method="GET">
        <div class="row mb-2">
            <div class="col-md-3">
                <label for="start_date">Data Início</label>
                <input type="date" name="start_date" id="start_date" class="form-control"
                    value="{{ request()->get('start_date') }}">
            </div>
            <div class="col-md-3">
                <label for="end_date">Data Fim</label>
                <input type="date" name="end_date" id="end_date" class="form-control"
                    value="{{ request()->get('end_date') }}">
            </div>
           
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
            </div>
        </div>
    </form>
</div>
</div>

    <div class="row mt-4">
        <div class="col-md-12">
            <canvas id="myChart"></canvas>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    <script>
        // Dados do gráfico vindos do backend
        const dadosGrafico = @json($dadosGrafico);

        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: dadosGrafico.meses,
                datasets: [{
                        label: 'Receitas',
                        data: dadosGrafico.receitas,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Despesas',
                        data: dadosGrafico.despesas,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
