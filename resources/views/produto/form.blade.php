@extends('adminlte::page')

@section('title', 'Produtos')

@section('content_header')

@stop

@section('content')
<h2>{{ isset($produto) ? 'Editar Produto' : 'Cadastrar Produto' }}</h2>

<form action="{{ isset($produto) ? route('produtos.update', $produto->id) : route('produtos.store') }}" method="POST">
    @csrf
    @if(isset($produto))
    @method('PUT')
    @endif

    <div class="form-group">
        <label for="descricao">Descrição:</label>
        <input type="text" id="descricao" name="descricao" value="{{ old('descricao', $produto->descricao ?? '') }}" required>
        @error('descricao')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="precocusto">Preço de Custo:</label>
        <input type="number" step="0.01" id="precocusto" name="precocusto" value="{{ old('precocusto', $produto->precocusto ?? '') }}" required>
        @error('precocusto')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="precovenda">Preço de Venda:</label>
        <input type="number" step="0.01" id="precovenda" name="precovenda" value="{{ old('precovenda', $produto->precovenda ?? '') }}" required>
        @error('precovenda')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="estoque">Estoque:</label>
        <input type="number" id="estoque" name="estoque" value="{{ old('estoque', $produto->estoque ?? '') }}" required>
        @error('estoque')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="codbarra">Código de Barras:</label>
        <input type="text" id="codbarra" name="codbarra" value="{{ old('codbarra', $produto->codbarra ?? '') }}">
        @error('codbarra')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="unidade">Unidade:</label>
        <input type="text" id="unidade" name="unidade" value="{{ old('unidade', $produto->unidade ?? '') }}">
        @error('unidade')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="ncm">NCM:</label>
        <input type="text" id="ncm" name="ncm" value="{{ old('ncm', $produto->ncm ?? '') }}">
        @error('ncm')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="cst">CST:</label>
        <input type="text" id="cst" name="cst" value="{{ old('cst', $produto->cst ?? '') }}">
        @error('cst')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="cfop">CFOP:</label>
        <input type="text" id="cfop" name="cfop" value="{{ old('cfop', $produto->cfop ?? '') }}">
        @error('cfop')
        <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="empresa_id" class="form-label">Empresa</label>
        <select class="form-control @error('empresa_id') is-invalid @enderror" id="empresa_id" name="empresa_id" required>
            <option value="">Selecione uma empresa</option>
            @foreach($empresas as $empresa)
            <option value="{{ $empresa->id }}" {{ old('empresa_id', $fornecedor->empresa_id ?? '') == $empresa->id ? 'selected' : '' }}>
                {{ $empresa->razao_social }}
            </option>
            @endforeach
        </select>
        @error('empresa_id')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <input type="submit" value="{{ isset($produto) ? 'Atualizar Produto' : 'Salvar Produto' }}">
    </div>
</form>
@stop

@section('css')
<style>
    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .form-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        max-width: 500px;
        width: 100%;
    }

    .form-container h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .form-group input[type="text"],
    .form-group input[type="number"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .form-group input[type="submit"] {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 4px;
        background-color: #28a745;
        color: #fff;
        font-weight: bold;
        cursor: pointer;
    }

    .form-group input[type="submit"]:hover {
        background-color: #218838;
    }

    .form-group .error-message {
        color: #e74c3c;
        font-size: 0.9em;
    }
</style>
@stop

@section('js')
<script>
    console.log("Hi, I'm using the Laravel-AdminLTE package!");
</script>
@stop
