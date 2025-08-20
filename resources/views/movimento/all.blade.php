@extends('adminlte::page')

@section('title', 'Movimentos Financeiros')

@section('content_header')
    <h1>Movimentos Financeiros</h1>
@stop

@section('content')
    <div class="row mb-3">
        @can('acesso total')
            <div class="col d-flex justify-content-start">
                <!-- Botão para abrir o modal de nova venda -->
                <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#newMovementModal">
                    + Novo Movimento
                </button>
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
                'targets' => 5,
            ],
            [
                'responsivePriority' => 5,
                'targets' => 4,
            ],
        ],
        'itemsPerPage' => 50,
        'showTotal' => true,
        'valueColumnIndex' => 4,
    ])
        <thead class="table-primary">
            <tr>
                <th>Descrição</th>
                <th>Tipo</th>
                <th>Data</th>
                <th>Forma de Pagamento</th>
                <th>Valor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movimentos as $movimento)
                <tr>
                    <td>{{ $movimento->descricao }}</td>
                    <td>
                        @if ($movimento->tipo === 'despesa')
                            <span class="badge bg-danger">Despesas</span>
                        @elseif ($movimento->tipo === 'receita')
                            <span class="badge bg-success">Receitas</span>
                        @elseif ($movimento->tipo === 'cmv')
                            <span class="badge bg-primary">CMV</span>
                        @else
                            <span class="badge bg-secondary">{{ ucfirst($movimento->tipo) }}</span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($movimento->data)->format('d/m/Y') }}</td>
                    <td>{{ $movimento->forma_pagamento }}</td>
                    <td>{{ number_format($movimento->valor, 2, ',', '.') }}</td>
                    <td>
                        <!-- Botão de Visualizar -->
                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                            data-bs-target="#viewModal{{ $movimento->id }}" title="Visualizar">
                            <i class="fas fa-eye"></i>
                        </button>
                        @can('acesso total')
                            <!-- Botão de Editar -->
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $movimento->id }}" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>

                            <!-- Botão de Excluir -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $movimento->id }}" title="Excluir">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    @endcomponent

    <!-- Modal de Novo Movimento -->
    <div class="modal fade" id="newMovementModal" tabindex="-1" aria-labelledby="newMovementModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newMovementModalLabel">Novo Movimento/Venda</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('movimentos.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="descricao">Descrição</label>
                            <input type="text" class="form-control" id="descricao" name="descricao" required>
                        </div>

                        <div class="form-group">
                            <label for="tipo">Tipo</label>
                            <select class="form-control" id="tipo" name="tipo" required>
                                <option value="despesa">Despesa</option>
                                <option value="receita">Receita</option>
                                <option value="cmv">CMV</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="planodecontas">Plano de contas</label>
                            <select class="form-control" id="planodecontas" name="planodecontas" required>
                                @foreach ($planodecontas as $plano)
                                    <option value="{{ $plano->id }}">{{ $plano->descricao }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="data">Data</label>
                            <input type="date" class="form-control" id="data" name="data" required>
                        </div>

                        <div class="form-group">
                            <label for="forma_pagamento">Forma de Pagamento</label>
                            <select class="form-control" id="forma_pagamento" name="forma_pagamento" required>
                                <option value="dinheiro">Dinheiro</option>
                                <option value="cartao">Cartão</option>
                            </select>
                        </div>

                        <!-- Campo de Vencimento (será exibido apenas se a forma de pagamento for 'cartao') -->
                        <div class="form-group" id="vencimento_div" style="display: none;">
                            <label for="vencimento">Data de Vencimento</label>
                            <input type="date" class="form-control" id="vencimento" name="vencimento">
                        </div>

                        <div class="form-group">
                            <label for="valor">Valor</label>
                            <input type="number" class="form-control" id="valor" name="valor" step="0.01"
                                required>
                        </div>

                        <div class="form-group">
                            {{-- <label for="empresa_id">Empresa</label> --}}
                            <select class="form-control" id="empresa_id" name="empresa_id" hidden required>
                                @foreach ($empresas as $empresa)
                                    <option value="{{ $empresa->id }}">{{ $empresa->razao_social }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Script para exibir o campo de vencimento se a forma de pagamento for 'cartao'
        document.getElementById('forma_pagamento').addEventListener('change', function() {
            var formaPagamento = this.value;
            var vencimentoDiv = document.getElementById('vencimento_div');

            if (formaPagamento === 'cartao') {
                vencimentoDiv.style.display = 'block'; // Exibe o campo de vencimento
            } else {
                vencimentoDiv.style.display = 'none'; // Oculta o campo de vencimento
            }
        });
    </script>

    <!-- Modal de Visualização -->
    @foreach ($movimentos as $movimento)
        <div class="modal fade" id="viewModal{{ $movimento->id }}" tabindex="-1" role="dialog"
            aria-labelledby="viewModalLabel{{ $movimento->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModalLabel{{ $movimento->id }}">Visualizar Movimento/Venda</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Descrição:</strong> {{ $movimento->descricao }}</p>
                        <p><strong>Tipo:</strong> {{ $movimento->tipo }}</p>
                        <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($movimento->data)->format('d/m/Y') }}</p>
                        <p><strong>Forma de Pagamento:</strong> {{ $movimento->forma_pagamento }}</p>
                        <p><strong>Valor:</strong> {{ number_format($movimento->valor, 2, ',', '.') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modal de Excluir -->
    @foreach ($movimentos as $movimento)
        <div class="modal fade" id="deleteModal{{ $movimento->id }}" tabindex="-1" role="dialog"
            aria-labelledby="deleteModalLabel{{ $movimento->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{ $movimento->id }}">Excluir Movimento/Venda</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Você tem certeza que deseja excluir o movimento <strong>{{ $movimento->descricao }}</strong>?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('movimentos.destroy', $movimento) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Excluir</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modal de Editar Movimento -->
    @foreach ($movimentos as $movimento)
        <div class="modal fade" id="editModal{{ $movimento->id }}" tabindex="-1"
            aria-labelledby="editModalLabel{{ $movimento->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel{{ $movimento->id }}">Editar Movimento/Venda</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('movimentos.update', $movimento->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="descricao">Descrição</label>
                                <input type="text" class="form-control" id="descricao" name="descricao"
                                    value="{{ $movimento->descricao }}" required>
                            </div>

                            <div class="form-group">
                                <label for="tipo">Tipo</label>
                                <select class="form-control" id="tipo" name="tipo" required>
                                    <option value="despesa" {{ $movimento->tipo == 'despesa' ? 'selected' : '' }}>Despesa
                                    </option>
                                    <option value="receita" {{ $movimento->tipo == 'receita' ? 'selected' : '' }}>Receita
                                    </option>
                                    <option value="cmv" {{ $movimento->tipo == 'cmv' ? 'selected' : '' }}>CMV</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="planodecontas">Plano de contas</label>
                                <select class="form-control" id="planodecontas" name="planodecontas" required>
                                    @foreach ($planodecontas as $plano)
                                        <option value="{{ $plano->id }}"
                                            {{ $plano->id == $movimento->planodecontas_id ? 'selected' : '' }}>
                                            {{ $plano->descricao }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="data">Data</label>
                                <input type="date" class="form-control" id="data" name="data"
                                    value="{{ \Carbon\Carbon::parse($movimento->data)->format('Y-m-d') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="forma_pagamento">Forma de Pagamento</label>
                                <select class="form-control" id="forma_pagamento" name="forma_pagamento" required>
                                    <option value="boleto"
                                        {{ $movimento->forma_pagamento == 'boleto' ? 'selected' : '' }}>Boleto</option>
                                    <option value="cartao"
                                        {{ $movimento->forma_pagamento == 'cartao' ? 'selected' : '' }}>Cartão</option>
                                    <option value="dinheiro"
                                        {{ $movimento->forma_pagamento == 'dinheiro' ? 'selected' : '' }}>Dinheiro</option>
                                    <option value="transferencia"
                                        {{ $movimento->forma_pagamento == 'transferencia' ? 'selected' : '' }}>
                                        Transferência</option>
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="valor">Valor</label>
                                <input type="number" class="form-control" id="valor" name="valor"
                                    value="{{ $movimento->valor }}" step="0.01" required>
                            </div>

                            <div class="form-group">
                                {{-- <label for="empresa_id">Empresa</label> --}}
                                <select class="form-control" id="empresa_id" name="empresa_id" hidden required>
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ $empresa->id }}"
                                            {{ $empresa->id == $movimento->empresa_id ? 'selected' : '' }}>
                                            {{ $empresa->razao_social }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

@stop

@section('css')
    <link rel="stylesheet"
        href="{{ asset('vendor/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('vendor/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
            });
        });
    </script>
    <script>
        // Script para exibir o campo de vencimento se a forma de pagamento for 'cartao'
        document.getElementById('forma_pagamento').addEventListener('change', function() {
            var formaPagamento = this.value;
            var vencimentoDiv = document.getElementById('vencimento_div');
            if (formaPagamento === 'cartao') {
                vencimentoDiv.style.display = 'block'; // Exibe o campo de vencimento
            } else {
                vencimentoDiv.style.display = 'none'; // Oculta o campo de vencimento
            }
        });
    </script>
@stop
