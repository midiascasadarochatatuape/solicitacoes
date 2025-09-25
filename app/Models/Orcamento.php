<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\FiltrosTrait;

class Orcamento extends Model
{
    use HasFactory, FiltrosTrait;

    public function scopeEmAndamento($query)
    {
        return $query->where(function($q) {
            $q->where('status', '!=', 'Compra concluída')
              ->where('status', '!=', 'Serviço concluído');
        });
    }

    public function scopeConcluidos($query)
    {
        return $query->where(function($q) {
            $q->where('status', 'Compra concluída')
              ->orWhere('status', 'Serviço concluído')
              ->orWhere('status', 'Reprovado, falar com a Angélica')
              ->orWhere('status', 'Serviço reprovado, falar com a Angélica');
        });
    }

    protected $fillable = [
        'nome',
        'departamento',
        'descricao',
        'prioridade',
        'prioridade_data_especifica',
        'preco',
        'tipo',
        'link_concorrente_1',
        'link_concorrente_2',
        'link_concorrente_3',
        'qtde_1',
        'qtde_2',
        'qtde_3',
        'data_compra',
        'endereco_entrega',
        'telefone_contato',
        'orcamento_imagem_1',
        'orcamento_imagem_2',
        'orcamento_imagem_3',
        'data_servico_1',
        'data_servico_2',
        'data_servico_3',
        'hora_servico_1',
        'hora_servico_2',
        'hora_servico_3',
        'responsavel_recebimento_1',
        'responsavel_recebimento_2',
        'responsavel_recebimento_3',
        'status',
        'status_observacao'
    ];

    protected $dates = [
        'data_compra',
        'data_servico_1',
        'data_servico_2',
        'data_servico_3'
    ];

    public static function getPriorityOptions()
    {
        return [
            'Imediata',
            'Curto prazo',
            'Médio prazo',
            'Longo prazo',
            'Data específica(evento)'
        ];
    }

    public static function getComprasStatusOptions()
    {
        return [
            'Em análise',
            'Aprovado. Em processo de compra',
            'Aprovado com alterações',
            'Compra concluída',
            'Reprovado, falar com a Angélica'
        ];
    }

    public static function getServicoStatusOptions()
    {
        return [
            'Em análise',
            'Serviço aprovado, aguardando o fornecedor',
            'Serviço agendado',
            'Serviço concluído',
            'Serviço reprovado, falar com a Angélica'
        ];
    }

    public static function getFilterStatusOptions()
    {
        return [
            'Em análise',
            'Aprovado. Em processo de compra',
            'Aprovado com alterações',
            'Reprovado, falar com a Angélica',
            'Compra concluída',
            'Serviço aprovado, aguardando o fornecedor',
            'Serviço agendado',
            'Serviço concluído',
            'Serviço reprovado, falar com a Angélica'
        ];
    }
}
