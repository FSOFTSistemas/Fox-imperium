@extends('adminlte::page')

@section('title', 'Gestão de Usuários')

@section('content_header')
@stop

@section('content')

{{-- Botão para abrir o modal de criação --}}
<br>
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createUserModal">
    <i class="fas fa-user-plus"></i> Adicionar Usuário
</button>

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
        <th>Nome</th>
        <th>Email</th>
        <th>Função</th>
        <th>Ações</th>
    </tr>
</thead>
<tbody>
    @foreach ($usuarios as $usuario)
    <tr>
        <td>{{ $usuario->name }}</td>
        <td>{{ $usuario->email }}</td>
        <td>{{ $usuario->role }}</td>

        <td>
            <!-- Botão Editar com Modal -->
            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $usuario->id }}"
                data-id="{{ $usuario->id }}" data-name="{{ $usuario->name }}" data-email="{{ $usuario->email }}"
                data-role="{{ $usuario->role }}" title="Editar">
                <i class="fas fa-edit"></i>
            </button>

            <!-- Modal de Edição -->
            <div class="modal fade" id="editModal{{ $usuario->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $usuario->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $usuario->id }}">Editar Usuário</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Campo Nome -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="editName{{ $usuario->id }}" name="name" value="{{ $usuario->name }}" required>
                                </div>

                                <!-- Campo Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="editEmail{{ $usuario->id }}" name="email" value="{{ $usuario->email }}" required>
                                </div>

                                <!-- Campo Função -->
                                <div class="mb-3">
                                    <label for="role" class="form-label">Função</label>
                                    <select class="form-control" id="editRole{{ $usuario->id }}" name="role" required>
                                        <option value="admin" {{ $usuario->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="user" {{ $usuario->role == 'user' ? 'selected' : '' }}>User</option>
                                    </select>
                                </div>

                                <!-- Campo Senha (opcional) -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Senha</label>
                                    <input type="password" class="form-control" id="editPassword{{ $usuario->id }}" name="password">
                                    <small>Minimo de 6 caracteres</small>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Atualizar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Botão Excluir com Modal -->
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $usuario->id }}" title="Excluir">
                <i class="fas fa-trash"></i>
            </button>

            <!-- Modal de Exclusão -->
            <div class="modal fade" id="deleteModal{{ $usuario->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $usuario->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel{{ $usuario->id }}">Excluir Usuário</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Você tem certeza que deseja excluir o usuário <strong>{{ $usuario->name }}</strong>?</p>
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Excluir</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
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



{{-- Modal para criação --}}
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('usuarios.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Adicionar Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Função</label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="admin">Admin</option>
                            <option value="user">Usuário</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="empresa_id" class="form-label">Empresa</label>
                        <select class="form-control @error('empresa_id') is-invalid @enderror" id="empresa_id" name="empresa_id" required>
                            <option value="">Selecione uma empresa</option>
                            @foreach($empresas as $empresa)
                            <option value="{{ $empresa->id }}">
                                {{ $empresa->razao_social }}
                            </option>
                            @endforeach
                        </select>
                        <small style="color: red">Atenção: selecione a empresa</small>
                        @error('empresa_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>


@stop

@section('js')

@stop
