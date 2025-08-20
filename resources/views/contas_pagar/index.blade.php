@extends('adminlte::page')

@section('title', 'Contas a Pagar')

@section('content_header')
    <h1>Contas a Pagar</h1>
@endsection

@section('content')
    @can('acesso total')
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Nova Conta</button>
    @endcan

    {{-- DataTable --}}
    @component('components.data-table', [
        'itemsPerPage' => 10,
        'showTotal' => true,
        'valueColumnIndex' => 2,
        'responsive' => [],
    ])
        <thead>
            <tr>
                <th>#</th>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Data de Vencimento</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contas as $conta)
                <tr>
                    <td>{{ $conta->id }}</td>
                    <td>{{ $conta->descricao }}</td>
                    <td>{{ number_format($conta->valor, 2, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($conta->data_vencimento)->format('d/m/Y') }}</td>
                    <td>{{ ucfirst($conta->status) }}</td>
                    @can('acesso total')
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $conta->id }}"><i class="fas fa-edit"></i></button>

                            <form action="{{ route('contas-a-pagar.destroy', $conta->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    @endcan
                </tr>

                {{-- Modal de edição --}}
                @include('contas_pagar.modals.edit', ['conta' => $conta])
            @endforeach
        </tbody>
    @endcomponent

    {{-- Modal de criação --}}
    @include('contas_pagar.modals.create')
@endsection
