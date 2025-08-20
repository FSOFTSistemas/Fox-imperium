<?php

namespace App\Http\Controllers;

use App\Models\ContasAPagar;
use App\Models\Empresa;
use App\Models\Movimento;
use App\Models\PlanoDeContas;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Wavey\Sweetalert\Sweetalert;

class MovimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empresaId = session('empresa_id');

        if (!$empresaId)
        {
            $empresaId = Auth::user()->empresa_id;
        }
        try {
            $movimentos = Movimento::where('empresa_id', $empresaId)->get();
            $produtosServicos = Produto::where('empresa_id', $empresaId)->get();
            $empresas = Empresa::where('id', $empresaId)->get();
            $planodecontas = PlanoDeContas::orderBy('descricao', 'asc')->get();
            return view('movimento.all', ['movimentos' => $movimentos, 'produtosServicos' => $produtosServicos, 'empresas' => $empresas, 'planodecontas' => $planodecontas]);

        } catch (\Exception $e) {
            Sweetalert::error('Verifique se selecionou a empresa !'.$e->getMessage(), 'Error');
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try
        {
        $request->validate([
            'descricao' => 'required|string|max:255',
            'tipo' => 'required|in:despesa,receita,cmv',
            'data' => 'required|date',
            'forma_pagamento' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
            'empresa_id' => 'required|exists:empresas,id',
            'planodecontas' => 'required',
        ]);

        Movimento::create([
            'descricao' => $request->descricao,
            'tipo' => $request->tipo,
            'data' => $request->data,
            'forma_pagamento' => $request->forma_pagamento,
            'valor' => $request->valor,
            'empresa_id' => $request->empresa_id,
            'planodecontas_id' => $request->planodecontas,
        ]);

        // Se a forma de pagamento for 'cartao', adiciona à conta a pagar
        if ($request['forma_pagamento'] === 'cartao' && isset($request['vencimento'])) {
            ContasAPagar::create([
                'descricao' => $request->descricao,
                'data_vencimento' => $request->vencimento,
                'valor' => $request->valor,
                'status' => 'pendente',
                'empresa_id' => $request->empresa_id,
            ]);
        }

        Sweetalert::success('Movimento criado com sucesso!', 'Sucesso');

        return redirect()->route('movimentos.index')->with('success', 'Movimento criado com sucesso!');
    } catch (\Exception $e) {
        Sweetalert::error('Erro ao inserir movimento !'.$e->getMessage(), 'Error');
        return redirect()->back()->withInput();
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(Movimento $movimento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movimento $movimento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $movimento = Movimento::findOrFail($id);
    
            $request->validate([
                'descricao' => 'required|string|max:255',
                'tipo' => 'required|in:despesa,receita,cmv',
                'data' => 'required|date',
                'forma_pagamento' => 'required|string|max:255',
                'valor' => 'required|numeric|min:0',
                'empresa_id' => 'required|exists:empresas,id',
                'planodecontas' => 'required',
            ]);
    
            $movimento->update([
                'descricao' => $request->descricao,
                'tipo' => $request->tipo,
                'data' => $request->data,
                'forma_pagamento' => $request->forma_pagamento,
                'valor' => $request->valor,
                'empresa_id' => $request->empresa_id,
                'planodecontas_id' => $request->planodecontas
            ]);
    
            Sweetalert::success('Movimento atualizado com sucesso!', 'Sucesso');
            return redirect()->route('movimentos.index')->with('success', 'Movimento atualizado com sucesso!');
          
        } catch (\Exception $e) {
            Sweetalert::error('Erro ao atualizar movimento !'.$e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $movimento = Movimento::findOrFail($id);
            $movimento->delete();
            Sweetalert::success('Movimento excluido com sucesso!', 'Sucesso');
            return redirect()->route('movimentos.index')->with('success', 'Movimento excluído com sucesso!');
            
        } catch (\Exception $e) {
            Sweetalert::error('Erro ao deletar movimento !'.$e->getMessage(), 'Error');
            return redirect()->back();
        }
    }
}
