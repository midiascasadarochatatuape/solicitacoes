@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-md-center align-items-start mb-4 flex-md-row flex-column">
        <h2>Solicitações</h2>
        <a href="{{ route('solicitacoes.concluidas') }}" class="d-none btn btn-sm btn-outline-aprovado d-flex">
            <div class=" d-flex gap-2 align-items-center">
                <span class="material-symbols-outlined align-middle">check_circle</span>
                Solicitações Concluídas
            </div>
        </a>
    </div>
    <hr>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Botão de Filtros Mobile --}}
    @auth @if(auth()->user()->is_admin)
    <div class="d-md-none mb-3">
        <button type="button" class="btn btn-primary w-100" data-bs-toggle="collapse" data-bs-target="#filtrosMobile">
            <span class="material-symbols-outlined align-middle me-1">filter_alt</span>
            Filtros
        </button>
    </div>

    <div class="card border-0 mb-4 collapse d-md-block" id="filtrosMobile">
        <div class="card-body px-0">
            <form action="{{ route('solicitacoes.index') }}" method="GET" class="row g-3">
                <!-- Filtros -->
                <div class="d-flex flex-column flex-md-row gap-3">
                    <div class="flex-grow-1">
                        <label for="departamento" class="form-label">Departamento</label>
                        <select name="departamento" id="departamento" class="form-select">
                            <option value="">Todos</option>
                            @foreach($departamentos as $dept)
                                <option value="{{ $dept }}" {{ request('departamento') == $dept ? 'selected' : '' }}>
                                    {{ $dept }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex-grow-1">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select name="tipo" id="tipo" class="form-select">
                            <option value="">Todos</option>
                            @foreach($tipos as $tipo)
                                <option value="{{ $tipo }}" {{ request('tipo') == $tipo ? 'selected' : '' }}>
                                    {{ $tipo == 'servico' ? 'Serviço' : ucfirst($tipo) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex-grow-1">
                        <label for="descricao" class="form-label">Buscar na descrição</label>
                        <input type="text" name="descricao" id="descricao" class="form-control"
                               value="{{ request('descricao') }}"
                               placeholder="Digite para buscar...">
                    </div>

                    <div class="flex-grow-1">
                        <label for="prioridade" class="form-label">Prioridade</label>
                        <select name="prioridade" id="prioridade" class="form-select">
                            <option value="">Todas</option>
                            @foreach($prioridades as $prioridade)
                                <option value="{{ $prioridade }}" {{ request('prioridade') == $prioridade ? 'selected' : '' }}>
                                    {{ $prioridade }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex-grow-1">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="" selected>Todos</option>
                                @foreach($statusFilterOptions as $status)
                                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                        </select>
                    </div>

                    <div class="flex-grow-1">
                        <label for="sort" class="form-label">Ordenar por</label>
                        <select name="sort" id="sort" class="form-select">
                            <option value="{{ App\Helpers\UrlHelper::sortUrl('created_at', 'desc') }}">Data (Mais recente)</option>
                            <option value="{{ App\Helpers\UrlHelper::sortUrl('created_at', 'asc') }}">Data (Mais antiga)</option>
                            <option value="{{ App\Helpers\UrlHelper::sortUrl('nome', 'asc') }}">Nome (A-Z)</option>
                            <option value="{{ App\Helpers\UrlHelper::sortUrl('nome', 'desc') }}">Nome (Z-A)</option>
                            <option value="{{ App\Helpers\UrlHelper::sortUrl('tipo', 'asc') }}">Tipo (A-Z)</option>
                            <option value="{{ App\Helpers\UrlHelper::sortUrl('tipo', 'desc') }}">Tipo (Z-A)</option>
                            <option value="prioridade-asc" {{ request('sort') == 'prioridade-asc' ? 'selected' : '' }}>Prioridade (A-Z)</option>
                            <option value="prioridade-desc" {{ request('sort') == 'prioridade-desc' ? 'selected' : '' }}>Prioridade (Z-A)</option>
                            <option value="departamento-asc" {{ request('sort') == 'departamento-asc' ? 'selected' : '' }}>Departamento (A-Z)</option>
                            <option value="departamento-desc" {{ request('sort') == 'departamento-desc' ? 'selected' : '' }}>Departamento (Z-A)</option>
                            <option value="status-asc" {{ request('sort') == 'status-asc' ? 'selected' : '' }}>Status (A-Z)</option>
                            <option value="status-desc" {{ request('sort') == 'status-desc' ? 'selected' : '' }}>Status (Z-A)</option>
                        </select>
                    </div>

                    <div class="flex-grow-1 d-flex align-items-end">
                        <div class="d-flex gap-2 w-100 justify-content-center">
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                            <a href="{{ App\Helpers\UrlHelper::cleanUrl() }}" class="btn btn-outline-secondary">Limpar</a>
                        </div>
                    </div>
                </div>

                {{-- Botão Fechar em Mobile --}}
                <div class="d-md-none mt-3">
                    <button type="button" class="btn btn-outline-secondary w-100" data-bs-toggle="collapse" data-bs-target="#filtrosMobile">
                        <span class="material-symbols-outlined align-middle me-1">expand_less</span>
                        Ocultar Filtros
                    </button>
                </div>


            </form>
        </div>
    </div>
    @endif @endauth

    <div class="card border-0">
        <div class="card-body p-0">
            <div class="d-none justify-content-between align-items-center mb-2">
                <small class="text-muted">
                    <span class="material-symbols-outlined" style="font-size: 16px; vertical-align: text-bottom;">refresh</span>
                    Atualização automática: <span id="auto-update-status">Ativa</span>
                    <span id="last-update" class="ms-2"></span>
                </small>
            </div>
            <div class="table-responsive my-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="bg-primary p-2 text-white">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => request('sort') == 'created_at-asc' ? 'created_at-desc' : 'created_at-asc']) }}"
                                   class="text-white text-decoration-none d-flex align-items-center gap-1">
                                    Data
                                    @if(request('sort') == 'created_at-asc')
                                        <span class="material-symbols-outlined" style="font-size: 16px">arrow_upward</span>
                                    @elseif(request('sort') == 'created_at-desc')
                                        <span class="material-symbols-outlined" style="font-size: 16px">arrow_downward</span>
                                    @endif
                                </a>
                            </th>
                            <th class="bg-primary p-2 text-white">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => request('sort') == 'nome-asc' ? 'nome-desc' : 'nome-asc']) }}"
                                   class="text-white text-decoration-none d-flex align-items-center gap-1">
                                    Nome
                                    @if(request('sort') == 'nome-asc')
                                        <span class="material-symbols-outlined" style="font-size: 16px">arrow_upward</span>
                                    @elseif(request('sort') == 'nome-desc')
                                        <span class="material-symbols-outlined" style="font-size: 16px">arrow_downward</span>
                                    @endif
                                </a>
                            </th>
                            <th class="bg-primary p-2 text-white">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => request('sort') == 'tipo-asc' ? 'tipo-desc' : 'tipo-asc']) }}"
                                   class="text-white text-decoration-none d-flex align-items-center gap-1">
                                    Tipo
                                    @if(request('sort') == 'tipo-asc')
                                        <span class="material-symbols-outlined" style="font-size: 16px">arrow_upward</span>
                                    @elseif(request('sort') == 'tipo-desc')
                                        <span class="material-symbols-outlined" style="font-size: 16px">arrow_downward</span>
                                    @endif
                                </a>
                            </th>
                            <th class="bg-primary p-2 text-white">Descrição</th>
                            <th class="bg-primary p-2 text-white">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => request('sort') == 'prioridade-asc' ? 'prioridade-desc' : 'prioridade-asc']) }}"
                                   class="text-white text-decoration-none d-flex align-items-center gap-1">
                                    Prioridade
                                    @if(request('sort') == 'prioridade-asc')
                                        <span class="material-symbols-outlined" style="font-size: 16px">arrow_upward</span>
                                    @elseif(request('sort') == 'prioridade-desc')
                                        <span class="material-symbols-outlined" style="font-size: 16px">arrow_downward</span>
                                    @endif
                                </a>
                            </th>
                            <th class="bg-primary p-2 text-white">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => request('sort') == 'departamento-asc' ? 'departamento-desc' : 'departamento-asc']) }}"
                                   class="text-white text-decoration-none d-flex align-items-center gap-1">
                                    Departamento
                                    @if(request('sort') == 'departamento-asc')
                                        <span class="material-symbols-outlined" style="font-size: 16px">arrow_upward</span>
                                    @elseif(request('sort') == 'departamento-desc')
                                        <span class="material-symbols-outlined" style="font-size: 16px">arrow_downward</span>
                                    @endif
                                </a>
                            </th>
                            <th class="bg-primary p-2 text-white">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => request('sort') == 'status-asc' ? 'status-desc' : 'status-asc']) }}"
                                   class="text-white text-decoration-none d-flex align-items-center gap-1">
                                    Status
                                    @if(request('sort') == 'status-asc')
                                        <span class="material-symbols-outlined" style="font-size: 16px">arrow_upward</span>
                                    @elseif(request('sort') == 'status-desc')
                                        <span class="material-symbols-outlined" style="font-size: 16px">arrow_downward</span>
                                    @endif
                                </a>
                            </th>
                            <th class="bg-primary p-2 text-white text-center">Ver  @auth @if(auth()->user()->is_admin) / Editar @endif @endauth</th>
                        </tr>
                    </thead>
                    <tbody id="orcamentos-tbody">
                        @foreach($orcamentos as $orcamento)
                        <tr>
                            <td>{{ $orcamento->created_at->format('d/m/Y H:i') }}</td>
                            <td><a href="{{ route('solicitacoes.edit', $orcamento) }}" class="text-decoration-none">{{ $orcamento->nome }}</a></td>
                            <td class="text-center p-0 align-middle">
                                @php
                                    if($orcamento->tipo == 'servico') {
                                        $tipo = "Serviço";
                                    } else {
                                        $tipo = "Compra";
                                    }

                                    $iconType = match($orcamento->tipo) {
                                        'servico' => 'servico',
                                        'compra' => 'compra',
                                        default => ''
                                    };
                                @endphp
                                <span>
                                    <img src="{{ asset('assets/img/icon-'. $iconType.'.webp') }}" height="35" alt="{{ $tipo }}" title="{{$tipo}}" alt="">
                                </span>
                            </td>
                            <td alt="{{ $orcamento->descricao }}" title="{{ $orcamento->descricao }}">
                                @php

                                    if (strlen($orcamento->descricao) > 10) {
                                        echo substr($orcamento->descricao, 0, 10) . "...";
                                    } else {
                                        echo $orcamento->descricao;
                                    }
                                @endphp
                                @php
                                    $prioridadeBgClass = match($orcamento->prioridade) {
                                        'Imediata' => 'background-color: #ff000040;',
                                        'Curto prazo' => 'background-color: #ff74003b;',
                                        'Médio prazo' => 'background-color: #ffaa004a;',
                                        'Longo prazo' => 'background-color: #89b5817d;',
                                        'Data específica(evento)' => 'background-color: #654c9b66;',
                                        default => ''
                                    };
                                @endphp
                            </td>

                            <td style="{{ $prioridadeBgClass }}"  class="text-center p-0 align-middle">
                                @php
                                    $prioridadeClass = match($orcamento->prioridade) {
                                        'Imediata' => 'imediato',
                                        'Curto prazo' => 'curto',
                                        'Médio prazo' => 'medio',
                                        'Longo prazo' => 'longo',
                                        'Data específica(evento)' => 'agendado',
                                        default => ''
                                    };
                                @endphp
                                <span>
                                    <img src="{{ asset('assets/img/icon-'. $prioridadeClass.'.webp') }}" height="35" alt="{{$orcamento->prioridade}}" title="{{$orcamento->prioridade}}" alt="">
                                </span>
                            </td>
                            <td>{{ $orcamento->departamento }}</td>
                            <td>
                                @php
                                    $statusClass = match($orcamento->status) {
                                        'Nova solicitação'                            => 'text-warning fw-bold',
                                        'Em análise'                                  => 'text-info fw-bold',
                                        'Aprovado. Em processo de compra'             => 'text-aprovado fw-bold',
                                        'Aprovado com alterações'                     => 'text-apcalt fw-bold',
                                        'Reprovado, falar com a Angélica'             => 'text-reprovado fw-bold',
                                        'Compra concluída'                            => 'text-entregue fw-bold',
                                        'Serviço liberado'                            => 'text-aprovado fw-bold',
                                        'Serviço aprovado, aguardando o fornecedor'   => 'text-apcalt fw-bold',
                                        'Serviço concluído'                           => 'text-entregue fw-bold',

                                        default => ''
                                    };
                                @endphp
                                <span class="{{ $statusClass }}">{{ $orcamento->status }}</span>
                            </td>

                            <td>
                                <div class="d-flex gap-3 justify-content-center">
                                    <a href="{{ route('solicitacoes.show', $orcamento) }}" class="d-flex align-items-center text-decoration-none justify-content-center">
                                        <span class="material-symbols-outlined">document_search</span>
                                    </a>
                                    @auth
                                        @if(auth()->user()->is_admin)
                                            <a href="{{ route('solicitacoes.edit', $orcamento) }}" class="d-flex align-items-center justify-content-center text-decoration-none">
                                                <span class="material-symbols-outlined">edit_square</span>
                                            </a>
                                        @endif
                                    @endauth
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $orcamentos->links() }}
            </div>
        </div>
    </div>
