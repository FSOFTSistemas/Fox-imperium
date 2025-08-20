@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
    @if (Session::has('sweetalert.alert'))
        <script>
            let config = {!! Session::pull('sweetalert.alert') !!}
            Swal.fire(config)
        </script>
    @endif
@stop

@section('content')
    <div class="row" style="margin-bottom: 2%">
        @can('acesso total')
            <div class="col">
                <a class="btn btn-primary" href="{{ route('clientes.create') }}">+ Novo Cliente</a>
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
            [
                'responsivePriority' => 4,
                'targets' => -1,
            ],
        ],
        'itemsPerPage' => 50,
        'showTotal' => false,
        'valueColumnIndex' => 4,
    ])
        <thead class="table-primary">
            <tr>
                <th>Nome</th>
                <th>Telefone</th>
                <th>Cidade</th>
                <th>Empresa</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->nome }}</td>
                    <td>{{ $cliente->telefone }}</td>
                    <td>{{ $cliente->cidade }}</td>
                    <td>{{ $cliente->empresa->razao_social }}</td>
                    <td>
                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                            data-bs-target="#viewClienteModal{{ $cliente->id }}">
                            👁️
                        </button>
                        @can('acesso total')
                            <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning btn-sm">
                                ✏️
                            </a>

                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#deleteClienteModal{{ $cliente->id }}">
                                🗑️
                            </button>
                        @endcan
                    </td>
                </tr>

                <!-- Modal Visualizar Cliente -->
                <div class="modal fade" id="viewClienteModal{{ $cliente->id }}" tabindex="-1"
                    aria-labelledby="viewClienteModalLabel{{ $cliente->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewClienteModalLabel{{ $cliente->id }}">Detalhes do Cliente</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Nome:</strong> {{ $cliente->nome }}</p>
                                <p><strong>Email:</strong> {{ $cliente->email }}</p>
                                <p><strong>Telefone:</strong> {{ $cliente->telefone }}</p>
                                <p><strong>Endereço:</strong> {{ $cliente->endereco }}</p>
                                <p><strong>Cidade:</strong> {{ $cliente->cidade }}</p>
                                <p><strong>Estado:</strong> {{ $cliente->estado }}</p>
                                <p><strong>Empresa:</strong> {{ $cliente->empresa->razao_social }}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Excluir Cliente -->
                <div class="modal fade" id="deleteClienteModal{{ $cliente->id }}" tabindex="-1"
                    aria-labelledby="deleteClienteModalLabel{{ $cliente->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteClienteModalLabel{{ $cliente->id }}">Excluir Cliente</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Tem certeza de que deseja excluir o cliente <strong>{{ $cliente->nome }}</strong>?</p>
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('clientes.destroy', $cliente) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Excluir</button>
                                </form>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
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



@stop
