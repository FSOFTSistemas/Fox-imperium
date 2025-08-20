<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Wavey\Sweetalert\Sweetalert;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empresas = Empresa::all();
        return view('empresa.index', ['empresas' => $empresas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('empresa.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'razao_social' => 'required|string|max:255',
                'fantasia' => 'required|string|max:255',
                'cnpj' => 'required|string|max:18',
                'email' => 'required|email',
    
            ]);
    
            Empresa::create($request->all());
            Sweetalert::success('Empresa criada com sucesso!', 'Sucesso');
            return redirect()->route('empresas.index')->with('success', 'Empresa cadastrada com sucesso!');
           
        } catch (\Exception $e) {
            Sweetalert::error('Erro ao inserir empresa !'.$e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Empresa $empresa)
    {
        //
    }

    public function selecionarEmpresa($id)
    {
        session(['empresa_id' => $id]);
        return redirect()->back()->with('success', 'Empresa selecionada com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empresa $empresa)
    {
        $empresas = Empresa::where('id', session('empresa_id'))->get();
        return view('empresa.form', compact('empresa', 'empresas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empresa $empresa)
    {
        try {
            $validatedData = $request->validate([
                'razao_social' => 'required|string|max:255',
                'fantasia' => 'required|string|max:255',
                'cnpj' => 'required|string|max:20|unique:empresas,cnpj,' . $empresa->id,
                'IE' => 'nullable|string|max:50',
                'email' => 'required|email|max:255',
                'telefone' => 'nullable|string|max:20',
                'endereco' => 'nullable|string|max:255',
                'cidade' => 'nullable|string|max:100',
                'estado' => 'nullable|string|max:50',
                'cep' => 'nullable|string|max:15',
            ]);
    
            $empresa = Empresa::findOrFail($empresa->id);
    
            $empresa->update($validatedData);
            Sweetalert::success('Empresa atualizada com sucesso!', 'Sucesso');
            return redirect()->route('empresas.index')
                ->with('success', 'Empresa atualizada com sucesso!');
            
            } catch (\Exception $e) {
                Sweetalert::error('Erro ao atualizar empresa !'.$e->getMessage(), 'Error');
                return redirect()->back()->withInput();
            }
    }


    public function destroy(Empresa $empresa)
    {
        try {

            $empresa->delete();
            Sweetalert::success('Empresa excluida com sucesso!', 'Sucesso');
            return redirect()->route('empresas.index')->with('success', 'Empresa deletada com suscesso !');
            
        } catch (\Exception $e) {
            Sweetalert::error('Erro ao deletar empresa !'.$e->getMessage(), 'Error');
            return redirect()->back();
        }
    }
}
