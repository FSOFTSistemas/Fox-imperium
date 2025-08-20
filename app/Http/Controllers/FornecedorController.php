<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Fornecedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Wavey\Sweetalert\Sweetalert;

class FornecedorController extends Controller
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
            $fornecedores = Fornecedor::where('empresa_id', $empresaId)->get();
            return view('fornecedores.all', ['fornecedores' =>  $fornecedores]);

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
        try {
            $empresas = Empresa::where('id', session('empresa_id'))->get();
            return view('fornecedores.form', ['empresas' => $empresas]);

        } catch (\Exception $e) {
            Sweetalert::error('Verifique se selecionou a empresa !'.$e->getMessage(), 'Error');
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nome' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'telefone' => 'required|string|max:15',
                'endereco' => 'required|string|max:255',
                'empresa_id' => 'required|exists:empresas,id',
            ]);
    
            Fornecedor::create($validatedData);
            Sweetalert::success('Fornecedor criado com sucesso!', 'Sucesso');
            return redirect()->route('fornecedores.index')->with('success', 'Fornecedor criado com sucesso!');

        } catch (\Exception $e) {
            Sweetalert::error('Erro ao inserir fornecedor !'.$e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Fornecedor $fornecedor)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $fornecedor = Fornecedor::findOrFail($id);
            $empresas = Empresa::where('id', session('empresa_id'))->get();
            return view('fornecedores.form', ['fornecedor' => $fornecedor, 'empresas' => $empresas]);
            
        } catch (\Exception $e) {
            Sweetalert::error('Verifique se selecionou a empresa !'.$e->getMessage(), 'Error');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'nome' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'telefone' => 'required|string|max:15',
                'endereco' => 'required|string|max:255',
                'empresa_id' => 'required|exists:empresas,id',
            ]);
            $fornecedor = Fornecedor::findOrFail($id);
            $fornecedor->update($validatedData);
            Sweetalert::success('Fornecedor atualizado com sucesso!', 'Sucesso');
            return redirect()->route('fornecedores.index')->with('success', 'Fornecedor atualizado com sucesso!');
            
        } catch (\Exception $e) {
            Sweetalert::error('Erro ao atualizar fornecedor !'.$e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $fornecedor = Fornecedor::findOrFail($id);
            $fornecedor->delete();
            Sweetalert::success('Fornecedor removido com sucesso!', 'Sucesso');
            return redirect()->route('fornecedores.index')->with('success', 'Fornecedor removido com sucesso!');
        } catch (\Exception $e) {
            Sweetalert::error('Erro ao deletar fornecedor !'.$e->getMessage(), 'Error');
            return redirect()->back();
        }
    }
}
