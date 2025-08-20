<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Patrimonio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Wavey\Sweetalert\Sweetalert;

class PatrimonioController extends Controller
{
    public function index()
    {
        $empresaId = session('empresa_id');

        if (!$empresaId)
        {
            $empresaId = Auth::user()->empresa_id;
        }
        
        try {
            $patrimonios = Patrimonio::where('empresa_id', $empresaId)->get();
            $empresas = Empresa::where('id', $empresaId)->get();
            return view('patrimonio.index', compact('patrimonios', 'empresas'));
        } catch (\Exception $e) {
            Sweetalert::error('Verifique se selecionou empresa !'.$e->getMessage(), 'Error');
        }
    }

    public function create()
    {
        try {
            $empresas = Empresa::where('empresa_id', session('empresa_id'))->get();
            return view('patrimonio.create', compact('empresas'));

        } catch (\Exception $e) {
            Sweetalert::error('Verifique se selecionou empresa !'.$e->getMessage(), 'Error');
        }
        
    }

    public function store(Request $request)
    {
        try
        {

            $request->validate([
                'nome' => 'required|string|max:255',
                'valor' => 'required|numeric|min:0',
                'data_aquisicao' => 'required|date',
                'empresa_id' => 'required|exists:empresas,id',
            ]);
            
            Patrimonio::create($request->all());
            Sweetalert::success('Patrimônio criado com sucesso.', 'Sucesso');
            return redirect()->route('patrimonios.index')->with('success', 'Patrimônio criado com sucesso.');
        }catch(\Exception $e)
        {
            Sweetalert::error('Erro ao salvar patrimonio !'.$e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function edit(Patrimonio $patrimonio)
    {
        try {
            $empresas = Empresa::where('empresa_id', session('empresa_id'))->get();
            return view('patrimonio.edit', compact('patrimonio', 'empresas'));
    
        } catch (\Exception $e) {
            Sweetalert::error('Verifique se selecionou a empresa !'.$e->getMessage(), 'Error');
        }
    }

    public function update(Request $request, Patrimonio $patrimonio)
    {
        try {
            $request->validate([
                'nome' => 'required|string|max:255',
                'valor' => 'required|numeric|min:0',
                'data_aquisicao' => 'required|date',
                'empresa_id' => 'required|exists:empresas,id',
            ]);
    
            $patrimonio->update($request->all());
            
            Sweetalert::success('Patrimônio atualizado com sucesso.', 'Sucesso');
            return redirect()->route('patrimonios.index')->with('success', 'Patrimônio atualizado com sucesso.');

        } catch (\Exception $e) {
            Sweetalert::error('Erro ao editar patrimonio !'.$e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Patrimonio $patrimonio)
    {
        try {
            $patrimonio->delete();
            Sweetalert::success('Patrimônio deletado com sucesso.', 'Sucesso');
            return redirect()->route('patrimonios.index')->with('success', 'Patrimônio excluído com sucesso.');
            
        } catch (\Exception $e) {
            Sweetalert::error('Erro ao editar patrimonio !'.$e->getMessage(), 'Error');
            return redirect()->back();
        }

    }

}
