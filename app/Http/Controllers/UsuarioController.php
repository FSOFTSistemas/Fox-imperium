<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Wavey\Sweetalert\Sweetalert;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $usuarios = User::all();
            $empresas = Empresa::where('id', session('empresa_id'))->get();
            return view('user.index', compact('usuarios','empresas'));
            
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
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'role' => 'required|string|in:admin,user',
                'empresa_id' => 'required',
            ]);


            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'empresa_id' => $request->empresa_id,
            ]);
            Sweetalert::success('Usuário criado com sucesso!', 'Sucesso');
            return redirect()->route('usuarios.index')->with('success', 'Usuário criado com sucesso!');

        } catch (\Exception $e) {
            Sweetalert::error('Erro ao inserir usuário !'.$e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Usuario $usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Usuario $usuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
    
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'role' => 'required|string|in:admin,user',
                'password' => 'nullable|string|min:6',
            ]);
    
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
            ]);
            Sweetalert::success('Usuário atualizado com sucesso!', 'Sucesso');
            return redirect()->route('usuarios.index')->with('success', 'Usuário atualizado com sucesso!');
            
        } catch (\Exception $e) {
            Sweetalert::error('Erro ao atualizar usuário !'.$e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            Sweetalert::success('Usuário excluido com sucesso!', 'Sucesso');
            return redirect()->route('usuarios.index')->with('success', 'Usuário excluído com sucesso!');
           
        } catch (\Exception $e) {
            Sweetalert::error('Erro ao deletar usuário !'.$e->getMessage(), 'Error');
            return redirect()->back();
        }
    }
}
