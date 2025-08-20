@extends('adminlte::page')

@section('title', 'Fornecedor')

@section('content_header')

@stop

@section('content')

<h2>{{ isset($fornecedor) ? 'Editar Fornecedor' : 'Cadastrar Fornecedor' }}</h2>
<form action="{{ isset($fornecedor) ? route('fornecedores.update', $fornecedor->id) : route('fornecedores.store') }}" method="POST">
    @csrf
    @if(isset($fornecedor))
    @method('PUT')
    @endif

    <div class="mb-3">
        <label for="nome" class="form-label">Nome do Fornecedor</label>
        <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome', $fornecedor->nome ?? '') }}" required>
        @error('nome')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="cnpj" class="form-label">CNPJ</label>
        <input type="text" class="form-control @error('cnpj') is-invalid @enderror" id="cnpj" name="cnpj" value="{{ old('cnpj', $fornecedor->cnpj ?? '') }}" >
        @error('cnpj')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $fornecedor->email ?? '') }}" required>
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="telefone" class="form-label">Telefone</label>
        <input type="text" class="form-control @error('telefone') is-invalid @enderror" id="telefone" name="telefone" value="{{ old('telefone', $fornecedor->telefone ?? '') }}" required>
        @error('telefone')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="endereco" class="form-label">Endereço</label>
        <input type="text" class="form-control @error('endereco') is-invalid @enderror" id="endereco" name="endereco" value="{{ old('endereco', $fornecedor->endereco ?? '') }}" required>
        @error('endereco')
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

    <button type="submit" class="btn btn-primary">{{ isset($fornecedor) ? 'Atualizar' : 'Cadastrar' }}</button>
</form>

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
    $(document).ready(function() {
        $('#cnpj').mask('00.000.000/0000-00');
        $('#telefone').mask('(00) 00000-0000');
    });
</script>
@endsection

@section('css')

@stop
