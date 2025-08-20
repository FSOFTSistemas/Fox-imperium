<?php

namespace App\Http\Controllers;

use App\Models\cliente;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Wavey\Sweetalert\Sweetalert;

class ClienteController extends Controller
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

        try
        {
            $clientes = cliente::where('empresa_id', $empresaId)->get();
            return view('cliente.all', ['clientes' => $clientes]);

        }catch(\Exception $e)
        {
            Sweetalert::error('Erro ao abrir clientes !', 'Error');
            return redirect()->back($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresas = Empresa::where('id', session('empresa_id'))->get();
        return view('cliente.form', ['empresas' => $empresas]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try
        {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes,email',
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:100',
            'estado' => 'nullable|string|max:50',
            'cep' => 'nullable|string|max:10',
            'empresa_id' => 'required|exists:empresas,id',
        ]);

        Cliente::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'endereco' => $request->endereco,
            'cidade' => $request->cidade,
            'estado' => $request->estado,
            'cep' => $request->cep,
            'empresa_id' => $request->empresa_id,
        ]);

        Sweetalert::success('Cliente cadastrado com sucesso!', 'Sucesso');

        return redirect()->route('clientes.index')->with('success', 'Cliente cadastrado com sucesso!');

    }catch(\Exception $e)
    {
        Sweetalert::error('Erro ao cadastrar cliente !', 'Error');
        return redirect()->back()->withInput()->with('error', 'Algo deu errado!'.$e->getMessage());
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(cliente $cliente)
    {
        try {
            $empresas = Empresa::where('id', session('empresa_id'))->get();
            return view('cliente.form', compact('cliente', 'empresas'));

        } catch (\Exception $e) {
            Sweetalert::error('Erro ao abrir editar! '.$e->getMessage(), 'Error');
            redirect()->back()->with('error','Erro ao editar');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, cliente $cliente)
    {
        try {

            $request->validate([
                'nome' => 'required|string|max:255',
                'email' => 'required|email|unique:clientes,email,' . $cliente->id,
                'telefone' => 'nullable|string|max:20',
                'endereco' => 'nullable|string|max:255',
                'cidade' => 'nullable|string|max:100',
                'estado' => 'nullable|string|max:50',
                'cep' => 'nullable|string|max:10',
                'empresa_id' => 'required'
            ]);

            $cliente->update([
                'nome' => $request->nome,
                'email' => $request->email,
                'telefone' => $request->telefone,
                'endereco' => $request->endereco,
                'cidade' => $request->cidade,
                'estado' => $request->estado,
                'cep' => $request->cep,
                'empresa_id' => $request->empresa_id,
            ]);

        Sweetalert::success('Cliente atualizado com sucesso!', 'Sucesso');

        return redirect()->route('clientes.index');

    } catch (\Exception $e) {
        Sweetalert::error('Erro ao atualizar cliente !', 'Error');
        return redirect()->back()->withInput()->with('error', 'Algo deu errado!'.$e->getMessage());
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(cliente $cliente)
    {
        try {

            $cliente->delete();

            Sweetalert::success('Cliente deletado com sucesso !', 'Sucesso');
            return redirect()->route('clientes.index')->with('success', 'Cliente deletado com suscesso !');

        } catch (\Exception $e) {
            Sweetalert::error('Erro ao deletar cliente !', 'Error');
            return redirect()->back()->with('error', 'Erro ao deletar cliente: ' . $e->getMessage());
        }
    }

    public function buscarEnderecoPorCep($cep)
    {
        try {
            $cep = preg_replace('/[^0-9]/', '', $cep);
    
            if (strlen($cep) !== 8) {
                return response()->json(['error' => 'CEP inválido.'], 400);
            }
    
            $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");
    
            if ($response->failed()) {
                return response()->json(['error' => 'Não foi possível buscar o endereço.'], 500);
            }
            return $response->json();
        } catch (\Exception $e) {
            Sweetalert::error('Erro ao buscar endereco !', 'Error');
            redirect()->back()->withInput();
        }

    }
}
