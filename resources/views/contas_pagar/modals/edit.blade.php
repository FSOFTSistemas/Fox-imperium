<div class="modal fade" id="editModal{{ $conta->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('contas-a-pagar.update', $conta->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Conta a Pagar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <input type="text" class="form-control" id="descricao" name="descricao" value="{{ $conta->descricao }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="valor" class="form-label">Valor</label>
                        <input type="number" class="form-control" id="valor" name="valor" value="{{ $conta->valor }}" required step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="data_vencimento" class="form-label">Data de Vencimento</label>
                        <input type="date" class="form-control" id="data_vencimento" name="data_vencimento" value="{{ $conta->data_vencimento }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pendente" {{ $conta->status == 'pendente' ? 'selected' : '' }}>Pendente</option>
                            <option value="pago" {{ $conta->status == 'pago' ? 'selected' : '' }}>Pago</option>
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