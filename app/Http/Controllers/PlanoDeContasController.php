<?php

namespace App\Http\Controllers;

use App\Models\PlanoDeContas;
use Illuminate\Http\Request;
use Wavey\Sweetalert\Sweetalert;

class PlanoDeContasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $planoDeContas = PlanoDeContas::orderBy('descricao', 'asc')->get();
        return view('planodecontas.all', ['planodecontas' => $planoDeContas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('planodecontas.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'codigo' => 'required',
                'descricao' => 'required|string|max:255',
                'tipo' => 'required|in:despesa,receita',
            ]);
    
            PlanoDeContas::create($validatedData);
            Sweetalert::success('Plano de contas criada com sucesso!', 'Sucesso');
            return redirect()->route('planos-de-contas.index')->with('success', 'Plano de contas criado com sucesso!');
            
        } catch (\Exception $e) {
            Sweetalert::error('Erro ao inserir plano de contas !'.$e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PlanoDeContas $planoDeContas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PlanoDeContas $planoDeContas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'descricao' => 'required|string|max:255',
                'tipo' => 'required|in:despesa,receita',
            ]);
    
            $planoDeContas = PlanoDeContas::findOrFail($id);
            $planoDeContas->update($validatedData);
            Sweetalert::success('Plano de contas atualizado com sucesso!', 'Sucesso');
            return redirect()->route('planos-de-contas.index')->with('success', 'Plano de contas atualizado com sucesso!');
            
        } catch (\Exception $e) {
            Sweetalert::error('Erro ao atualizar plano de contas !'.$e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $planoDeContas = PlanoDeContas::findOrFail($id);
            $planoDeContas->delete();
            Sweetalert::success('Plano de contas deletado com sucesso!', 'Sucesso');
            return redirect()->route('planos-de-contas.index')->with('success', 'Plano de contas deletado com sucesso!');
            
        } catch (\Exception $e) {
            Sweetalert::error('Erro ao deletar plano de contas !'.$e->getMessage(), 'Error');
            return redirect()->back();
        }
    }
}
