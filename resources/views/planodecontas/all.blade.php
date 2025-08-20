@extends('adminlte::page')

@section('title', 'Plano de contas')

@section('content_header')
<h1>Plano de contas</h1>
@stop

@section('content')
<div class="row" style="margin-bottom: 2%">
    <div class="col">
        <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#createModal">+ Novo Plano de Conta</a>
    </div>
</div>

@component('components.data-table', [
'responsive' => [
[
'responsivePriority' => 1,
'targets' => 0,
],
[
'responsivePriority' => 2,
'targets' => 1,
],
],
'itemsPerPage' => 50,
'showTotal' => false,
'valueColumnIndex' => 4,
])
<thead class="table-primary">
    <tr>
        <th>Descricao</th>
        <th>Tipo</th>
        <th>Ações</th>
    </tr>
</thead>
<tbody>
    @foreach ($planodecontas as $p)
    <tr>
        <td>{{ $p->descricao }}</td>
        <td>{{ $p->tipo }}</td>

        <td>
            <!-- Botão Editar com Modal -->
            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal{{ $p->id }}" title="Editar">
                <i class="fas fa-edit"></i>
            </button>

            <!-- Modal de Edição -->
            <div class="modal fade" id="editModal{{ $p->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $p->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $p->id }}">Editar Plano de Conta</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('planos-de-contas.update', $p->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Campo Descrição -->
                                <div class="mb-3">
                                    <label for="descricao" class="form-label">Descrição</label>
                                    <input type="text" class="form-control @error('descricao') is-invalid @enderror" id="descricao" name="descricao" value="{{ $p->descricao }}" required>
                                    @error('descricao')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Campo Tipo -->
                                <div class="mb-3">
                                    <label for="tipo" class="form-label">Tipo</label>
                                    <select class="form-control @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                                        <option value="">Selecione o Tipo</option>
                                        <option value="despesa" {{ old('tipo', $p->tipo ?? '') === 'despesa' ? 'selected' : '' }}>Despesa</option>
                                        <option value="receita" {{ old('tipo', $p->tipo ?? '') === 'receita' ? 'selected' : '' }}>Receita</option>
                                    </select>
                                    @error('tipo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Atualizar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Botão Excluir com Modal -->
            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $p->id }}" title="Excluir">
                <i class="fas fa-trash"></i>
            </button>

            <!-- Modal de Exclusão -->
            <div class="modal fade" id="deleteModal{{ $p->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $p->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel{{ $p->id }}">Excluir Plano de Conta</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Você tem certeza que deseja excluir o plano de conta <strong>{{ $p->descricao }}</strong>?</p>
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('planos-de-contas.destroy', $p->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Excluir</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    @endforeach
</tbody>

@endcomponent

<!-- Modal de Inserir Novo Plano de Conta -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Inserir Novo Plano de Conta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('planos-de-contas.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="codigo" class="form-label">Código</label>
                        <input type="text" class="form-control @error('codigo') is-invalid @enderror" id="codigo" name="codigo" value="{{ old('codigo') }}" required>
                        @error('codigo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Campo Descrição -->
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <input type="text" class="form-control @error('descricao') is-invalid @enderror" id="descricao" name="descricao" value="{{ old('descricao') }}" required>
                        @error('descricao')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Campo Tipo -->
                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select class="form-control @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                            <option value="">Selecione o Tipo</option>
                            <option value="Despesa" >Despesa</option>
                            <option value="Receita" >Receita</option>
                            <option value="CMV" >CMV</option>
                        </select>
                        @error('tipo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
            </form>
        </div>
    </div>
</div>

@stop

@section('css')

@stop

@section('js')
<script>
    console.log("Hi, I'm using the Laravel-AdminLTE package!");
</script>
@stop
