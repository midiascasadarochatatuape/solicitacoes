<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orcamento;
use App\Traits\FiltrosTrait;

class OrcamentoController extends Controller
{
    use FiltrosTrait;

    public function __construct()
    {
        // Não aplicar verificação CSRF em modo de teste/debug
        // $this->middleware('auth')->only(['edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Orcamento::emAndamento();
        $query = $this->aplicarFiltros($request, $query);
        $orcamentos = $query->paginate(15)->withQueryString();
        $departamentos = Orcamento::distinct()->pluck('departamento');
        $prioridades = ['Imediata', 'Curto prazo', 'Médio prazo', 'Longo prazo', 'Data específica(evento)'];
        $tipos = ['compra', 'servico'];
        $statusFilterOptions = Orcamento::getFilterStatusOptions();

        return view('solicitacoes.index', compact('orcamentos', 'departamentos', 'prioridades', 'tipos', 'statusFilterOptions'));
    }

    public function apiIndex(Request $request)
    {
        $query = Orcamento::emAndamento();
        $query = $this->aplicarFiltros($request, $query);
        $orcamentos = $query->paginate(15)->withQueryString();

        return response()->json([
            'success' => true,
            'data' => $orcamentos->items(),
            'pagination' => [
                'current_page' => $orcamentos->currentPage(),
                'total' => $orcamentos->total(),
                'per_page' => $orcamentos->perPage(),
                'last_page' => $orcamentos->lastPage()
            ]
        ]);
    }

    public function concluidas(Request $request)
    {
        $query = Orcamento::concluidos();
        $query = $this->aplicarFiltros($request, $query);
        $orcamentos = $query->paginate(15)->withQueryString();
        $departamentos = Orcamento::distinct()->pluck('departamento');
        $prioridades = ['Imediata', 'Curto prazo', 'Médio prazo', 'Longo prazo', 'Data específica(evento)'];
        $tipos = ['compra', 'servico'];
        $statusFilterOptions = Orcamento::getFilterStatusOptions();

        return view('solicitacoes.concluidas', compact('orcamentos', 'departamentos', 'prioridades', 'tipos', 'statusFilterOptions'));
    }

    public function create()
    {
        return view('solicitacoes.create');
    }



public function store(Request $request)
{
    // Define as regras básicas de validação
    $rules = [
        'nome' => 'required',
        'departamento' => 'required',
        'descricao' => 'required',
        'prioridade' => 'required',
        'prioridade_data_especifica' => 'nullable|required_if:prioridade,Data específica(evento)',
        'preco' => 'required',
        'tipo' => 'required|in:compra,servico',
        'telefone_contato' => 'nullable'
    ];

    // Adiciona regras específicas baseadas no tipo de orçamento
    if ($request->input('tipo') === 'compra') {
        $rules = array_merge($rules, [
            'link_concorrente_1' => 'required|url',
            'link_concorrente_2' => 'nullable|url',
            'link_concorrente_3' => 'nullable|url',
            'qtde_1' => 'nullable',
            'qtde_2' => 'nullable',
            'qtde_3' => 'nullable',
            'data_compra' => 'nullable',
            'endereco_entrega' => 'nullable'
        ]);
    } elseif ($request->input('tipo') === 'servico') {
        $rules = array_merge($rules, [
            'orcamento_imagem_1' => 'required|image',
            'orcamento_imagem_2' => 'nullable|image',
            'orcamento_imagem_3' => 'nullable|image'
        ]);

        // Adiciona validação para os campos de serviço com base nas imagens enviadas
        for ($i = 1; $i <= 3; $i++) {
            if ($request->hasFile("orcamento_imagem_$i")) {
                $rules["data_servico_$i"] = 'required|date';
                $rules["hora_servico_$i"] = 'required';
                $rules["responsavel_recebimento_$i"] = 'required';
            }
        }
    }

    $validatedData = $request->validate($rules);

    // Processa o upload de imagens e dados dos serviços
    if ($request->input('tipo') === 'servico') {
        for ($i = 1; $i <= 3; $i++) {
            if ($request->hasFile("orcamento_imagem_$i")) {
                $path = $request->file("orcamento_imagem_$i")->store('orcamentos', 'public');
                $validatedData["orcamento_imagem_$i"] = $path;

                // Inclui os dados de serviço relacionados
                $validatedData["data_servico_$i"] = $request->input("data_servico_$i");
                $validatedData["hora_servico_$i"] = $request->input("hora_servico_$i");
                $validatedData["responsavel_recebimento_$i"] = $request->input("responsavel_recebimento_$i");
            }
        }
    }

    // Cria o orçamento
    Orcamento::create($validatedData);

    return redirect()->route('solicitacoes.index')
        ->with('success', 'Solicitação criado com sucesso.');
}