</div>

<script>
let lastUpdateTime = new Date();
let autoUpdateInterval;
const isAdmin = {{ auth()->check() && auth()->user()->is_admin ? 'true' : 'false' }};

function updateSolicitacoes() {
    const currentUrl = new URL(window.location.href);
    const params = currentUrl.searchParams;

    // Mostrar que está atualizando
    const statusElement = document.getElementById('auto-update-status');
    if (statusElement) {
        statusElement.textContent = 'Atualizando...';
        statusElement.className = 'text-primary';
    }

    // Fazer requisição para a API
    fetch('/api/solicitacoes?' + params.toString())
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateTable(data.data);
                updatePagination(data.pagination);
                lastUpdateTime = new Date();

                // Mostrar status atualizado
                if (statusElement) {
                    statusElement.textContent = 'Ativa';
                    statusElement.className = 'text-success';
                }

                const lastUpdateElement = document.getElementById('last-update');
                if (lastUpdateElement) {
                    lastUpdateElement.textContent = `(última: ${lastUpdateTime.toLocaleTimeString('pt-BR')})`;
                }
            }
        })
        .catch(error => {
            console.log('Erro ao atualizar dados:', error);
            if (statusElement) {
                statusElement.textContent = 'Erro na atualização';
                statusElement.className = 'text-danger';
            }
        });
}

