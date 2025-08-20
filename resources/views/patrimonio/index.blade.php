@extends('adminlte::page')

@section('title', 'Patrimônios')

@section('content_header')
    <h1>Lista de Patrimônios</h1>
@stop

@section('content')
    @can('acesso total')
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCreate">Novo Patrimônio</button>
    @endcan
    @component('components.data-table', [
        'itemsPerPage' => 10,
        'showTotal' => true,
        'valueColumnIndex' => 4,
        'responsive' => [
            [
                'targets' => -1,
                'orderable' => false,
                'searchable' => false,
                'className' => 'text-center',
            ],
        ],
    ])
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Empresa</th>
                <th>Valor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($patrimonios as $patrimonio)
                <tr>
                    <td>{{ $patrimonio->id }}</td>
                    <td>{{ $patrimonio->nome }}</td>
                    <td>{{ $patrimonio->descricao }}</td>
                    <td>{{ $patrimonio->empresa->razao_social }}</td>
                    <td>{{ number_format($patrimonio->valor, 2, ',', '.') }}</td>
                    <td>
                            @can('acesso total')
                            <!-- Botão de edição -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modalEdit-{{ $patrimonio->id }}">
                                <i class="fas fa-edit"></i>
                            </button>

                            <!-- Formulário de exclusão -->
                            <form action="{{ route('patrimonios.destroy', $patrimonio->id) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                            </form>
                            @endcan
                        </td>
                </tr>
            @endforeach
        </tbody>
    @endcomponent

    <!-- Modal de criação -->
    <div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('patrimonios.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCreateLabel">Novo Patrimônio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('patrimonio._form', ['patrimonio' => null])
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de edição -->
    @foreach ($patrimonios as $patrimonio)
        <div class="modal fade" id="modalEdit-{{ $patrimonio->id }}" tabindex="-1"
            aria-labelledby="modalEditLabel-{{ $patrimonio->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('patrimonios.update', $patrimonio->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditLabel-{{ $patrimonio->id }}">Editar Patrimônio</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @include('patrimonio._form', ['patrimonio' => $patrimonio])
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@stop
