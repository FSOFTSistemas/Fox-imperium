<?php

namespace Database\Seeders;

use App\Models\PlanoDeContas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanoDeContasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $planosDeContas = [
            // Receitas
            ['codigo' => '1.1', 'descricao' => 'Vendas', 'tipo' => 'Receita'],
                ['codigo' => '1.1.1', 'descricao' => 'Vendas à vista', 'tipo' => 'Receita'],
                ['codigo' => '1.1.2', 'descricao' => 'Vendas a prazo', 'tipo' => 'Receita'],
                ['codigo' => '1.1.3', 'descricao' => 'Vendas por cartão', 'tipo' => 'Receita'],
            ['codigo' => '1.2', 'descricao' => 'Outras Receitas Operacionais', 'tipo' => 'Receita'],
                ['codigo' => '1.2.1', 'descricao' => 'Aluguéis recebidos', 'tipo' => 'Receita'],
                ['codigo' => '1.2.2', 'descricao' => 'Juros recebidos', 'tipo' => 'Receita'],
            // Custos das Mercadorias Vendidas (CMV)
            ['codigo' => '2.1', 'descricao' => 'Custo das Mercadorias Vendidas', 'tipo' => 'CMV'],
                ['codigo' => '2.1.1', 'descricao' => 'Compras de mercadorias', 'tipo' => 'CMV'],
                ['codigo' => '2.1.2', 'descricao' => 'Frete sobre compras', 'tipo' => 'CMV'],
                ['codigo' => '2.1.3', 'descricao' => 'Impostos sobre compras', 'tipo' => 'CMV'],
            // Despesas Operacionais
            ['codigo' => '3.1', 'descricao' => 'Despesas com Vendas', 'tipo' => 'Despesa'],
                ['codigo' => '3.1.1', 'descricao' => 'Provisão para devedores duvidosos', 'tipo' => 'Despesa'],
                ['codigo' => '3.1.2', 'descricao' => 'Comissões de vendas', 'tipo' => 'Despesa'],
            ['codigo' => '3.2', 'descricao' => 'Despesas Administrativas', 'tipo' => 'Despesa'],
                ['codigo' => '3.2.1', 'descricao' => 'Salários e encargos sociais', 'tipo' => 'Despesa'],
                ['codigo' => '3.2.2', 'descricao' => 'Aluguel', 'tipo' => 'Despesa'],
                ['codigo' => '3.2.3', 'descricao' => 'Energia elétrica', 'tipo' => 'Despesa'],
            // Despesas Financeiras
            ['codigo' => '4.1', 'descricao' => 'Despesas Financeiras', 'tipo' => 'Despesa'],
                ['codigo' => '4.1.1', 'descricao' => 'Juros sobre empréstimos', 'tipo' => 'Despesa'],
                ['codigo' => '4.1.2', 'descricao' => 'Encargos financeiros', 'tipo' => 'Despesa'],
            // Outras Receitas e Despesas
            ['codigo' => '5.1', 'descricao' => 'Outras Receitas', 'tipo' => 'Receita'],
                ['codigo' => '5.1.1', 'descricao' => 'Receita de venda de ativo imobilizado', 'tipo' => 'Receita'],
            ['codigo' => '5.2', 'descricao' => 'Outras Despesas', 'tipo' => 'Despesa'],
                ['codigo' => '5.2.1', 'descricao' => 'Perdas com créditos de liquidação duvidosa', 'tipo' => 'Despesa'],
        ];

        foreach ($planosDeContas as $plano) {
            PlanoDeContas::create($plano);
        }
    }
}
