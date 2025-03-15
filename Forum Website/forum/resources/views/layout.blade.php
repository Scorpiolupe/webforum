<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Forum')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #6B46C1;
            --dark-bg: #1a1a2e;
            --secondary-bg: #242438;
            --text-color: #e4e4e4;
            --light-bg: #f8f9fa;
            --dark-text:rgb(224, 224, 224);
        }

        body {
            background-color: var(--dark-bg);
            color: var(--text-color);
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            background-color: var(--secondary-bg) !important;
            border-bottom: 2px solid var(--primary-color);
        }

        .navbar-brand {
            color: var(--primary-color) !important;
            font-weight: bold;
        }

        .nav-link {
            color: var(--text-color) !important;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .card {
            background-color: var(--dark-bg);
            border: 1px solid var(--primary-color);
            color: var(--dark-text);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
        }

        .btn-primary:hover {
            background-color: #553C9A;
        }

        footer {
            background-color: var(--secondary-bg);
            border-top: 2px solid var(--primary-color);
            padding: 1rem 0;
            margin-top: 2rem;
        }

        .text-light {
            color: var(--dark-text) !important;
        }

        .bg-primary {
            background-color: var(--primary-color) !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4" style="padding: 1rem 0;">
        <div class="container">
            <a class="navbar-brand" href="/" style="font-size: 2rem;"><i class="fas fa-comments fa-lg"></i> Forum</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/"><i class="fas fa-home"></i> Ana Sayfa</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-list"></i> Kategoriler
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown" style="background-color: var(--secondary-bg);">
                            <div class="card-body">
                                @if(isset($categories) && count($categories) > 0)
                                    @foreach($categories as $category)
                                        <div class="mb-2">
                                            <a href="/categories/{{ $category->id }}" class="text-decoration-none text-light">
                                                <i class="fas fa-folder"></i> {{ $category->name }}
                                            </a>
                                            <span class="badge bg-primary float-end">{{ $category->topics_count ?? 0 }}</span>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-center mb-0" style="color: red;">Henüz kategori bulunmamaktadır.</p>
                                @endif
                            </div>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/topics"><i class="fas fa-newspaper"></i> Konular</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact"><i class="fas fa-envelope"></i> İletişim</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="/profile"><i class="fas fa-user"></i> Profil</a>
                        </li>
                        <li class="nav-item">
                            <form action="/logout" method="POST" class="d-inline">
                                @csrf
                                <button class="nav-link btn btn-link"><i class="fas fa-sign-out-alt"></i> Çıkış Yap</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="/auth"><i class="fas fa-sign-in-alt"></i> Giriş Yap</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/auth"><i class="fas fa-user-plus"></i> Kayıt Ol</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>

    <footer class="text-center">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Forum. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>