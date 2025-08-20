<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movimentos', function (Blueprint $table) {
            $table->id();
            $table->text('descricao')->nullable();
            $table->enum('tipo', ['receita', 'despesa','cmv']);
            $table->date('data');
            $table->string('forma_pagamento');
            $table->decimal('valor', 10, 2);
            $table->foreignId('produto_servico_id')->nullable()->constrained('produtos')->onDelete('set null');
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade'); 
            $table->foreignId('planodecontas_id')->constrained('plano_de_contas')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimentos');
    }
};
