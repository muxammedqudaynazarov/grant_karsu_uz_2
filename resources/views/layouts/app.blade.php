<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="adminHMD professional admin dashboard template">
    <title>Grant.KarSU.UZ</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        #toast-container {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1055;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .toast-message {
            min-width: 300px;
            max-width: 400px;
            padding: 16px 20px;
            border-radius: 12px;
            color: #fff;
            font-weight: 500;
            font-size: 0.95rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideInRight 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            word-wrap: break-word;
        }

        .toast-success {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .toast-error {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        .toast-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        @keyframes slideInRight {
            from {
                transform: translateX(120%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(120%);
                opacity: 0;
            }
        }
    </style>
    @yield('style')
</head>
<body>
@php
    use App\Models\User;
@endphp
<div class="admin-shell">
    <div class="sidebar-backdrop" data-sidebar-close></div>
    <aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
        <div class="sidebar-header">
            <a class="brand-mark" href="{{ route('home') }}" aria-label="adminHMD dashboard">
                <span class="brand-icon"><i class="bi bi-grid-1x2-fill" aria-hidden="true"></i></span>
                <span class="brand-copy">
            <span class="brand-title">Grant.KarSU.uz</span>
            <span class="brand-subtitle">Kutubxonlik mezoni</span>
          </span>
            </a>
        </div>

        <nav class="sidebar-nav">
            <a class="nav-link @if(Request::is('home')) active @endif" href="{{ url('/home') }}">
                <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
                <span class="nav-text">{{ __('main.Home page') }}</span>
            </a>
            <a class="nav-link @if(Request::is('home/tests*')) active @endif" href="{{ route('tests.index') }}">
                <span class="nav-icon"><i class="bi bi-ui-checks-grid" aria-hidden="true"></i></span>
                <span class="nav-text">{{ __('main.Test') }}</span>
            </a>
        </nav>
        <div class="sidebar-footer">
            <span class="status-dot"></span>
            <span class="sidebar-footer-text">ON: {{ User::all()->count() }} / {{ User::all()->count() }}</span>
        </div>
    </aside>

    <div class="admin-main">
        <nav class="navbar admin-navbar navbar-expand bg-white">
            <div class="container-fluid px-3 px-lg-4">
                <button class="sidebar-toggle" type="button" data-sidebar-toggle aria-controls="adminSidebar"
                        aria-expanded="true" aria-label="Toggle sidebar">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <div class="navbar-actions ms-auto d-flex align-items-center gap-2">
                    <button class="icon-button theme-toggle" type="button" data-theme-toggle
                            aria-label="Switch color theme" title="Tungi/Kunduzgi rejim">
                        <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
                    </button>

                    <div class="dropdown">
                        <button class="icon-button border" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                                title="Tilni tanlash" style="border: none; background: transparent; transition: 0.2s;">
                            <i class="bi bi-globe fs-5 text-secondary hover-primary" aria-hidden="true"></i>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-4 mt-2 p-2"
                            style="min-width: 180px;">
                            <li>
                                <a class="dropdown-item rounded-2 mb-1 py-2 px-3 d-flex justify-content-between align-items-center transition-all {{ app()->getLocale() == 'uz' ? 'bg-light text-primary' : 'text-secondary' }}"
                                   href="{{ route('lang', 'uz') }}">
                                    <div>
                                        <span class="fw-bold border-end pe-2 me-1">UZ</span>
                                        <span class="small fw-medium">O‘zbekcha</span>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item rounded-2 mb-1 py-2 px-3 d-flex justify-content-between align-items-center transition-all {{ app()->getLocale() == 'kaa' ? 'bg-light text-primary' : 'text-secondary' }}"
                                   href="{{ route('lang', 'kaa') }}">
                                    <div>
                                        <span class="fw-bold border-end pe-2 me-1">QR</span>
                                        <span class="small fw-medium">Qaraqalpoqsha</span>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item rounded-2 py-2 px-3 d-flex justify-content-between align-items-center transition-all {{ app()->getLocale() == 'ru' ? 'bg-light text-primary' : 'text-secondary' }}"
                                   href="{{ route('lang', 'ru') }}">
                                    <div>
                                        <span class="fw-bold border-end pe-2 me-1">RU</span>
                                        <span class="small fw-medium">Русский</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="dropdown">
                        <button class="profile-button border bg-transparent"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img class="avatar-img avatar-sm rounded-circle"
                                 src="{!! auth()->user()->data['image'] ?? asset('images/default-avatar.png') !!}"
                                 alt="Avatar">
                            <span class="profile-name d-none d-sm-inline ms-2">{{ auth()->user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2">
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}">
                                    {{ __('main.Exit') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <main class="dashboard-content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </main>
    </div>
</div>

<div id="toast-container"></div>

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

<script>
    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = `toast-message toast-${type}`;
        let iconClass = 'bi-info-circle-fill';
        if (type === 'success') iconClass = 'bi-check-circle-fill';
        if (type === 'error') iconClass = 'bi-exclamation-triangle-fill';
        if (type === 'warning') iconClass = 'bi-exclamation-circle-fill';
        const icon = document.createElement('i');
        icon.className = `bi ${iconClass} fs-5`;
        toast.appendChild(icon);
        const text = document.createElement('span');
        text.textContent = message;
        toast.appendChild(text);
        container.appendChild(toast);
        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards';
            setTimeout(() => toast.remove(), 400);
        }, 5000);
    }

    @if (session('success'))
    showToast("{!! addslashes(session('success')) !!}", 'success');
    @endif
    @if (session('error'))
    showToast("{!! addslashes(session('error')) !!}", 'error');
    @endif
    @if (session('warning'))
    showToast("{!! addslashes(session('warning')) !!}", 'warning');
    @endif
    @if ($errors->any())
    @foreach ($errors->all() as $error)
    showToast("{!! addslashes($error) !!}", 'error');
    @endforeach
    @endif
</script>

@yield('script')
<style>
    /* Tranzitsiya (Silliq ochilishi uchun) */
    .admin-sidebar, .admin-main {
        transition: all 0.3s ease-in-out !important;
    }

    /* MOBIL EKRANLAR UCHUN (Telefonda chapdan chiqib keladi) */
    @media (max-width: 991.98px) {
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1040;
            transform: translateX(-100%); /* Boshlang'ich holatda yashirin */
        }

        /* JS orqali 'sidebar-open' klassi qo'shilganda: */
        .admin-shell.sidebar-open .admin-sidebar {
            transform: translateX(0); /* Ekranga chiqish */
        }

        /* Qora fon (Backdrop) */
        .sidebar-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1030;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease-in-out;
        }

        .admin-shell.sidebar-open .sidebar-backdrop {
            opacity: 1;
            visibility: visible;
        }
    }

    /* KATTA EKRANLAR UCHUN (Kompyuterda sidebar ni yopish/ochish) */
    @media (min-width: 992px) {
        /* JS orqali 'sidebar-collapsed' klassi qo'shilganda: */
        .admin-shell.sidebar-collapsed .admin-sidebar {
            margin-left: -260px; /* Sidebar eniga qarab o'zgartirishingiz mumkin (masalan -250px) */
        }

        .admin-shell.sidebar-collapsed .admin-main {
            margin-left: 0 !important; /* Asosiy qismni to'liq ekranga yoyish */
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.querySelector('.sidebar-toggle');
        const adminShell = document.querySelector('.admin-shell');
        const backdrop = document.querySelector('.sidebar-backdrop');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation(); // Boshqa JS fayllardagi xatoliklarni to'xtatadi

                // Ekran o'lchamini tekshiramiz
                if (window.innerWidth < 992) {
                    // Mobil uchun
                    adminShell.classList.toggle('sidebar-open');
                } else {
                    // Kompyuter uchun
                    adminShell.classList.toggle('sidebar-collapsed');
                }
            });
        }

        // Qora fon bosilganda (Faqat mobilda)
        if (backdrop) {
            backdrop.addEventListener('click', function () {
                adminShell.classList.remove('sidebar-open');
            });
        }
    });
</script>
</body>
</html>
