@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-header d-flex justify-content-between align-items-center border-0 bg-white px-0">
                    <h3 class="mb-0">Detalhes da Solicitação</h3>
                    @auth @if(auth()->user()->is_admin)
                    <a href="https://wa.me/?text={{ urlencode(url()->full()) }}" class="mb-0 pb-0 gap-2 d-flex align-items-center text-decoration-none" target="_blank" title="Compartilhar via WhatsApp">
                        <span class="material-symbols-outlined mb-0 pb-0">
                            share
                        </span> Compartilhar no WhatsApp
                    </a>
                    @endif @endauth
                </div>
                <hr>
                <div class="card-body p-0">
                    <div class="mb-4">
                        <h4 class="my-4">Informações:</h4>
                        <div class="d-flex px-3 py-2 bg-lighter rounded mb-2 border">
                            <div class="col-md-4"><p class="m-0"><strong>Nome:</strong> {{ $orcamento->nome }}</p></div>
                            <div class="col-md-4"><p class="m-0"><strong>Departamento:</strong> {{ $orcamento->departamento }}</p></div>
                        </div>

                        <div class="d-flex px-3 py-2 bg-lighter rounded mb-2 border">
                            <div class="col-12">
                                <p class="m-0"><strong>Descrição:</strong> {{ $orcamento->descricao }}</p>
                            </div>
                        </div>

                        <div class="d-flex px-3 py-2 bg-lighter rounded mb-2 border">
                            <div class="col-md-3"><p class="m-0"><strong>Prioridade:</strong> {{ $orcamento->prioridade }}</p></div>
                            @if($orcamento->prioridade_data_especifica)
                            <div class="col-md-3">
                                <p class="m-0"><strong>Detalhes da Data Específica:</strong> {{ $orcamento->prioridade_data_especifica }}</p>
                            </div>
                            @endif
                            <div class="col-md-3"><p class="m-0"><strong>Preço:</strong> {{ $orcamento->preco }}</p></div>
                            <div class="col-md-3"><p class="m-0"><strong>Tipo:</strong> {{ ucfirst($orcamento->tipo) }}</p></div>
                        </div>

                        <div class="d-flex px-3 py-2 bg-lighter rounded mb-2 border">
                            <p class="m-0"><strong>Status Atual:</strong> {{ $orcamento->status }}</p>
                        </div>

                        <div class="d-flex px-3 py-2 bg-lighter rounded mb-2 border">
                            @if($orcamento->tipo === 'compra')
                                <div class="">
                                    <h6>Detalhes da Compra</h6>
                                    @if($orcamento->link_concorrente_1)
                                        <p class="m-0"><strong>Link 1:</strong>
                                            <a href="{{ $orcamento->link_concorrente_1 }}" target="_blank">
                                                @php
                                                if (strlen($orcamento->link_concorrente_1) > 70) {
                                                    echo substr($orcamento->link_concorrente_1, 0, 70) . "...";
                                                } else {
                                                    echo $orcamento->link_concorrente_1;
                                                }
                                            @endphp
                                            </a>
                                            <br /><strong>Qtde.:</strong> {{ $orcamento->qtde_1 }}</p>
                                        <hr>
                                        @endif
                                    @if($orcamento->link_concorrente_2)
                                        <p class="m-0"><strong>Link 2:</strong>
                                            <a href="{{ $orcamento->link_concorrente_2 }}" target="_blank">
                                                <a href="{{ $orcamento->link_concorrente_2 }}" target="_blank">
                                                @php
                                                if (strlen($orcamento->link_concorrente_2) > 70) {
                                                    echo substr($orcamento->link_concorrente_2, 0, 70) . "...";
                                                } else {
                                                    echo $orcamento->link_concorrente_2;
                                                }
                                            @endphp
                                            </a>
                                            <br /><strong>Qtde.:</strong> {{ $orcamento->qtde_2 }}</p>
                                        <hr>
                                        @endif
                                    @if($orcamento->link_concorrente_3)
                                        <p class="m-0"><strong>Link 3:</strong>
                                            <a href="{{ $orcamento->link_concorrente_3 }}" target="_blank">
                                                <a href="{{ $orcamento->link_concorrente_3 }}" target="_blank">
                                                @php
                                                if (strlen($orcamento->link_concorrente_3) > 70) {
                                                    echo substr($orcamento->link_concorrente_3, 0, 70) . "...";
                                                } else {
                                                    echo $orcamento->link_concorrente_3;
                                                }
                                            @endphp
                                            </a><br /><strong>Qtde.:</strong> {{ $orcamento->qtde_3 }}</p>
                                        <hr>
                                        @endif
                                    @if($orcamento->endereco_entrega)
                                        <p class="m-0"><strong>Endereço de Entrega:</strong> {{ $orcamento->endereco_entrega }}</p>
                                    @endif
                                    @if($orcamento->telefone_contato)
                                        <p class="m-0"><strong>Telefone de Contato:</strong> {{ $orcamento->telefone_contato }}</p>
                                    @endif
                                    @if($orcamento->data_compra)
                                        <p class="m-0"><strong>Informações sobre data/entrega:</strong> {{ $orcamento->data_compra }}</p>
                                    @endif
                                </div>
                            @else
                                <div class="my-5 row">
                                    <h4 class="fw-semibold mb-4">Detalhes do Serviço</h4>
                                    @if($orcamento->orcamento_imagem_1)
                                        <div class="col-md-4 mb-2">
                                            <h5>Orçamento 1:</h5>
                                            <div class="d-flex align-items-center mb-3">
                                                <img src="{{ Storage::url($orcamento->orcamento_imagem_1) }}" alt="Solicitação 1" class="img-orcamento cursor-pointer" style="cursor: pointer;" onclick="abrirModal('{{ Storage::url($orcamento->orcamento_imagem_1) }}', 'Orçamento 1')">
                                            </div>
                                            @if($orcamento->data_servico_1)
                                                <p class="m-0"><strong>Data:</strong> {{ \Carbon\Carbon::parse($orcamento->data_servico_1)->format('d/m/Y') }}
                                            @endif
                                            @if($orcamento->hora_servico_1)
                                                | <strong>Hora:</strong> {{ \Carbon\Carbon::parse($orcamento->hora_servico_1)->format('H:i') }}<br />
                                            @endif
                                            @if($orcamento->responsavel_recebimento_1)
                                                <strong>Responsável pelo Recebimento:</strong> {{ $orcamento->responsavel_recebimento_1 }}</p>
                                            @endif
                                        </div>
                                    @endif
                                    @if($orcamento->orcamento_imagem_2)
                                        <div class="col-md-4 mb-2">
                                            <h5>Orçamento 2:</h5>
                                            <div class="d-flex align-items-center mb-3">
                                                <img src="{{ Storage::url($orcamento->orcamento_imagem_2) }}" alt="Solicitação 2" class="img-orcamento cursor-pointer" style="cursor: pointer;" onclick="abrirModal('{{ Storage::url($orcamento->orcamento_imagem_2) }}', 'Orçamento 2')">
                                            </div>
                                            @if($orcamento->data_servico_2)
                                                <p class="m-0"><strong>Data:</strong> {{ \Carbon\Carbon::parse($orcamento->data_servico_2)->format('d/m/Y') }}
                                            @endif
                                            @if($orcamento->hora_servico_2)
                                                | <strong>Hora:</strong> {{ \Carbon\Carbon::parse($orcamento->hora_servico_2)->format('H:i') }}<br />
                                            @endif
                                            @if($orcamento->responsavel_recebimento_2)
                                                <strong>Responsável pelo Recebimento:</strong> {{ $orcamento->responsavel_recebimento_2 }}</p>
                                            @endif
                                        </div>
                                    @endif
                                    @if($orcamento->orcamento_imagem_3)
                                        <div class="col-md-4 mb-2">
                                            <h5>Orçamento 3:</h5>
                                            <div class="d-flex align-items-center mb-3">
                                                <img src="{{ Storage::url($orcamento->orcamento_imagem_3) }}" alt="Solicitação 3" class="img-orcamento cursor-pointer" style="cursor: pointer;" onclick="abrirModal('{{ Storage::url($orcamento->orcamento_imagem_3) }}', 'Orçamento 3')">
                                            </div>
                                            @if($orcamento->data_servico_3)
                                                <p class="m-0"><strong>Data:</strong> {{ \Carbon\Carbon::parse($orcamento->data_servico_3)->format('d/m/Y') }}
                                            @endif
                                            @if($orcamento->hora_servico_3)
                                                | <strong>Hora:</strong> {{ \Carbon\Carbon::parse($orcamento->hora_servico_3)->format('H:i') }}<br />
                                            @endif
                                            @if($orcamento->responsavel_recebimento_3)
                                                <strong>Responsável pelo Recebimento:</strong> {{ $orcamento->responsavel_recebimento_3 }}</p>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>



                        <div class="d-flex flex-column px-3 py-2 bg-lighter rounded mb-2 border">
                            <div class="mb-4">
                                @if($orcamento->status_observacao)
                                    <p class="m-0"><strong>Observações:</strong> {{ $orcamento->status_observacao }}</p>
                                @endif
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="javascript:history.back()" class="btn btn-outline-secondary">Voltar</a>
                                @auth
                                    @if(auth()->user()->is_admin)
                                        <a href="{{ route('solicitacoes.edit', ['solicitaco' => $orcamento->id]) }}" class="btn btn-primary">Editar Status</a>
                                    @endif
                                @endauth
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

@push('scripts')
<script>
function abrirModal(imagemUrl, titulo) {
    const modal = new bootstrap.Modal(document.getElementById('imagemModal'));
    document.getElementById('imagemAmpliada').src = imagemUrl;
    document.getElementById('imagemModalLabel').textContent = titulo;
    modal.show();
}
</script>
@endpush
@endsection
