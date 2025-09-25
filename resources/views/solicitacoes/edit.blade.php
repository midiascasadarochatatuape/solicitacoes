@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-header d-flex justify-content-between align-items-center border-0 bg-white px-0">
                    <h3 class="mb-0">Atualizar Status da Solicitação</h3>
                    <div class="d-flex flex-md-row flex-column gap-md-2 gap-3">
                        @if($solicitacoes->tipo === 'compra' && $solicitacoes->status !== 'Compra concluída')
                            <button type="button" class="btn btn-apcalt text-white" onclick="showConfirmacao('compra', {{ $solicitacoes->id }})">
                                <span class="material-symbols-outlined align-middle me-1">check_circle</span>
                                Finalizar Solicitação
                            </button>
                        @elseif($solicitacoes->tipo === 'servico' && $solicitacoes->status !== 'Serviço concluído')
                            <button type="button" class="btn btn-apcalt text-white" onclick="showConfirmacao('servico', {{ $solicitacoes->id }})">
                                <span class="material-symbols-outlined align-middle me-1">check_circle</span>
                                Finalizar Solicitação
                            </button>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="card-body p-0">
                    <div class="mb-4">
                        <h4 class="my-4">Informações da solicitação:</h4>
                        <div class="d-flex px-3 py-2 bg-lighter rounded mb-2 border">
                            <div class="col-md-4"><p class="m-0"><strong>Nome:</strong> {{ $solicitacoes->nome }}</p></div>
                            <div class="col-md-4"><p class="m-0"><strong>Departamento:</strong> {{ $solicitacoes->departamento }}</p></div>
                        </div>
                        <div class="d-flex px-3 py-2 bg-lighter rounded mb-2 border">
                            <div class="col-12">
                                <p class="m-0"><strong>Descrição:</strong> {{ $solicitacoes->descricao }}</p>
                            </div>
                        </div>
                        <div class="d-flex px-3 py-2 bg-lighter rounded mb-2 border">
                            <div class="col-md-3"><p class="m-0"><strong>Prioridade:</strong> {{ $solicitacoes->prioridade }}</p></div>

                            @if($solicitacoes->prioridade_data_especifica)
                            <div class="col-md-3">
                                <p class="m-0"><strong>Detalhes da Data Específica:</strong> {{ $solicitacoes->prioridade_data_especifica }}</p>
                            </div>
                            @endif
                            <div class="col-md-3"><p class="m-0"><strong>Preço:</strong> {{ $solicitacoes->preco }}</p></div>
                            <div class="col-md-3"><p class="m-0"><strong>Tipo:</strong> {{ ucfirst($solicitacoes->tipo) }}</p></div>
                        </div>

                        <div class="d-flex px-3 py-2 bg-lighter rounded mb-2 border">
                            <div class="col-12">
                                <p class="m-0"><strong>Status Atual:</strong> {{ $solicitacoes->status }}</p>
                            </div>
                        </div>
                        <div class="d-flex px-3 py-2 bg-lighter rounded mb-2 border">
                            <div class="col-12">
                                @if($solicitacoes->tipo === 'compra')
                                    <div class="">
                                        @if($solicitacoes->link_concorrente_1)
                                            <p class="m-0"><strong>Link 1:</strong>
                                                <a href="{{ $solicitacoes->link_concorrente_1 }}" target="_blank">
                                                    @php
                                                    if (strlen($solicitacoes->link_concorrente_1) > 70) {
                                                        echo substr($solicitacoes->link_concorrente_1, 0, 70) . "...";
                                                    } else {
                                                        echo $solicitacoes->link_concorrente_1;
                                                    }
                                                @endphp
                                                </a>
                                                <br /><strong>Qtde.:</strong> {{ $solicitacoes->qtde_1 }}</p>
                                            <hr>
                                            @endif
                                        @if($solicitacoes->link_concorrente_2)
                                            <p class="m-0"><strong>Link 2:</strong>
                                                <a href="{{ $solicitacoes->link_concorrente_2 }}" target="_blank">
                                                    <a href="{{ $solicitacoes->link_concorrente_2 }}" target="_blank">
                                                    @php
                                                    if (strlen($solicitacoes->link_concorrente_2) > 70) {
                                                        echo substr($solicitacoes->link_concorrente_2, 0, 70) . "...";
                                                    } else {
                                                        echo $solicitacoes->link_concorrente_2;
                                                    }
                                                @endphp
                                                </a>
                                                <br /><strong>Qtde.:</strong> {{ $solicitacoes->qtde_2 }}</p>
                                            <hr>
                                            @endif
                                        @if($solicitacoes->link_concorrente_3)
                                            <p class="m-0"><strong>Link 3:</strong>
                                                <a href="{{ $solicitacoes->link_concorrente_3 }}" target="_blank">
                                                    <a href="{{ $solicitacoes->link_concorrente_3 }}" target="_blank">
                                                    @php
                                                    if (strlen($solicitacoes->link_concorrente_3) > 70) {
                                                        echo substr($solicitacoes->link_concorrente_3, 0, 70) . "...";
                                                    } else {
                                                        echo $solicitacoes->link_concorrente_3;
                                                    }
                                                @endphp
                                                </a><br /><strong>Qtde.:</strong> {{ $solicitacoes->qtde_3 }}</p>
                                            <hr>
                                            @endif
                                        @if($solicitacoes->endereco_entrega)
                                            <p class="m-0"><strong>Endereço de Entrega:</strong> {{ $solicitacoes->endereco_entrega }}</p>
                                        @endif
                                        @if($solicitacoes->telefone_contato)
                                            <p class="m-0"><strong>Telefone de Contato:</strong> {{ $solicitacoes->telefone_contato }}</p>
                                        @endif
                                        @if($solicitacoes->data_compra)
                                            <p class="m-0"><strong>Informações sobre data/entrega:</strong> {{ $solicitacoes->data_compra }}</p>
                                        @endif
                                    </div>
                                @else
                                    <div class="my-5 row">
                                        @if($solicitacoes->orcamento_imagem_1)
                                            <div class="col-md-4 mb-2">
                                                <h5>Orçamento 1:</h5>
                                                <div class="d-flex align-items-center mb-3">
                                                    <img src="{{ Storage::url($solicitacoes->orcamento_imagem_1) }}" alt="Solicitação 1" class="img-orcamento cursor-pointer" style="cursor: pointer;" onclick="abrirModal('{{ Storage::url($solicitacoes->orcamento_imagem_1) }}', 'Orçamento 1')">
                                                </div>
                                                @if($solicitacoes->data_servico_1)
                                                    <p class="m-0"><strong>Data:</strong> {{ \Carbon\Carbon::parse($solicitacoes->data_servico_1)->format('d/m/Y') }}
                                                @endif
                                                @if($solicitacoes->hora_servico_1)
                                                    | <strong>Hora:</strong> {{ \Carbon\Carbon::parse($solicitacoes->hora_servico_1)->format('H:i') }}<br />
                                                @endif
                                                @if($solicitacoes->responsavel_recebimento_1)
                                                    <strong>Responsável pelo Recebimento:</strong> {{ $solicitacoes->responsavel_recebimento_1 }}</p>
                                                @endif
                                            </div>
                                        @endif
                                        @if($solicitacoes->orcamento_imagem_2)
                                            <div class="col-md-4 mb-2">
                                                <h5>Orçamento 2:</h5>
                                                <div class="d-flex align-items-center mb-3">
                                                    <img src="{{ Storage::url($solicitacoes->orcamento_imagem_2) }}" alt="Solicitação 2" class="img-orcamento cursor-pointer" style="cursor: pointer;" onclick="abrirModal('{{ Storage::url($solicitacoes->orcamento_imagem_2) }}', 'Orçamento 2')">
                                                </div>
                                                @if($solicitacoes->data_servico_2)
                                                    <p class="m-0"><strong>Data:</strong> {{ \Carbon\Carbon::parse($solicitacoes->data_servico_2)->format('d/m/Y') }}
                                                @endif
                                                @if($solicitacoes->hora_servico_2)
                                                    | <strong>Hora:</strong> {{ \Carbon\Carbon::parse($solicitacoes->hora_servico_2)->format('H:i') }}<br />
                                                @endif
                                                @if($solicitacoes->responsavel_recebimento_2)
                                                    <strong>Responsável pelo Recebimento:</strong> {{ $solicitacoes->responsavel_recebimento_2 }}</p>
                                                @endif
                                            </div>
                                        @endif
                                        @if($solicitacoes->orcamento_imagem_3)
                                            <div class="col-md-4 mb-2">
                                                <h5>Orçamento 3:</h5>
                                                <div class="d-flex align-items-center mb-3">
                                                    <img src="{{ Storage::url($solicitacoes->orcamento_imagem_3) }}" alt="Solicitação 3" class="img-orcamento cursor-pointer" style="cursor: pointer;" onclick="abrirModal('{{ Storage::url($solicitacoes->orcamento_imagem_3) }}', 'Orçamento 3')">
                                                </div>
                                                @if($solicitacoes->data_servico_3)
                                                    <p class="m-0"><strong>Data:</strong> {{ \Carbon\Carbon::parse($solicitacoes->data_servico_3)->format('d/m/Y') }}
                                                @endif
                                                @if($solicitacoes->hora_servico_3)
                                                    | <strong>Hora:</strong> {{ \Carbon\Carbon::parse($solicitacoes->hora_servico_3)->format('H:i') }}<br />
                                                @endif
                                                @if($solicitacoes->responsavel_recebimento_3)
                                                    <strong>Responsável pelo Recebimento:</strong> {{ $solicitacoes->responsavel_recebimento_3 }}</p>
                                                @endif
                                            </div>
                                        @endif

                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex px-3 py-2 bg-lighter rounded mb-2 border">
                            <div class="col-12">
                                <form method="POST" class="row" action="{{ route('solicitacoes.update', $solicitacoes) }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="col-md-3 mb-3">
                                        <label for="prioridade" class="form-label fw-bold">Nova Prioridade</label>
                                        <select class="form-select" id="prioridade" name="prioridade" required>
                                            <option value="">Selecione um status</option>
                                            @foreach($getPriorityOptions as $options)
                                                <option value="{{ $options }}" {{ $solicitacoes->prioridade == $options ? 'selected' : '' }}>
                                                    {{ $options }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @if($solicitacoes->tipo === 'compra')
                                        <div class="col-md-3 mb-3">
                                            <label for="status" class="form-label fw-bold">Novo Status</label>
                                            <select class="form-select" id="status" name="status" required>
                                                <option value="">Selecione um status</option>
                                                @foreach($statusComprasOptions as $status)
                                                    <option value="{{ $status }}" {{ $solicitacoes->status == $status ? 'selected' : '' }}>
                                                        {{ $status }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @elseif($solicitacoes->tipo === 'servico')

                                    <div class="col-md-3 mb-3">
                                        <label for="status" class="form-label fw-bold">Novo Status</label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="">Selecione um status</option>
                                            @foreach($statusServicoOptions as $status_servico)
                                                <option value="{{ $status_servico }}" {{ $solicitacoes->status == $status_servico ? 'selected' : '' }}>
                                                    {{ $status_servico }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif
                                    <div class="mb-3" id="observacaoDiv" style="display: none;">
                                        <label for="status_observacao" class="form-label fw-bold">Observações sobre as alterações</label>
                                        <textarea class="form-control" id="status_observacao" name="status_observacao" rows="3">{{ $solicitacoes->status_observacao }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="data_compra" class="form-label fw-bold">Informações da Data/Entrega</label>
                                        <textarea class="form-control" id="data_compra" name="data_compra" rows="3"></textarea>
                                    </div>

                                    <div class="d-flex flex-md-row flex-column-reverse justify-content-between align-items-center gap-3">
                                        <a href="javascript:history.back()" class="btn btn-outline-secondary">Voltar</a>
                                        <div class="d-flex flex-md-row flex-column gap-md-2 gap-3">
                                            <button type="submit" class="btn btn-entregue tex">Atualizar Status</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ampliar imagens -->
<div class="modal fade" id="imagemModal" tabindex="-1" aria-labelledby="imagemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imagemModalLabel">Visualização da Imagem</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="imagemAmpliada" src="" alt="Imagem Ampliada" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação -->
<div class="modal fade" id="confirmacaoModal" tabindex="-1" aria-labelledby="confirmacaoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmacaoModalLabel">Confirmar Finalização</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="m-0">Tem certeza que deseja finalizar esta solicitação?</p>
                <p class="text-muted mb-0">Esta ação irá mover a solicitação para a lista de concluídas.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success text-white" id="confirmarFinalizacao">Confirmar</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function abrirModal(imagemUrl, titulo) {
    const modal = new bootstrap.Modal(document.getElementById('imagemModal'));
    document.getElementById('imagemAmpliada').src = imagemUrl;
    document.getElementById('imagemModalLabel').textContent = titulo;
    modal.show();
}

function showConfirmacao(tipo, orcamentoId) {
    const modal = new bootstrap.Modal(document.getElementById('confirmacaoModal'));

    // Configurar o botão de confirmar
    document.getElementById('confirmarFinalizacao').onclick = function() {
        console.log('Finalizando tipo:', tipo, 'ID:', orcamentoId);

        // Usar a rota específica para finalização
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/solicitacoes/${orcamentoId}/finalizar`;

        // CSRF Token
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        form.appendChild(csrfInput);

        // Method PATCH
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PATCH';
        form.appendChild(methodInput);

        document.body.appendChild(form);
        modal.hide();

        setTimeout(() => {
            form.submit();
        }, 100);
    };

    modal.show();
}document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const observacaoDiv = document.getElementById('observacaoDiv');

    function toggleObservacao() {
        if (statusSelect.value === 'Aprovado com alterações') {
            observacaoDiv.style.display = 'block';
        } else {
            observacaoDiv.style.display = 'none';
        }
    }

    statusSelect.addEventListener('change', toggleObservacao);
    toggleObservacao(); // Executar na carga inicial
});
</script>
@endpush
@endsection
