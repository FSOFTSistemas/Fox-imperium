@extends('adminlte::page')

@section('title', 'Fornecedores')

@section('content_header')

@stop

@section('content')
    <div class="row" style="margin-bottom: 2%">
        @can('acesso total')
            <div class="col">
                <a class="btn btn-primary" href="{{ route('fornecedores.create') }}">+ Novo fornecedor</a>
            </div>
        @endcan
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
        ],
        'itemsPerPage' => 50,
        'showTotal' => false,
        'valueColumnIndex' => 4,
    ])
        <thead class="table-primary">
            <tr>
                <th>Nome</th>
                <th>Endereco</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fornecedores as $f)
                <tr>
                    <td>{{ $f->nome }}</td>
                    <td>{{ $f->endereco }}</td>
                    <td>{{ $f->telefone }}</td>
                    <td>
                        <!-- Botão para visualizar -->
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal{{ $f->id }}">
                            <i class="fas fa-eye"></i>
                        </button>
                        @can('acesso total')
                            <!-- Botão para editar -->
                            <a href="{{ route('fornecedores.edit', $f->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>

                            <!-- Botão para deletar -->
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $f->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        @endcan
                    </td>
                </tr>

                <!-- Modal de Visualização -->
                <div class="modal fade" id="viewModal{{ $f->id }}" tabindex="-1"
                    aria-labelledby="viewModalLabel{{ $f->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewModalLabel{{ $f->id }}">Detalhes do Fornecedor</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Nome:</strong> {{ $f->nome }}</p>
                                <p><strong>CNPJ:</strong> {{ $f->cnpj }}</p>
                                <p><strong>Telefone:</strong> {{ $f->telefone }}</p>
                                <!-- Inclua outros campos que você deseja mostrar aqui -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal de Exclusão -->
                <div class="modal fade" id="deleteModal{{ $f->id }}" tabindex="-1"
                    aria-labelledby="deleteModalLabel{{ $f->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $f->id }}">Confirmar Exclusão</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Tem certeza de que deseja excluir o fornecedor <strong>{{ $f->nome }}</strong>?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <form method="POST" action="{{ route('fornecedores.destroy', $f->id) }}">
                                    @csrf
                                    @method('DELETE')
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
@stop
