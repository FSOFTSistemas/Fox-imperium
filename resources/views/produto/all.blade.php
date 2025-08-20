@extends('adminlte::page')

@section('title', 'Produtos')

@section('content_header')
    <h1>Produtos</h1>
@stop

@section('content')
    @can('acesso total')
        <div class="row" style="margin-bottom: 2%">
            <div class="col d-flex gap-2">
                <a class="btn btn-primary mr-2" href="{{ route('produtos.create') }}">+ Novo produto</a>

                <div class="btn-group">
                    <button type="button" class="btn btn-outline-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-file-import"></i> Importar
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#importCsvModal">
                            <i class="fas fa-file-csv"></i> Importar CSV
                        </a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#importXmlModal">
                            <i class="fas fa-file-code"></i> Importar XML
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    <!-- Modal: Import CSV -->
    <div class="modal fade" id="importCsvModal" tabindex="-1" role="dialog" aria-labelledby="importCsvModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('produtos.import.csv') }}" method="POST" enctype="multipart/form-data" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="importCsvModalLabel">Importar Produtos via CSV</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-2">Faça upload de um arquivo <strong>.csv</strong> com cabeçalho.</p>
                    <div class="alert alert-light border">
                        <strong>Campos sugeridos:</strong> <code>descricao, precocusto, precovenda, estoque, codbarra, unidade, ncm, cst, cfop</code>
                    </div>
                    <div class="form-group">
                        <label for="csvFile">Arquivo CSV</label>
                        <input type="file" class="form-control-file" id="csvFile" name="file" accept=".csv" required>
                    </div>
                    <small class="text-muted">Separador padrão: vírgula. Codificação: UTF-8. Use ponto para decimais (ex.: 12.34).</small>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('produtos.import.csv.template') }}" class="btn btn-link">Baixar modelo CSV</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Importar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Import XML -->
    <div class="modal fade" id="importXmlModal" tabindex="-1" role="dialog" aria-labelledby="importXmlModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('produtos.import.xml') }}" method="POST" enctype="multipart/form-data" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="importXmlModalLabel">Importar Produtos via XML</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-2">Faça upload de um arquivo <strong>.xml</strong>.</p>
                    <div class="alert alert-light border">
                        <strong>Indicado para:</strong> XMLs de NF-e/NFC-e (itens), catálogos exportados ou integrações específicas.<br>
                        O parser deve mapear: descrição, NCM, CFOP, unidade, valor unitário, quantidade e código de barras (quando houver).
                    </div>
                    <div class="form-group">
                        <label for="xmlFile">Arquivo XML</label>
                        <input type="file" class="form-control-file" id="xmlFile" name="file" accept=".xml" required>
                    </div>
                    <small class="text-muted">Certifique-se de que o XML segue o layout esperado (ex.: itens de produto).</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Importar</button>
                </div>
            </form>
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
            ],
        ],
        'itemsPerPage' => 50,
        'showTotal' => false,
        'valueColumnIndex' => 4,
    ])
        <thead class="table-primary">
            <tr>
                <th>Descricao</th>
                <th>P. Custo</th>
                <th>P. Venda</th>
                <th>Estoque</th>
                <th>Markup</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produtos as $p)
                <tr>
                    <td>{{ $p->descricao }}</td>
                    <td>{{ $p->precocusto }}</td>
                    <td>{{ $p->precovenda }}</td>
                    <td>{{ $p->estoque }}</td>
                    @php
                        $markup = ($p->precocusto > 0)
                            ? (($p->precovenda - $p->precocusto) / $p->precocusto) * 100
                            : null;
                    @endphp
                    <td>
                        @if(!is_null($markup))
                            {{ number_format($markup, 2, ',', '.') }}%
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <!-- Botão Visualizar -->
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                            data-target="#viewModal{{ $p->id }}" title="Visualizar">
                            <i class="fas fa-eye"></i>
                        </button>

                        <!-- Modal de Visualização -->
                        <div class="modal fade" id="viewModal{{ $p->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="viewModalLabel{{ $p->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewModalLabel{{ $p->id }}">Visualizar Produto</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Descrição:</strong> {{ $p->descricao }}</p>
                                        <p><strong>Preço Custo:</strong> R$ {{ number_format($p->precocusto, 2, ',', '.') }}
                                        </p>
                                        <p><strong>Preço Venda:</strong> R$ {{ number_format($p->precovenda, 2, ',', '.') }}
                                        </p>
                                        <p><strong>Estoque:</strong> {{ $p->estoque }}</p>
                                        <p><strong>Código de Barras:</strong> {{ $p->codbarra ?? '-' }}</p>
                                        <p><strong>Unidade:</strong> {{ $p->unidade ?? '-' }}</p>
                                        <p><strong>NCM:</strong> {{ $p->ncm ?? '-' }}</p>
                                        <p><strong>CST:</strong> {{ $p->cst ?? '-' }}</p>
                                        <p><strong>CFOP:</strong> {{ $p->cfop ?? '-' }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @can('acesso total')
                            <!-- Botão Editar -->
                            <a href="{{ route('produtos.edit', $p->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>

                            <!-- Botão Deletar com Modal -->
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                data-target="#deleteModal{{ $p->id }}" title="Excluir">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        @endcan
                        <!-- Modal de Exclusão -->
                        <div class="modal fade" id="deleteModal{{ $p->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="deleteModalLabel{{ $p->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel{{ $p->id }}">Confirmar Exclusão
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Tem certeza de que deseja excluir o produto <strong>{{ $p->descricao }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('produtos.destroy', $p->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Excluir</button>
                                        </form>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    @endcomponent
@stop

@section('css')

@stop

@section('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@stop
