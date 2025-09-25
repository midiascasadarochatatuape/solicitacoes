@extends('layouts.app')

@section('content')
<div class="container mb-5 pb-4">
    <h3 class="mb-4 fw-bold">Nova Solicitação</h3>
    <hr class="mb-0">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('solicitacoes.store') }}" method="POST" enctype="multipart/form-data" id="orcamentoForm">
        @csrf
        <div class="card p-0 border-0">
            <div class="card-body p-0">
                <!-- Informações Básicas -->
                <h4 class="fw-semibold text-primary card-title my-4">Informações Básicas</h4>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nome" class="form-label fw-bold">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="col-md-6">
                        <label for="departamento" class="form-label fw-bold">Departamento</label>
                        <select class="form-select" id="departamento" name="departamento" required>
                            <option value="">Selecione um departamento</option>
                            <option value="Adolescentes">Adolescentes</option>
                            <option value="Casa Abraça">Casa Abraça</option>
                            <option value="Casais da Casa">Casais da Casa</option>
                            <option value="Diaconia">Diaconia</option>
                            <option value="Infantil">Infantil</option>
                            <option value="Jovens">Jovens</option>
                            <option value="Louvor">Louvor</option>
                            <option value="Manutenção">Manutenção</option>
                            <option value="Midias e Transmissão">Midias e Transmissão</option>
                            <option value="Missões">Missões</option>
                            <option value="Mulheres">Mulheres</option>
                            <option value="Psicólogos">Psicólogos</option>
                            <option value="Social">Social</option>
                            <option value="Teatro">Teatro</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="descricao" class="form-label fw-bold">Descrição do pedido</label>
                    <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="prioridade" class="form-label fw-bold">Prioridade</label>
                        <select class="form-select" id="prioridade" name="prioridade" required>
                            <option value="">Selecione a prioridade</option>
                            <option value="Imediata">🔴 Imediata</option>
                            <option value="Curto prazo">🟠 Curto prazo (duas semanas)</option>
                            <option value="Médio prazo">🟡 Médio prazo (duas a seis semanas)</option>
                            <option value="Longo prazo">🟢 Longo prazo (mais de três meses)</option>
                            <option value="Data específica(evento)">🟣 Data específica (evento)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="preco" class="form-label fw-bold">Preço do pedido ou serviço</label>
                        <select class="form-select" id="preco" name="preco" required>
                            <option value="">Selecione a faixa de preço</option>
                            <option value="Custo baixo">$ Custo baixo (menos de R$ 100)</option>
                            <option value="Custo médio">$$ Custo médio (de R$ 100 a R$ 999)</option>
                            <option value="Custo alto">$$$ Custo alto (mais de R$ 1000)</option>
                            <option value="Custo altíssimo">$$$$ Custo altíssimo (mais de R$ 5000)</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 data-especifica" style="display: none;">
                    <label for="prioridade_data_especifica" class="form-label fw-bold">Explique a necessidade da data específica</label>
                    <textarea class="form-control" id="prioridade_data_especifica" name="prioridade_data_especifica" rows="2"></textarea>
                </div>

                <!-- Tipo de Solicitação -->
                <h4 class="fw-semibold text-primary card-title mt-5 mb-4">Tipo de Solicitação</h4>

                <div class="mb-3">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tipo" id="tipo_compra" value="compra" required>
                        <label class="form-check-label" for="tipo_compra">Compra</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tipo" id="tipo_servico" value="servico" required>
                        <label class="form-check-label" for="tipo_servico">Serviço</label>
                    </div>
                </div>

                <!-- Campos para Compra -->
                <div id="campos_compra" style="display: none;">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Links de compras e quantidade</label>
                        <div class="link-container mb-2">
                            <div class="d-flex gap-2">
                                <input type="url" class="form-control" name="link_concorrente_1" placeholder="Link 1">
                                <input type="text" name="qtde_1" style="width: 70px" class="form-control text-center" placeholder="Qtde.">
                            </div>
                            <div class="invalid-feedback">Este link já foi informado</div>
                        </div>
                        <div class="link-container mb-2">
                            <div class="d-flex gap-2">
                                <input type="url" class="form-control" name="link_concorrente_2" placeholder="Link 2">
                                <input type="text" name="qtde_2" style="width: 70px" class="form-control text-center" placeholder="Qtde.">
                            </div>
                            <div class="invalid-feedback">Este link já foi informado</div>
                        </div>
                        <div class="link-container mb-2">
                            <div class="d-flex gap-2">
                                <input type="url" class="form-control" name="link_concorrente_3" placeholder="Link 3">
                                <input type="text" name="qtde_3" style="width: 70px" class="form-control text-center" placeholder="Qtde.">
                            </div>
                            <div class="invalid-feedback">Este link já foi informado</div>
                        </div>
                    </div>

                    <!-- Tipo de Solicitação -->
                    <h4 class="card-title fw-semibold text-primary mb-4 mt-4">Entrega</h4>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="endereco_entrega" class="form-label fw-bold">Informações de Entrega</label>
                                <textarea class="form-control" id="endereco_entrega" name="endereco_entrega" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="telefone_contato" class="form-label fw-bold">Telefone de contato</label>
                                <input type="tel" class="form-control" id="telefone_contato" name="telefone_contato" placeholder="(XX) XXXXX-XXXX" maxlength="15" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Campos para Serviço -->
                <div id="campos_servico" style="display: none;">
                    <div class="servicos-container">
                        <!-- Serviço 1 -->
                        <div class="servico-item mb-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Solicitação em imagem 1</label>
                                <div class="image-container mb-2">
                                    <input type="file" class="form-control orcamento-imagem" name="orcamento_imagem_1" accept="image/*" data-servico="1">
                                    <div class="invalid-feedback">Esta imagem já foi selecionada</div>
                                </div>
                            </div>

                            <div class="servico-detalhes-1" style="display: none;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="data_servico_1" class="form-label fw-bold">Data</label>
                                            <input type="date" class="form-control" id="data_servico_1" name="data_servico_1">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="hora_servico_1" class="form-label fw-bold">Hora</label>
                                            <input type="time" class="form-control" id="hora_servico_1" name="hora_servico_1">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="responsavel_recebimento_1" class="form-label fw-bold">Quem vai receber</label>
                                            <input type="text" class="form-control" id="responsavel_recebimento_1" name="responsavel_recebimento_1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Serviço 2 -->
                        <div class="servico-item mb-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Solicitação em imagem 2</label>
                                <div class="image-container mb-2">
                                    <input type="file" class="form-control orcamento-imagem" name="orcamento_imagem_2" accept="image/*" data-servico="2">
                                    <div class="invalid-feedback">Esta imagem já foi selecionada</div>
                                </div>
                            </div>

                            <div class="servico-detalhes-2" style="display: none;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="data_servico_2" class="form-label fw-bold">Data</label>
                                            <input type="date" class="form-control" id="data_servico_2" name="data_servico_2">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="hora_servico_2" class="form-label fw-bold">Hora</label>
                                            <input type="time" class="form-control" id="hora_servico_2" name="hora_servico_2">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="responsavel_recebimento_2" class="form-label fw-bold">Quem vai receber</label>
                                            <input type="text" class="form-control" id="responsavel_recebimento_2" name="responsavel_recebimento_2">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Serviço 3 -->
                        <div class="servico-item mb-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Solicitação em imagem 3</label>
                                <div class="image-container mb-2">
                                    <input type="file" class="form-control orcamento-imagem" name="orcamento_imagem_3" accept="image/*" data-servico="3">
                                    <div class="invalid-feedback">Esta imagem já foi selecionada</div>
                                </div>
                            </div>

                            <div class="servico-detalhes-3" style="display: none;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="data_servico_3" class="form-label fw-bold">Data</label>
                                            <input type="date" class="form-control" id="data_servico_3" name="data_servico_3">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="hora_servico_3" class="form-label fw-bold">Hora</label>
                                            <input type="time" class="form-control" id="hora_servico_3" name="hora_servico_3">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="responsavel_recebimento_3" class="form-label fw-bold">Quem vai receber</label>
                                            <input type="text" class="form-control" id="responsavel_recebimento_3" name="responsavel_recebimento_3">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <button type="button" class="btn btn-primary" id="btnPrevisualizar">Revisar e Enviar</button>
        </div>
    </form>

    <!-- Modal de Confirmação -->
    <div class="modal fade" id="modalConfirmacao" tabindex="-1" aria-labelledby="modalConfirmacaoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalConfirmacaoLabel">Confirmar Solicitação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Informações Básicas -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">Informações Básicas</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Nome:</strong> <span id="preview-nome"></span></p>
                                    <p><strong>Departamento:</strong> <span id="preview-departamento"></span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Prioridade:</strong> <span id="preview-prioridade"></span></p>
                                    <p><strong>Preço:</strong> <span id="preview-preco"></span></p>
                                </div>
                            </div>
                            <p><strong>Descrição:</strong> <span id="preview-descricao"></span></p>
                            <div id="preview-prioridade-data-container" style="display: none;">
                                <p><strong>Justificativa da Data Específica:</strong> <span id="preview-prioridade-data"></span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Informações de Compra -->
                    <div class="card mb-3" id="preview-compra-card" style="display: none;">
                        <div class="card-header">
                            <h6 class="mb-0">Informações de Compra</h6>
                        </div>
                        <div class="card-body">
                            <p><strong>Links dos Concorrentes:</strong></p>
                            <ul>
                                <li class="mb-3">Link 1: <span id="preview-link1"></span> <span id="preview-qtde1"></span></li>
                                <li class="mb-3">Link 2: <span id="preview-link2"></span> <span id="preview-qtde2"></span></li>
                                <li class="mb-3">Link 3: <span id="preview-link3"></span> <span id="preview-qtde3"></span></li>
                            </ul>
                            <p><strong>Informações de Entrega:</strong> <span id="preview-endereco"></span></p>
                            <p><strong>Telefone de Contato:</strong> <span id="preview-telefone"></span></p>
                        </div>
                    </div>

                    <!-- Informações de Serviço -->
                    <div class="card mb-3" id="preview-servico-card" style="display: none;">
                        <div class="card-header">
                            <h6 class="mb-0">Informações de Serviço</h6>
                        </div>
                        <div class="card-body">
                            <!-- Serviço 1 -->
                            <div id="preview-servico-1" style="display: none;">
                                <h6>Serviço 1</h6>
                                <p><strong>Imagem:</strong> <span id="preview-imagem-1"></span></p>
                                <p><strong>Data:</strong> <span id="preview-data-1"></span></p>
                                <p><strong>Hora:</strong> <span id="preview-hora-1"></span></p>
                                <p><strong>Responsável:</strong> <span id="preview-responsavel-1"></span></p>
                                <hr>
                            </div>

                            <!-- Serviço 2 -->
                            <div id="preview-servico-2" style="display: none;">
                                <h6>Serviço 2</h6>
                                <p><strong>Imagem:</strong> <span id="preview-imagem-2"></span></p>
                                <p><strong>Data:</strong> <span id="preview-data-2"></span></p>
                                <p><strong>Hora:</strong> <span id="preview-hora-2"></span></p>
                                <p><strong>Responsável:</strong> <span id="preview-responsavel-2"></span></p>
                                <hr>
                            </div>

                            <!-- Serviço 3 -->
                            <div id="preview-servico-3" style="display: none;">
                                <h6>Serviço 3</h6>
                                <p><strong>Imagem:</strong> <span id="preview-imagem-3"></span></p>
                                <p><strong>Data:</strong> <span id="preview-data-3"></span></p>
                                <p><strong>Hora:</strong> <span id="preview-hora-3"></span></p>
                                <p><strong>Responsável:</strong> <span id="preview-responsavel-3"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar e Editar</button>
                    <button type="button" class="btn btn-primary" id="btnConfirmarEnvio">Confirmar e Enviar</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const prioridadeSelect = document.getElementById('prioridade');
    const dataEspecificaDiv = document.querySelector('.data-especifica');
    const tipoCompraRadio = document.getElementById('tipo_compra');
    const tipoServicoRadio = document.getElementById('tipo_servico');
    const camposCompra = document.getElementById('campos_compra');
    const camposServico = document.getElementById('campos_servico');
    const form = document.getElementById('orcamentoForm');
    const telefoneInput = document.getElementById('telefone_contato');

    // Função para formatar o telefone
    function formatarTelefone(telefone) {
        // Remove tudo que não for número
        const numero = telefone.replace(/\D/g, '');

        // Verifica o tamanho para determinar se é celular ou fixo
        if (numero.length <= 10) {
            // Telefone fixo: (XX) XXXX-XXXX
            return numero.replace(/(\d{2})?(\d{4})?(\d{4})/, function(match, ddd, parte1, parte2) {
                let resultado = '';
                if (ddd) resultado += `(${ddd}) `;
                if (parte1) resultado += `${parte1}`;
                if (parte2) resultado += `-${parte2}`;
                return resultado;
            });
        } else {
            // Celular: (XX) XXXXX-XXXX
            return numero.replace(/(\d{2})?(\d{5})?(\d{4})/, function(match, ddd, parte1, parte2) {
                let resultado = '';
                if (ddd) resultado += `(${ddd}) `;
                if (parte1) resultado += `${parte1}`;
                if (parte2) resultado += `-${parte2}`;
                return resultado;
            });
        }
    }

    // Aplica máscara ao digitar
    telefoneInput.addEventListener('input', function(e) {
        let valor = e.target.value;
        valor = valor.replace(/\D/g, ''); // Remove tudo que não for número
        if (valor.length > 11) valor = valor.slice(0, 11); // Limita a 11 dígitos
        e.target.value = formatarTelefone(valor);
    });

    // Função para validar e marcar links duplicados
    function validarLinks(currentInput = null) {
        const linkInputs = document.querySelectorAll('[name^="link_concorrente_"]');
        const links = new Map(); // Usar Map para rastrear links e suas ocorrências

        // Primeiro, colete todos os links e conte suas ocorrências
        linkInputs.forEach(input => {
            const value = input.value.trim();
            if (value !== '') {
                links.set(value, (links.get(value) || 0) + 1);
            }
        });

        // Marque os campos com links duplicados
        linkInputs.forEach(input => {
            const value = input.value.trim();
            const isDuplicate = value !== '' && links.get(value) > 1;

            // Adiciona ou remove as classes de validação
            input.classList.toggle('is-invalid', isDuplicate);

            // Mostra ou esconde a mensagem de feedback
            const feedbackElement = input.nextElementSibling;
            if (feedbackElement && feedbackElement.classList.contains('invalid-feedback')) {
                feedbackElement.style.display = isDuplicate ? 'block' : 'none';
            }
        });

        return links;
    }

    // Função para validar imagens duplicadas
    async function validarImagens(currentInput = null) {
        const imageInputs = document.querySelectorAll('[name^="orcamento_imagem_"]');
        const fileMap = new Map(); // Mapa para armazenar hash -> contagem

        // Função para gerar hash da imagem
        async function generateHash(file) {
            return new Promise((resolve) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Usa o nome e tamanho do arquivo como identificador
                    // Você também pode usar a data de modificação se necessário
                    const hash = `${file.name}-${file.size}`;
                    resolve(hash);
                };
                reader.readAsArrayBuffer(file);
            });
        }

        // Coletar todos os hashes de arquivo
        const promises = Array.from(imageInputs).map(async input => {
            if (input.files.length > 0) {
                const file = input.files[0];
                const hash = await generateHash(file);
                if (fileMap.has(hash)) {
                    fileMap.set(hash, fileMap.get(hash) + 1);
                } else {
                    fileMap.set(hash, 1);
                }
                return { input, hash };
            }
            return { input, hash: null };
        });

        const results = await Promise.all(promises);

        // Marcar duplicatas
        results.forEach(({ input, hash }) => {
            const isDuplicate = hash !== null && fileMap.get(hash) > 1;

            // Adiciona ou remove as classes de validação
            input.classList.toggle('is-invalid', isDuplicate);

            // Mostra ou esconde a mensagem de feedback
            const feedbackElement = input.nextElementSibling;
            if (feedbackElement && feedbackElement.classList.contains('invalid-feedback')) {
                feedbackElement.style.display = isDuplicate ? 'block' : 'none';
            }
        });

        return fileMap;
    }

    // Controle do campo de data específica
    prioridadeSelect.addEventListener('change', function() {
        if (this.value === 'Data específica(evento)') {
            dataEspecificaDiv.style.display = 'block';
        } else {
            dataEspecificaDiv.style.display = 'none';
        }
    });

    // Controle dos campos de compra/serviço
    function toggleCampos() {
        if (tipoCompraRadio.checked) {
            camposCompra.style.display = 'block';
            camposServico.style.display = 'none';
            // Limpa os campos de serviço
            document.querySelectorAll('[name^="orcamento_imagem_"]').forEach(input => {
                input.value = '';
                toggleServicoDetalhes(input.dataset.servico);
            });
        } else if (tipoServicoRadio.checked) {
            camposCompra.style.display = 'none';
            camposServico.style.display = 'block';
            // Limpa os campos de compra
            document.querySelectorAll('[name^="link_concorrente_"]').forEach(input => input.value = '');
        }
    }

    // Eventos para validar links em tempo real
    document.querySelectorAll('[name^="link_concorrente_"]').forEach(input => {
        input.addEventListener('input', function() {
            validarLinks(this);

            // Verifica se há links duplicados
            const links = validarLinks();
            let hasDuplicates = false;
            links.forEach((count) => {
                if (count > 1) hasDuplicates = true;
            });

            // Desabilita o botão de previsualização se houver duplicatas
            btnPrevisualizar.disabled = hasDuplicates;
        });

        input.addEventListener('blur', function() {
            validarLinks(this);

            // Verifica se há links duplicados
            const links = validarLinks();
            let hasDuplicates = false;
            links.forEach((count) => {
                if (count > 1) hasDuplicates = true;
            });

            // Desabilita o botão de previsualização se houver duplicatas
            btnPrevisualizar.disabled = hasDuplicates;

            if (hasDuplicates) {
                alert('Links duplicados detectados. Por favor, remova os links duplicados para continuar.');
            }
        });
    });

    // Validação final antes do envio
    form.addEventListener('submit', function(e) {
        const links = validarLinks();
        let hasDuplicates = false;

        links.forEach((count) => {
            if (count > 1) hasDuplicates = true;
        });

        if (hasDuplicates) {
            e.preventDefault();
            alert('Por favor, remova os links duplicados antes de enviar o formulário.');
        }
    });

    // Função para mostrar/ocultar campos de detalhes do serviço
    function toggleServicoDetalhes(servicoNum) {
        const detalhesDiv = document.querySelector(`.servico-detalhes-${servicoNum}`);
        const imageInput = document.querySelector(`[name="orcamento_imagem_${servicoNum}"]`);

        if (imageInput.files.length > 0) {
            detalhesDiv.style.display = 'block';

            // Torna os campos obrigatórios
            const campos = detalhesDiv.querySelectorAll('input');
            campos.forEach(campo => campo.required = true);
        } else {
            detalhesDiv.style.display = 'none';

            // Remove a obrigatoriedade e limpa os campos
            const campos = detalhesDiv.querySelectorAll('input');
            campos.forEach(campo => {
                campo.required = false;
                campo.value = '';
            });
        }
    }

    // Eventos para validar imagens e mostrar campos de detalhes
    document.querySelectorAll('[name^="orcamento_imagem_"]').forEach(input => {
        input.addEventListener('change', async function() {
            await validarImagens(this);
            toggleServicoDetalhes(this.dataset.servico);
        });
    });

    tipoCompraRadio.addEventListener('change', toggleCampos);
    tipoServicoRadio.addEventListener('change', toggleCampos);

    // Validação final antes do envio
    form.addEventListener('submit', async function(e) {
        const links = validarLinks();
        const imagens = await validarImagens();
        let hasDuplicates = false;

        links.forEach((count) => {
            if (count > 1) hasDuplicates = true;
        });

        imagens.forEach((count) => {
            if (count > 1) hasDuplicates = true;
        });

        if (hasDuplicates) {
            e.preventDefault();
            alert('Por favor, remova os itens duplicados (links ou imagens) antes de enviar o formulário.');
        }
    });

    // Função para formatar data
    function formatarData(data) {
        if (!data) return '';
        const [ano, mes, dia] = data.split('-');
        return `${dia}/${mes}/${ano}`;
    }

    // Botão de previsualização
    const btnPrevisualizar = document.getElementById('btnPrevisualizar');
    const modalConfirmacao = new bootstrap.Modal(document.getElementById('modalConfirmacao'));

    btnPrevisualizar.addEventListener('click', function() {
        // Validar formulário antes de mostrar o modal
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        // Validar links duplicados se for tipo compra
        if (document.getElementById('tipo_compra').checked) {
            const links = validarLinks();
            let hasDuplicates = false;

            links.forEach((count) => {
                if (count > 1) hasDuplicates = true;
            });

            if (hasDuplicates) {
                alert('Por favor, remova os links duplicados antes de continuar.');
                return;
            }
        }

        // Informações Básicas
        document.getElementById('preview-nome').textContent = document.getElementById('nome').value;
        document.getElementById('preview-departamento').textContent = document.getElementById('departamento').value;
        document.getElementById('preview-descricao').textContent = document.getElementById('descricao').value;
        document.getElementById('preview-prioridade').textContent = document.getElementById('prioridade').value;
        document.getElementById('preview-preco').textContent = document.getElementById('preco').value;

        // Data específica (se aplicável)
        const prioridadeDataContainer = document.getElementById('preview-prioridade-data-container');
        if (document.getElementById('prioridade').value === 'Data específica(evento)') {
            document.getElementById('preview-prioridade-data').textContent = document.getElementById('prioridade_data_especifica').value;
            prioridadeDataContainer.style.display = 'block';
        } else {
            prioridadeDataContainer.style.display = 'none';
        }

        // Limpar e mostrar apenas as informações relevantes para o tipo selecionado
        const tipoCompra = document.getElementById('tipo_compra').checked;
        document.getElementById('preview-compra-card').style.display = tipoCompra ? 'block' : 'none';
        document.getElementById('preview-servico-card').style.display = !tipoCompra ? 'block' : 'none';

        if (tipoCompra) {
            // Informações de Compra
            for(let i = 1; i <= 3; i++) {
                const link = document.querySelector(`[name="link_concorrente_${i}"]`).value;
                const qtde = document.querySelector(`[name="qtde_${i}"]`).value;

                document.getElementById(`preview-link${i}`).textContent = link || 'Não informado';
                document.getElementById(`preview-qtde${i}`).textContent = qtde ? ` - Quantidade: ${qtde}` : '';
            }
            document.getElementById('preview-endereco').textContent = document.getElementById('endereco_entrega').value || 'Não informado';
            document.getElementById('preview-telefone').textContent = document.getElementById('telefone_contato').value || 'Não informado';
        } else {
            // Informações de Serviço
            for (let i = 1; i <= 3; i++) {
                const previewServico = document.getElementById(`preview-servico-${i}`);
                const imagemInput = document.querySelector(`[name="orcamento_imagem_${i}"]`);

                if (imagemInput.files.length > 0) {
                    document.getElementById(`preview-imagem-${i}`).textContent = imagemInput.files[0].name;
                    document.getElementById(`preview-data-${i}`).textContent = formatarData(document.getElementById(`data_servico_${i}`).value);
                    document.getElementById(`preview-hora-${i}`).textContent = document.getElementById(`hora_servico_${i}`).value;
                    document.getElementById(`preview-responsavel-${i}`).textContent = document.getElementById(`responsavel_recebimento_${i}`).value;
                    previewServico.style.display = 'block';
                } else {
                    previewServico.style.display = 'none';
                }
            }
        }

        modalConfirmacao.show();
    });

    // Botão de confirmação no modal
    document.getElementById('btnConfirmarEnvio').addEventListener('click', function() {
        // Validar links duplicados uma última vez antes do envio
        if (document.getElementById('tipo_compra').checked) {
            const links = validarLinks();
            let hasDuplicates = false;

            links.forEach((count) => {
                if (count > 1) hasDuplicates = true;
            });

            if (hasDuplicates) {
                alert('Por favor, remova os links duplicados antes de enviar o formulário.');
                modalConfirmacao.hide();
                return;
            }
        }

        // Submeter o formulário
        form.submit();
    });
});
</script>
@endpush
@endsection
