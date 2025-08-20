@extends('adminlte::page')

@section('title', 'DRE')

@section('content_header')
<h1>Demonstrativo de Resultados do Exercício (DRE)</h1>
@stop

@section('content')
<div class="container-fluid">

    {{-- Filtros --}}
    <div class="card mb-4">
        <div class="card-header">
            <h3 class="card-title">Filtros</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('dre.dre') }}" class="form-inline">
            @csrf
                <div class="form-group mr-3">
                    <label for="data_inicio" class="mr-2">Data Início</label>
                    <input type="date" class="form-control" id="data_inicio" name="data_inicio" value="{{ request()->data_inicio }}">
                </div>
                <div class="form-group mr-3">
                    <label for="data_fim" class="mr-2">Data Fim</label>
                    <input type="date" class="form-control" id="data_fim" name="data_fim" value="{{ request()->data_fim }}">
                </div>
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </form>
        </div>
    </div>



</div>
@stop

@section('css')
{{-- Adicionando estilos adicionais --}}
<style>
    .card-title {
        font-size: 1.25rem;
    }
    .form-inline .form-control {
        max-width: 200px;
    }
    .card-body p {
        font-size: 1.1rem;
    }
</style>
@stop

@section('js')
<script>
    console.log("DRE page loaded.");
</script>
@stop
