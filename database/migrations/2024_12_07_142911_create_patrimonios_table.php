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
        Schema::create('patrimonios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->decimal('valor', 10, 2);
            $table->date('data_aquisicao');
            $table->string('responsavel')->nullable();
            $table->text('descricao')->nullable();
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patrimonios');
    }
};
