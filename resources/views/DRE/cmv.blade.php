@extends('adminlte::page')

@section('title', 'CMV')

@section('content_header')
    <h1>CMV - Custo de Mercadoria Vendida</h1>
@stop

@section('content')
    {{-- Filtros --}}
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5>Filtros</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('filtro_cmv') }}">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <label for="start_date" class="form-label">Data Inicial</label>
                        <input type="date" name="start_date" class="form-control" id="start_date">
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label">Data Final</label>
                        <input type="date" name="end_date" class="form-control" id="end_date">
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabela com DataTable --}}
    <div class="card mt-3">
        <div class="card-header bg-secondary text-white">
            <h5>Resultados</h5>
        </div>
        <div class="card-body">
            @component('components.data-table', [
                'uniqueId' => 'cmvTable',
                'itemsPerPage' => 50,
                'showTotal' => false,
                'valueColumnIndex' => 4,
                'responsive' => [],
            ])
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resultados as $resultado)
                        <tr>
                            <td>{{ $resultado->data }}</td>
                            <td>{{ $resultado->descricao }}</td>
                            <td>{{ number_format($resultado->valor, 2, ',', '.') }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            @endcomponent
        </div>
    </div>
@stop