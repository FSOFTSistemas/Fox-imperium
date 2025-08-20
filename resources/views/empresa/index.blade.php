@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')
<div class="row" style="margin-bottom: 2%">
    <div class="col">
        <a class="btn btn-success btn-sm shadow-sm px-3 py-2 d-inline-flex align-items-center" href="{{ route('empresas.create') }}">
            <i class="fas fa-plus-circle me-1"></i>
            Nova Empresa
        </a>
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
            [
                'responsivePriority' => 3,
                'targets' => 2,
            ],
            [
                'responsivePriority' => 4,
                'targets' => -1,
            ],
            [
                'responsivePriority' => 5,
                'targets' => 3,
            ]
        ],
        'itemsPerPage' => 50,
        'showTotal' => false,
        'valueColumnIndex' => 4,
    ])
    <thead class="table-primary">
        <tr>
            <th>Razão Social</th>
            <th>CNPJ</th>
            <th>Telefone</th>
            <th>E-mail</th>
            <th>Cidade</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($empresas as $emp)
            <tr>
                <td>{{ $emp->razao_social }}</td>
                <td>{{ $emp->cnpj }}</td>
                <td>{{ $emp->telefone }}</td>
                <td>{{ $emp->email }}</td>
                <td>{{ $emp->cidade }}</td>
                <td>
                    <!-- Botão de Visualizar -->
                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal{{ $emp->id }}" title="Visualizar">
                        <i class="fas fa-eye"></i>
                    </button>

                    <!-- Botão de Editar -->
                    <a href="{{ route('empresas.edit', $emp) }}" class="btn btn-warning btn-sm" title="Editar">
                        <i class="fas fa-edit"></i>
                    </a>

                    <!-- Botão de Excluir -->
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $emp->id }}" title="Excluir">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            </tr>

            <!-- Modal de Visualização -->
            <div class="modal fade" id="viewModal{{ $emp->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $emp->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-info text-white">
                            <h5 class="modal-title" id="viewModalLabel{{ $emp->id }}">Visualizar Empresa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Razão Social:</strong> {{ $emp->razao_social }}</p>
                            <p><strong>CNPJ:</strong> {{ $emp->cnpj }}</p>
                            <p><strong>Telefone:</strong> {{ $emp->telefone }}</p>
                            <p><strong>E-mail:</strong> {{ $emp->email }}</p>
                            <p><strong>Cidade:</strong> {{ $emp->cidade }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal de Exclusão -->
            <div class="modal fade" id="deleteModal{{ $emp->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $emp->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="deleteModalLabel{{ $emp->id }}">Confirmar Exclusão</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Tem certeza que deseja excluir a empresa <strong>{{ $emp->razao_social }}</strong>?</p>
                        </div>
                        <div class="modal-footer">
                            <form method="POST" action="{{ route('empresas.destroy', $emp->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-danger">Excluir</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </tbody>
@endcomponent
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
    console.log("Hi, I'm using the Laravel-AdminLTE package!");
</script>
@stop