function updateTable(orcamentos) {
    const tbody = document.getElementById('orcamentos-tbody');

    if (!tbody) return;

    let newHTML = '';

    orcamentos.forEach(orcamento => {
        const createdAt = new Date(orcamento.created_at);
        const formattedDate = createdAt.toLocaleDateString('pt-BR') + ' ' +
                            createdAt.toLocaleTimeString('pt-BR', {hour: '2-digit', minute: '2-digit'});

        const tipo = orcamento.tipo === 'servico' ? 'Serviço' : 'Compra';
        const iconType = orcamento.tipo === 'servico' ? 'servico' : 'compra';

        let prioridadeClass = '';
        let prioridadeBgClass = '';

        switch(orcamento.prioridade) {
            case 'Imediata':
                prioridadeClass = 'imediato';
                prioridadeBgClass = 'background-color: #ff000040;';
                break;
            case 'Curto prazo':
                prioridadeClass = 'curto';
                prioridadeBgClass = 'background-color: #ff74003b;';
                break;
            case 'Médio prazo':
                prioridadeClass = 'medio';
                prioridadeBgClass = 'background-color: #ffaa004a;';
                break;
            case 'Longo prazo':
                prioridadeClass = 'longo';
                prioridadeBgClass = 'background-color: #89b5817d;';
                break;
            case 'Data específica(evento)':
                prioridadeClass = 'agendado';
                prioridadeBgClass = 'background-color: #654c9b66;';
                break;
        }

        let statusClass = '';
        switch(orcamento.status) {
            case 'Nova solicitação':
                statusClass = 'text-warning fw-bold';
                break;
            case 'Em análise':
                statusClass = 'text-info fw-bold';
                break;
            case 'Aprovado. Em processo de compra':
                statusClass = 'text-aprovado fw-bold';
                break;
            case 'Aprovado com alterações':
                statusClass = 'text-apcalt fw-bold';
                break;
            case 'Reprovado, falar com a Angélica':
                statusClass = 'text-reprovado fw-bold';
                break;
            case 'Compra concluída':
                statusClass = 'text-entregue fw-bold';
                break;
            case 'Serviço liberado':
                statusClass = 'text-aprovado fw-bold';
                break;
            case 'Serviço aprovado, aguardando o fornecedor':
                statusClass = 'text-apcalt fw-bold';
                break;
            case 'Serviço concluído':
                statusClass = 'text-entregue fw-bold';
                break;
        }

        const descricao = orcamento.descricao.length > 10 ?
            orcamento.descricao.substring(0, 10) + '...' : orcamento.descricao;

        newHTML += `
            <tr>
                <td>${formattedDate}</td>
                <td><a href="/solicitacoes/${orcamento.id}/edit" class="text-decoration-none">${orcamento.nome}</a></td>
                <td class="text-center p-0 align-middle">
                    <span>
                        <img src="/assets/img/icon-${iconType}.webp" height="35" alt="${tipo}" title="${tipo}">
                    </span>
                </td>
                <td alt="${orcamento.descricao}" title="${orcamento.descricao}">${descricao}</td>
                <td style="${prioridadeBgClass}" class="text-center p-0 align-middle">
                    <span>
                        <img src="/assets/img/icon-${prioridadeClass}.webp" height="35" alt="${orcamento.prioridade}" title="${orcamento.prioridade}">
                    </span>
                </td>
                <td>${orcamento.departamento}</td>
                <td><span class="${statusClass}">${orcamento.status}</span></td>
                <td>
                    <div class="d-flex gap-3 justify-content-center">
                        <a href="/solicitacoes/${orcamento.id}" class="d-flex align-items-center text-decoration-none justify-content-center">
                            <span class="material-symbols-outlined">document_search</span>
                        </a>
                        ${isAdmin ? `
                            <a href="/solicitacoes/${orcamento.id}/edit" class="d-flex align-items-center justify-content-center text-decoration-none">
                                <span class="material-symbols-outlined">edit_square</span>
                            </a>
                        ` : ''}
                    </div>
                </td>
            </tr>
        `;
    });

    tbody.innerHTML = newHTML;
}