    /**
     * Display the specified resource.
     */
    public function show(Orcamento $solicitaco)
    {
        return view('solicitacoes.show', ['orcamento' => $solicitaco]);
    }

    public function edit(Orcamento $solicitaco)
    {
        $statusComprasOptions = Orcamento::getComprasStatusOptions();
        $statusServicoOptions = Orcamento::getServicoStatusOptions();
        $getPriorityOptions   = Orcamento::getPriorityOptions();
        return view('solicitacoes.edit', [
            'solicitacoes' => $solicitaco,
            'statusComprasOptions' => $statusComprasOptions,
            'statusServicoOptions' => $statusServicoOptions,
            'getPriorityOptions' => $getPriorityOptions
        ]);
    }

    public function update(Request $request, Orcamento $solicitaco)
    {
        // Log para debug
        \Log::info('Update request received', [
            'user_id' => auth()->id(),
            'is_admin' => auth()->check() ? auth()->user()->is_admin : false,
            'request_data' => $request->all()
        ]);

        $validatedData = $request->validate([
            'prioridade' => 'nullable|string',
            'data_compra' => 'nullable|string',
            'status' => 'required|string',
            'status_observacao' => 'nullable|string|required_if:status,Aprovado com alterações'
        ]);

        // Log do status sendo atualizado
        \Log::info('Status being updated', ['status' => $validatedData['status']]);

        // Atualizar apenas os campos que foram enviados
        $updateData = [];

        if ($request->filled('prioridade')) {
            $updateData['prioridade'] = $validatedData['prioridade'];
        }

        if ($request->has('data_compra')) {
            $updateData['data_compra'] = $validatedData['data_compra'];
        }

        if ($request->filled('status')) {
            $updateData['status'] = $validatedData['status'];
        }

        if ($request->has('status_observacao')) {
            $updateData['status_observacao'] = $validatedData['status_observacao'];
        }

        $solicitaco->update($updateData);

        // Verificar se foi finalizada
        if (in_array($validatedData['status'], ['Compra concluída', 'Serviço concluído'])) {
            return redirect()->route('solicitacoes.index')
                ->with('success', 'Solicitação finalizada com sucesso!');
        }

        return redirect()->route('solicitacoes.index')
            ->with('success', 'Status da solicitação atualizado com sucesso.');
    }

    public function finalizar(Request $request, Orcamento $solicitaco)
    {
        \Log::info('Finalizar request received', [
            'user_id' => auth()->id(),
            'is_admin' => auth()->check() ? auth()->user()->is_admin : false,
            'orcamento_id' => $solicitaco->id,
            'current_status' => $solicitaco->status
        ]);

        $status = $solicitaco->tipo === 'compra' ? 'Compra concluída' : 'Serviço concluído';

        $solicitaco->update(['status' => $status]);

        return redirect()->route('solicitacoes.index')
            ->with('success', 'Solicitação finalizada com sucesso!');
    }

    public function destroy(Orcamento $solicitaco)
    {
        $solicitaco->delete();
        return redirect()->route('solicitacoes.index')
            ->with('success', 'Solicitação excluída com sucesso.');
    }
}
