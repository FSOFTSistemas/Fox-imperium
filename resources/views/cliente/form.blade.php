@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')

@php
$isEdit = isset($cliente); // Verifica se estamos em modo de edição
@endphp

<form method="POST" action="{{ $isEdit ? route('clientes.update', $cliente->id) : route('clientes.store') }}">
    @csrf

    @if ($isEdit)
    @method('PUT')
    @endif

    <div class="form-group mb-3">
        <label for="nome">Nome</label>
        <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome"
            name="nome" value="{{ old('nome', $cliente->nome ?? '') }}" required>
        @error('nome')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="email">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
            name="email" value="{{ old('email', $cliente->email ?? '') }}" required>
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="telefone">Telefone</label>
        <input type="text" class="form-control @error('telefone') is-invalid @enderror" id="telefone"
            name="telefone" value="{{ old('telefone', $cliente->telefone ?? '') }}">
        @error('telefone')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="cep">CEP</label>
        <div class="input-group">
            <input type="text" class="form-control @error('cep') is-invalid @enderror" id="cep"
                name="cep" value="{{ old('cep', $cliente->cep ?? '') }}">
            <button type="button" class="btn btn-outline-secondary" id="buscarCep">
                <i class="fa fa-search"></i>
            </button>
        </div>
        <small class="form-text text-muted">Digite o CEP e clique na lupa para pesquisar o endereço automaticamente.</small>
        @error('cep')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="endereco">Endereço</label>
        <input type="text" class="form-control @error('endereco') is-invalid @enderror" id="endereco"
            name="endereco" value="{{ old('endereco', $cliente->endereco ?? '') }}">
        @error('endereco')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="cidade">Cidade</label>
        <input type="text" class="form-control @error('cidade') is-invalid @enderror" id="cidade"
            name="cidade" value="{{ old('cidade', $cliente->cidade ?? '') }}">
        @error('cidade')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="estado">Estado</label>
        <input type="text" class="form-control @error('estado') is-invalid @enderror" id="estado"
            name="estado" value="{{ old('estado', $cliente->estado ?? '') }}">
        @error('estado')
        <div class="invalid-feedback">{{ $message }}</div>
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

    <button type="submit" class="btn btn-primary">
        {{ $isEdit ? 'Atualizar Cliente' : 'Cadastrar Cliente' }}
    </button>
</form>


@stop

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
    $(document).ready(function() {
        $('#cpf').mask('000.000.000-00');
        $('#telefone').mask('(00) 00000-0000');
        $('#cep').mask('00000-000');
    });
</script>
<script>
    document.getElementById('buscarCep').addEventListener('click', function() {
        var cep = document.getElementById('cep').value;

        if (!cep) {
            alert('Por favor, insira um CEP.');
            return;
        }

        fetch(`/clientes/endereco/${cep}`)
            .then(response => response.json())
            .then(data => {
                if (!data.erro) {
                    document.getElementById('endereco').value = data.logradouro;
                    document.getElementById('cidade').value = data.localidade;
                    document.getElementById('estado').value = data.uf;
                } else {
                    alert('CEP não encontrado.');
                }
            })
            .catch(error => {
                console.error('Erro ao buscar o endereço:', error);
                alert('Erro ao buscar o endereço. Tente novamente.');
            });
    });
</script>

@stop
