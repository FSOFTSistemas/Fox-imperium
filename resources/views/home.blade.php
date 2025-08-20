@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')
@can('acesso total')
<div class="d-flex justify-content-end align-items-center mt-3">
    {{-- Dropdown de Seleção de Empresas --}}
    <div class="dropdown mr-3">
        <button class="btn btn-primary dropdown-toggle px-4 py-2" type="button" id="dropdownEmpresas" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-building mr-2"></i> Selecione uma Empresa
        </button>
        <div class="dropdown-menu dropdown-menu-right shadow-lg" aria-labelledby="dropdownEmpresas" style="min-width: 250px;">
            @foreach ($empresas as $empresa)
            <a class="dropdown-item d-flex align-items-center" href="{{ route('seletor.empresa', ['id' => $empresa->id]) }}">
                <i class="fas fa-check-circle text-primary mr-2"></i> {{ $empresa->razao_social }}
            </a>
            @endforeach
        </div>
    </div>

    {{-- Empresa Selecionada --}}
    @if (session('empresa_id'))
    <div class="alert alert-info d-flex align-items-center mb-0" style="max-width: 80%;">
        <i class="fas fa-info-circle mr-2"></i>
        <span>Empresa Selecionada: <strong>{{ App\Models\Empresa::find(session('empresa_id'))->razao_social }}</strong></span>
    </div>
    @else
    <div class="alert alert-warning d-flex align-items-center mb-0" style="max-width: 80%;">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <span>Nenhuma Empresa Selecionada</span>
    </div>
    @endif
</div>
@endcan
<br>

<div class="row">
    <div class="col-lg-3 col-12 mb-3">
        <div class="fi-card" style="--accent: var(--fi-orange);">
            <div class="fi-card-icon"><i class="fas fa-users"></i></div>
            <div class="fi-card-content">
                <h3>{{ $clientes }}</h3>
                <p>Clientes</p>
                <a href="/clientes" class="fi-card-link">Mais informações <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-12 mb-3">
        <div class="fi-card" style="--accent: var(--fi-orange);">
            <div class="fi-card-icon"><i class="fas fa-coins"></i></div>
            <div class="fi-card-content">
                <h3><sup class="fi-currency">R$</sup>{{ $totalReceitas }}</h3>
                <p>Total de receitas</p>
                <a href="/movimentos" class="fi-card-link">Mais informações <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-12 mb-3">
        <div class="fi-card" style="--accent: var(--fi-blue);">
            <div class="fi-card-icon"><i class="fas fa-file-invoice-dollar"></i></div>
            <div class="fi-card-content">
                <h3><sup class="fi-currency">R$</sup>{{ $totalDespesas }}</h3>
                <p>Total de despesas</p>
                <a href="/movimentos" class="fi-card-link">Mais informações <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-12 mb-3">
        <div class="fi-card" style="--accent: var(--fi-dark);">
            <div class="fi-card-icon"><i class="fas fa-chart-line"></i></div>
            <div class="fi-card-content">
                <h3><sup class="fi-currency">R$</sup>{{ $totalReceitas -  $totalDespesas }}</h3>
                <p>Previsão de resultado</p>
                <a href="/movimentos" class="fi-card-link">Mais informações <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>


<div class="row mt-4">
    <div class="col-md-12">
        <canvas id="myChart"></canvas>
    </div>
</div>

@stop

@section('css')
<style>
    :root{
        --fi-orange:#FF6B1A;
        --fi-dark:#111111;
        --fi-gray:#6B7280;
        --fi-gray-100:#F3F4F6;
        --fi-white:#FFFFFF;
        --fi-blue:#2563EB;
    }

    /* Dropdown */
    .dropdown-menu a.dropdown-item:hover {
        background-color: var(--fi-gray-100);
        color: var(--fi-dark);
    }

    /* Primary button aligned to palette */
    .btn-primary{
        background-color: var(--fi-orange);
        border-color: var(--fi-orange);
    }
    .btn-primary:hover,
    .btn-primary:focus{
        background-color: #e85f14;
        border-color: #e85f14;
    }
    .dropdown-toggle::after { display: none; }

    /* Custom FI cards */
    .fi-card{
        position: relative;
        display:flex;
        gap: 12px;
        align-items: center;
        background: var(--fi-white);
        border:1px solid var(--fi-gray-100);
        border-left:6px solid var(--accent, var(--fi-orange));
        border-radius:12px;
        padding:18px 16px;
        box-shadow: 0 4px 14px rgba(17,17,17,0.06);
        transition: transform .15s ease, box-shadow .15s ease;
        min-height: 110px;
    }
    .fi-card:hover{
        transform: translateY(-2px);
        box-shadow: 0 10px 22px rgba(17,17,17,0.10);
    }
    .fi-card-icon{
        flex: 0 0 auto;
        width: 48px; height: 48px;
        border-radius: 10px;
        display:flex; align-items:center; justify-content:center;
        background: linear-gradient(140deg, var(--accent, var(--fi-orange)) 0%, rgba(0,0,0,0.0) 100%);
        color: var(--fi-white);
    }
    .fi-card-icon i{ font-size: 22px; }
    .fi-card-content h3{
        margin:0;
        font-size: 26px;
        color: var(--fi-dark);
        line-height: 1.1;
        font-weight: 800;
    }
    .fi-card-content p{
        margin:4px 0 10px;
        color: var(--fi-gray);
        font-size: 14px;
    }
    .fi-card-link{
        font-size: 13px;
        font-weight: 600;
        color: var(--accent, var(--fi-orange));
        text-decoration: none;
    }
    .fi-card-link:hover{ text-decoration: underline; }
    .fi-currency{ font-size: 16px; margin-right: 4px; top: -6px; position: relative; }

    /* Page tweaks */
    body { background-color: var(--fi-white); }
    h1, h3 { color: var(--fi-dark); }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<script>

    const dadosGrafico = @json($dadosGrafico);

    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: dadosGrafico.meses,
            datasets: [{
                    label: 'Receitas',
                    data: dadosGrafico.receitas,
                    backgroundColor: 'rgba(255, 107, 26, 0.20)',   // var(--fi-orange) @ 20%
                    borderColor: 'rgba(255, 107, 26, 1)',          // var(--fi-orange)
                    borderWidth: 2
                },
                {
                    label: 'Despesas',
                    data: dadosGrafico.despesas,
                    backgroundColor: 'rgba(37, 99, 235, 0.20)',    // var(--fi-blue) @ 20%
                    borderColor: 'rgba(37, 99, 235, 1)',           // var(--fi-blue)
                    borderWidth: 2
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
@stop
