<div class="mb-3">
    <label for="nome" class="form-label">Nome</label>
    <input type="text" name="nome" id="nome" class="form-control" value="{{ old('nome', $patrimonio?->nome) }}" required>
</div>
<div class="mb-3">
    <label for="descricao" class="form-label">Descrição</label>
    <textarea name="descricao" id="descricao" class="form-control" rows="3" required>{{ old('descricao', $patrimonio?->descricao) }}</textarea>
</div>
<div class="mb-3">
    <label for="empresa_id" class="form-label">Empresa</label>
    <select name="empresa_id" id="empresa_id" class="form-select" required>
        <option value="" disabled {{ $patrimonio ? '' : 'selected' }}>Selecione uma empresa</option>
        @foreach ($empresas as $empresa)
            <option value="{{ $empresa->id }}" {{ $patrimonio && $patrimonio->empresa_id == $empresa->id ? 'selected' : '' }}>
                {{ $empresa->razao_social }}
            </option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label for="valor" class="form-label">Valor</label>
    <input type="number" step="0.01" name="valor" id="valor" class="form-control" value="{{ old('valor', $patrimonio?->valor) }}" required>
</div>
<div class="mb-3">
    <label for="data_aquisicao" class="form-label">Data de aquisição</label>
    <input type="date" name="data_aquisicao" id="data_aquisicao" class="form-control" value="{{ old('data_aquisicao', $patrimonio?->data_aquisicao) }}" required>
</div>