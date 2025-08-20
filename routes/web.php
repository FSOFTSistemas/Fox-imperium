<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\ContasAPagarController;
use App\Http\Controllers\DreController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\MovimentoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\PlanoDeContasController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\PatrimonioController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\UsuarioController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');


Route::middleware(['auth'])->group(function () {
    Route::resource('empresas', EmpresaController::class);
    Route::resource('clientes', ClienteController::class);
    Route::resource('fornecedores', FornecedorController::class);
    Route::resource('produtos', ProdutoController::class);
    Route::post('/produtos/import/csv', [ProdutoController::class, 'importCsv'])->name('produtos.import.csv');
    Route::get('/produtos/import/csv/template', [ProdutoController::class, 'csvTemplate'])->name('produtos.import.csv.template');
    Route::post('/produtos/import/xml', [ProdutoController::class, 'importXml'])->name('produtos.import.xml');
    Route::resource('movimentos', MovimentoController::class);
    Route::resource('planos-de-contas', PlanoDeContasController::class);
    Route::resource('settings', ConfigController::class);
    Route::resource('dre', DreController::class);
    Route::post('/dre/dre', [DreController::class, 'dre'])->name('dre.dre');
    Route::resource('usuarios', UsuarioController::class)->middleware(['role:admin']);
    Route::get('/seletor-empresa/{id}', [EmpresaController::class, 'selecionarEmpresa'])->name('seletor.empresa');
    Route::get('/clientes/endereco/{cep}', [ClienteController::class, 'buscarEnderecoPorCep']);
    Route::get('/cmv', [DreController::class, 'cmv'])->name('cmv');
    Route::post('/cmv/filtro', [DreController::class, 'cmv_filtro'])->name('filtro_cmv');
    Route::resource('patrimonios', PatrimonioController::class);
    Route::resource('contas-a-pagar', ContasAPagarController::class);
    Route::get('relatorios', [RelatorioController::class, 'index'])->name('relatorios.index');
    Route::post('/relatorios/pdf', [RelatorioController::class, 'gerarPdf'])->name('relatorios.pdf');


});
