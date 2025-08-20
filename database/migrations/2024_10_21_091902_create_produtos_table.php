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
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->text('descricao');
            $table->decimal('precocusto', 10, 2);
            $table->decimal('precovenda', 10, 2);
            $table->integer('estoque')->default(0);
            $table->string('codbarra')->nullable()->index();
            $table->string('unidade', 10)->nullable();
            $table->string('ncm', 20)->nullable();
            $table->string('cst', 10)->nullable();
            $table->string('cfop', 10)->nullable();
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