function updatePagination(pagination) {
    // Atualizar links de paginação se necessário
    // Este é um exemplo básico - você pode expandir conforme necessário
}

// Iniciar atualização automática quando a página carregar
document.addEventListener('DOMContentLoaded', function() {
    // Atualizar a cada 15 segundos (15000ms)
    autoUpdateInterval = setInterval(updateSolicitacoes, 1000);

    // Definir tempo inicial
    const lastUpdateElement = document.getElementById('last-update');
    if (lastUpdateElement) {
        lastUpdateElement.textContent = `(carregado: ${new Date().toLocaleTimeString('pt-BR')})`;
    }

    // Parar/retomar a atualização quando a página perder/ganhar o foco
    document.addEventListener('visibilitychange', function() {
        const statusElement = document.getElementById('auto-update-status');
        if (document.hidden) {
            clearInterval(autoUpdateInterval);
            if (statusElement) {
                statusElement.textContent = 'Pausada (página não visível)';
                statusElement.className = 'text-warning';
            }
        } else {
            autoUpdateInterval = setInterval(updateSolicitacoes, 10000);
            if (statusElement) {
                statusElement.textContent = 'Ativa';
                statusElement.className = 'text-success';
            }
            // Atualizar imediatamente quando retornar à página
            setTimeout(updateSolicitacoes, 1000);
        }
    });
});

// Limpar interval quando sair da página
window.addEventListener('beforeunload', function() {
    clearInterval(autoUpdateInterval);
});
</script>
@endsection
