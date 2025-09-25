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
        Schema::create('orcamentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('departamento');
            $table->text('descricao');
            $table->string('prioridade');
            $table->text('prioridade_data_especifica')->nullable();
            $table->string('preco');
            $table->enum('tipo', ['compra', 'servico']);

            // Campos para compra
            $table->string('link_concorrente_1', 1000)->nullable();
            $table->string('link_concorrente_2', 1000)->nullable();
            $table->string('link_concorrente_3', 1000)->nullable();
            $table->string('qtde_1')->nullable();
            $table->string('qtde_2')->nullable();
            $table->string('qtde_3')->nullable();
            $table->string('data_compra')->nullable();
            $table->string('endereco_entrega')->nullable();
            $table->string('telefone_contato')->nullable();

            // Campos para serviço
            $table->string('orcamento_imagem_1')->nullable();
            $table->string('orcamento_imagem_2')->nullable();
            $table->string('orcamento_imagem_3')->nullable();
            $table->date('data_servico_1')->nullable();
            $table->date('data_servico_2')->nullable();
            $table->date('data_servico_3')->nullable();
            $table->time('hora_servico_1')->nullable();
            $table->time('hora_servico_2')->nullable();
            $table->time('hora_servico_3')->nullable();
            $table->string('responsavel_recebimento_1')->nullable();
            $table->string('responsavel_recebimento_2')->nullable();
            $table->string('responsavel_recebimento_3')->nullable();

            // Campo de status
            $table->string('status')->default('Em análise');
            $table->text('status_observacao')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orcamentos');
    }
};
