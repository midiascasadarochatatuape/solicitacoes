<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistema de Solicitações</title>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/styles.css')}}" rel="stylesheet">
    <link rel="icon" href="{{ asset('assets/img/favicon.webp') }}" type="image/x-icon">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('assets/img/logo-horizontal-branco.svg') }}" width="130" alt="" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link link-white" href="/">Nova Solicitação</a>
                    </li>

                    @guest
                        <li class="nav-item">
                            <a class="nav-link link-white" href="/solicitacoes">Solicitações</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link-white" href="/solicitacoes/concluidas">Solicitações Concluídas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link-white" href="{{ route('login') }}">Área Administrativa</a>
                        </li>
                    @else

                        <li class="nav-item">
                            <a class="nav-link link-white" href="{{ route('admin.solicitacoes.index') }}">Gerenciar Solicitações</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link-white" href="/solicitacoes/concluidas">Solicitações Concluídas</a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link">Sair</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        @yield('content')
    </main>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
