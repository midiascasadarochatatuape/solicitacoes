<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait FiltrosTrait
{
    protected function aplicarFiltros(Request $request, $query)
    {
        $filtros = $this->getFiltrosValidos($request);

        foreach ($filtros as $campo => $valor) {
            if ($campo === 'descricao') {
                $query->where($campo, 'like', '%' . $valor . '%');
            } else if ($campo === 'sort') {
                $this->aplicarOrdenacao($query, $valor);
            } else {
                $query->where($campo, $valor);
            }
        }

        // Se não houver ordenação específica, aplicar ordenação padrão por data mais recente
        if (!isset($filtros['sort'])) {
            $query->orderBy('created_at', 'desc');
        }

        return $query;
    }

    protected function getFiltrosValidos(Request $request)
    {
        $camposPermitidos = [
            'departamento',
            'tipo',
            'prioridade',
            'status',
            'descricao',
            'sort'
        ];

        return collect($request->only($camposPermitidos))
            ->filter(function ($value) {
                return $value !== null && $value !== '';
            })
            ->map(function ($value) {
                return strip_tags($value);
            })
            ->toArray();
    }

    protected function aplicarOrdenacao($query, $sortParam)
    {
        $camposOrdenacao = [
            'created_at',
            'nome',
            'tipo',
            'prioridade',
            'departamento',
            'status'
        ];

        $parts = explode('-', $sortParam);
        $campo = $parts[0] ?? 'created_at';
        $direcao = $parts[1] ?? 'desc';

        if (!in_array($campo, $camposOrdenacao)) {
            $campo = 'created_at';
        }

        if (!in_array($direcao, ['asc', 'desc'])) {
            $direcao = 'desc';
        }

        if ($campo === 'prioridade') {
            // Ordem personalizada para prioridades
            $ordemPrioridades = [
                'Imediata',
                'Curto prazo',
                'Médio prazo',
                'Longo prazo',
                'Data específica(evento)'
            ];

            if ($direcao === 'desc') {
                $ordemPrioridades = array_reverse($ordemPrioridades);
            }

            $casos = [];
            foreach ($ordemPrioridades as $index => $prioridade) {
                $casos[] = "'$prioridade'";
            }
            $casosStr = implode(',', $casos);

            $query->orderByRaw("CASE
                WHEN prioridade IN ({$casosStr})
                THEN FIELD(prioridade, {$casosStr})
                ELSE 99999
            END");
        } else {
            $query->orderBy($campo, $direcao);
        }
    }

    protected function getLinkPaginacao($orcamentos)
    {
        return $orcamentos->appends($this->getFiltrosValidos(request()))->links();
    }
}
