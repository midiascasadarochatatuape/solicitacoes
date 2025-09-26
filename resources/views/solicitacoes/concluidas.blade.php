@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-md-center align-items-start mb-4 flex-md-row flex-column">
        <h2>Solicitações Concluídas</h2>
        <a href="{{ route('solicitacoes.index') }}" class="btn btn-sm btn-outline-primary d-flex">
            <div class=" d-flex gap-2 align-items-center">
                <span class="material-symbols-outlined align-middle me-1">arrow_back</span>
                Voltar para Solicitações
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
            <form action="{{ route('solicitacoes.concluidas') }}" method="GET" class="row g-3">
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
                        <label for="sort" class="form-label">Ordenar por</label>
                        <select name="sort" id="sort" class="form-select">
                            <option value="{{ App\Helpers\UrlHelper::sortUrl('created_at', 'desc') }}">Data (Mais recente)</option>
                            <option value="{{ App\Helpers\UrlHelper::sortUrl('created_at', 'asc') }}">Data (Mais antiga)</option>
                            <option value="{{ App\Helpers\UrlHelper::sortUrl('nome', 'asc') }}">Nome (A-Z)</option>
                            <option value="{{ App\Helpers\UrlHelper::sortUrl('nome', 'desc') }}">Nome (Z-A)</option>
                            <option value="{{ App\Helpers\UrlHelper::sortUrl('tipo', 'asc') }}">Tipo (A-Z)</option>
                            <option value="{{ App\Helpers\UrlHelper::sortUrl('tipo', 'desc') }}">Tipo (Z-A)</option>
                            <option value="{{ App\Helpers\UrlHelper::sortUrl('departamento', 'asc') }}">Departamento (A-Z)</option>
                            <option value="{{ App\Helpers\UrlHelper::sortUrl('departamento', 'desc') }}">Departamento (Z-A)</option>
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
                            <th class="bg-primary p-2 text-white">Prioridade</th>
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
                            <th class="bg-primary p-2 text-white">Status</th>
                            <th class="bg-primary p-2 text-white text-center">Detalhes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orcamentos as $orcamento)
                        <tr>
                            <td>{{ $orcamento->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $orcamento->nome }}</td>
                            <td>
                                @php
                                    if($orcamento->tipo == 'servico') {
                                        echo "Serviço";
                                    } else {
                                        echo ucfirst($orcamento->tipo);
                                    }
                                @endphp
                            </td>
                            <td alt="{{ $orcamento->descricao }}" title="{{ $orcamento->descricao }}">
                                @php
                                    if (strlen($orcamento->descricao) > 10) {
                                        echo substr($orcamento->descricao, 0, 10) . "...";
                                    } else {
                                        echo $orcamento->descricao;
                                    }
                                @endphp
                            </td>
                            <td>
                                @php
                                    $prioridadeClass = match($orcamento->prioridade) {
                                        'Imediata' => 'text-danger fw-bold',
                                        'Curto prazo' => 'text-orange fw-bold',
                                        'Médio prazo' => 'text-warning fw-bold',
                                        'Longo prazo' => 'text-success fw-bold',
                                        'Data específica(evento)' => 'text-primary fw-bold',
                                        default => ''
                                    };
                                @endphp
                                <span class="{{ $prioridadeClass }}">{{ $orcamento->prioridade }}</span>
                            </td>
                            <td>{{ $orcamento->departamento }}</td>
                            <td>
                                @php
                                    $statusClass = match($orcamento->status) {
                                        'Nova solicitação'                            => 'text-warning fw-bold',
                                        'Em análise'                                  => 'text-warning fw-bold',
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
@endsection
