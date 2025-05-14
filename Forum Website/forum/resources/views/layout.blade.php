<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Forum')</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            /* Grayscale color palette */
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;

            /* Main theme colors */
            --primary: #6b7280;
            --primary-hover: #4b5563;
            --dark-bg: #111827;
            --card-bg: #1f2937;
            --text-color: #e5e7eb;
            --text-muted: #9ca3af;
            --border-color: #374151;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #3b82f6;
        }

        body {
            background-image: linear-gradient(rgba(17, 24, 39, 0.9), rgba(17, 24, 39, 0.9)), url('{{ asset("logo/comu-bg.jpg") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            color: var(--text-color);
            font-family: system-ui, -apple-system, sans-serif;
            line-height: 1.5;
        }

        /* Navbar */
        .navbar {
            background-color: var(--card-bg) !important;
            border-bottom: 1px solid var(--border-color);
            padding: 0.75rem 0;
        }

        .navbar-brand {
            color: var(--text-color) !important;
            font-weight: 600;
            transition: opacity 0.2s ease;
        }

        .navbar-brand:hover {
            opacity: 0.9;
        }

        .nav-link {
            color: var(--text-color) !important;
            padding: 0.5rem 0.75rem;
            transition: color 0.2s ease, transform 0.2s ease;
        }

        .nav-link:hover {
            color: var(--gray-300) !important;
            transform: translateY(-1px);
        }

        /* Cards */
        .card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }

        /* Normal kartlar için hover efekti */
        .topic-card.card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* Modal için hover efektini devre dışı bırak */
        .new-topic-modal.card:hover {
            transform: none;
            box-shadow: none;
        }

        .card-header {
            background-color: rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid var(--border-color);
            padding: 0.75rem 1rem;
        }

        /* Modal için özel stiller */
        .new-topic-modal {
            position: fixed !important;
            transform: translate(-50%, -50%) !important;
            transition: none !important;
        }

        .new-topic-modal .card-body {
            position: static !important;
        }

        .new-topic-modal * {
            pointer-events: auto !important;
        }

        .card-body {
            padding: 1rem;
        }

        /* Buttons */
        .btn {
            transition: all 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        .btn-success {
            background-color: var(--success-color);
            border: none;
        }

        .btn-warning {
            background-color: var(--warning-color);
            border: none;
        }

        .btn-danger {
            background-color: var(--danger-color);
            border: none;
        }

        .btn-info {
            background-color: var(--info-color);
            border: none;
        }

        /* Form elements */
        .form-control,
        .form-select {
            background-color: var(--dark-bg);
            border: 1px solid var(--border-color);
            color: var(--text-color);
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .form-control:focus,
        .form-select:focus {
            background-color: var(--dark-bg);
            border-color: var(--gray-500);
            box-shadow: 0 0 0 0.2rem rgba(107, 114, 128, 0.25);
            color: var(--text-color);
        }

        /* Dropdown */
        .dropdown-menu {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            animation: fadeIn 0.2s ease;
        }

        .dropdown-item {
            color: var(--text-color);
            transition: background-color 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: var(--gray-700);
            color: var(--text-color);
        }

        /* Footer */
        footer {
            background-color: var(--card-bg);
            border-top: 1px solid var(--border-color);
            color: var(--text-muted);
            padding: 1rem 0;
            margin-top: 2rem;
        }

        /* Badges */
        .badge {
            font-weight: 500;
            transition: background-color 0.2s ease;
        }

        .bg-primary {
            background-color: var(--primary) !important;
        }

        /* Utilities */
        .text-muted {
            color: var(--text-muted) !important;
        }

        /* Close button for alerts */
        .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        /* Alert animations */
        .alert {
            animation: slideDown 0.3s ease;
        }

        /* Topic cards */
        .topic-card {
            transition: transform 0.2s ease, border-left 0.2s ease;
            border-left: 3px solid transparent;
        }

        .topic-card:hover {
            transform: translateX(3px);
            border-left: 3px solid var(--primary);
        }

        /* Simple animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Pagination */
        .pagination {
            --bs-pagination-bg: var(--card-bg);
            --bs-pagination-border-color: var(--border-color);
            --bs-pagination-color: var(--text-color);
            --bs-pagination-hover-bg: var(--gray-700);
            --bs-pagination-hover-color: var(--text-color);
            --bs-pagination-active-bg: var(--primary);
            --bs-pagination-active-border-color: var(--primary);
        }

        /* Tabs */
        .nav-tabs {
            border-bottom: 1px solid var(--border-color);
        }

        .nav-tabs .nav-link {
            color: var(--text-color);
            border: none;
            padding: 0.5rem 1rem;
            transition: all 0.2s ease;
        }

        .nav-tabs .nav-link.active {
            color: var(--text-color);
            background-color: transparent;
            border-bottom: 2px solid var(--primary);
        }

        .nav-tabs .nav-link:hover {
            color: var(--gray-300);
        }
    </style>
    @stack('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/">
                Forum
            </a> <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/"><i class="fas fa-home me-1"></i> Ana Sayfa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/topics"><i class="fas fa-newspaper me-1"></i> Konular</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact"><i class="fas fa-envelope me-1"></i> İletişim</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    @auth
                    <li class="nav-item dropdown me-2">
                        <a class="nav-link dropdown-toggle position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            @php
                                $unreadCount = Auth::user()->unreadNotifications()->count();
                            @endphp
                            @if($unreadCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown" style="width: 300px; max-height: 400px; overflow-y: auto;">
                            @php
                                $notifications = DB::table('notifications')
                                    ->where('notifiable_type', 'App\Models\User')
                                    ->where('notifiable_id', Auth::id())
                                    ->orderBy('created_at', 'desc')
                                    ->take(10)
                                    ->get()
                                    ->map(function($notification) {
                                        $notification->created_at = \Carbon\Carbon::parse($notification->created_at);
                                        $notification->data = json_decode($notification->data, true);
                                        return $notification;
                                    });
                            @endphp
                            @forelse($notifications as $notification)
                                <li>
                                    <a class="dropdown-item notification-item {{ $notification->read_at ? 'text-muted' : '' }}" 
                                       href="#" 
                                       data-notification-id="{{ $notification->id }}"
                                       onclick="markAsRead('{{ $notification->id }}')">
                                        <small class="float-end text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                        <p class="mb-0">{{ $notification->data['message'] }}</p>
                                    </a>
                                </li>
                                @if(!$loop->last)
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                            @empty
                                <li><a class="dropdown-item">Bildirim bulunmamaktadır.</a></li>
                            @endforelse
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-1"></i> {{ Auth::user()->username }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="/profile/{{ Auth::user()->id }}">
                                    <i class="fas fa-user me-2"></i> Profil
                                </a>
                            </li>
                            @if(Auth::user()->is_admin)
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                    <a href="/panel" class="dropdown-item">
                                        <i class="fas fa-cogs me-2"></i> Yönetim Paneli
                                    </a>
                            @endif
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="/logout" method="POST" class="d-inline">
                                    @csrf
                                    <button class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i> Çıkış Yap
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="/auth"><i class="fas fa-sign-in-alt me-1"></i> Giriş Yap</a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show container" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show container" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <main class="container">
        @yield('content')
    </main>

    <footer class="text-center">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Forum. Tüm hakları saklıdır.</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Add active class to current nav item
            const currentLocation = location.pathname;
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentLocation) {
                    link.classList.add('active');
                    link.setAttribute('aria-current', 'page');
                }
            });
        });

        function markAsRead(notificationId) {
            axios.post(`/notifications/${notificationId}/mark-as-read`, {
                _token: '{{ csrf_token() }}'
            })
            .then(response => {
                if (response.data.success) {
                    const notificationItem = document.querySelector(`[data-notification-id="${notificationId}"]`);
                    if (notificationItem) {
                        notificationItem.classList.add('text-muted');
                    }
                    
                    updateNotificationBadge();
                }
            })
            .catch(error => console.error('Error marking notification as read:', error));
        }

        function updateNotificationBadge() {
            const badge = document.querySelector('#notificationDropdown .badge');
            if (badge) {
                const currentCount = parseInt(badge.textContent);
                if (currentCount <= 1) {
                    badge.remove();
                } else {
                    badge.textContent = currentCount - 1;
                }
            }
        }
    </script>
    @stack('scripts')
</body>

</html>