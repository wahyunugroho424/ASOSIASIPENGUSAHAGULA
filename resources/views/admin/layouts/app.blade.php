<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - APGI</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        /* ─── Reset & Base ─── */
        *, *::before, *::after { box-sizing: border-box; }

        html, body {
            height: 100%;
            margin: 0;
            overflow: hidden; /* prevent body scroll — sidebar + main handle their own */
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: #f0f4f8;
        }

        /* ─── Shell: full-viewport two-column layout ─── */
        .app-shell {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* ─── Sidebar ─── */
        .sidebar {
            width: 220px;
            min-width: 220px;
            height: 100vh;
            background: linear-gradient(180deg, #1f8c45 0%, #17a36e 100%);
            display: flex;
            flex-direction: column;
            overflow: hidden;              /* sidebar itself never scrolls */
            flex-shrink: 0;
            position: relative;
            z-index: 100;
            box-shadow: 4px 0 20px rgba(0,0,0,0.12);
        }

        .sidebar-brand {
            padding: 28px 20px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.12);
            flex-shrink: 0;
        }
        .sidebar-brand h4 {
            color: #fff;
            font-weight: 700;
            font-size: 1.1rem;
            margin: 0 0 2px;
            letter-spacing: 0.3px;
        }
        .sidebar-brand small {
            color: rgba(255,255,255,0.55);
            font-size: 0.72rem;
        }

        /* Nav area — scrolls ONLY if nav items overflow */
        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 12px 0 16px;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.2) transparent;
        }
        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 2px; }

        .nav-group-label {
            font-size: 0.67rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.45);
            padding: 14px 20px 6px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px 9px 20px;
            margin: 1px 10px;
            border-radius: 9px;
            color: rgba(255,255,255,0.85);
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.18s, color 0.18s;
        }
        .sidebar-link i { font-size: 15px; flex-shrink: 0; }
        .sidebar-link:hover {
            background: rgba(255,255,255,0.15);
            color: #fff;
        }
        .sidebar-link.active {
            background: rgba(255,255,255,0.22);
            color: #fff;
            font-weight: 600;
        }

        /* Logout pinned to bottom */
        .sidebar-footer {
            padding: 14px 16px;
            border-top: 1px solid rgba(255,255,255,0.12);
            flex-shrink: 0;
        }
        .sidebar-footer form button {
            width: 100%;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.25);
            color: rgba(255,255,255,0.85);
            border-radius: 9px;
            padding: 8px 12px;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: background 0.18s, color 0.18s;
        }
        .sidebar-footer form button:hover {
            background: rgba(255,255,255,0.22);
            color: #fff;
        }

        /* ─── Main area ─── */
        .main-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            min-width: 0;
        }

        /* Top navbar — fixed inside main, never scrolls away */
        .topbar {
            height: 60px;
            background: #fff;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            flex-shrink: 0;
            box-shadow: 0 1px 8px rgba(0,0,0,0.06);
            z-index: 50;
        }
        .topbar-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #1a1a2e;
            margin: 0;
        }
        .topbar-right { display: flex; align-items: center; gap: 10px; }

        .user-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px 6px 8px;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 50px;
            cursor: pointer;
            transition: background 0.15s, border-color 0.15s;
            font-size: 0.85rem;
            font-weight: 500;
            color: #343a40;
        }
        .user-btn:hover { background: #eaf6ed; border-color: #b7dfc3; }
        .user-avatar {
            width: 30px; height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, #28a745, #20c997);
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            flex-shrink: 0;
        }

        /* ─── Scrollable page content ─── */
        .page-content {
            flex: 1;
            overflow-y: auto;      /* ONLY this area scrolls */
            overflow-x: hidden;
            padding: 28px 28px 40px;
            scrollbar-width: thin;
            scrollbar-color: #c8d6e5 transparent;
        }
        .page-content::-webkit-scrollbar { width: 6px; }
        .page-content::-webkit-scrollbar-thumb { background: #c8d6e5; border-radius: 3px; }

        /* ─── Alert tweaks ─── */
        .alert { border: none; border-radius: 10px; font-size: 0.88rem; }

        /* ─── Dropdown override ─── */
        .dropdown-menu { border-radius: 10px; border: 1px solid #e9ecef; box-shadow: 0 6px 24px rgba(0,0,0,0.1); font-size: 0.875rem; }
        .dropdown-item { padding: 8px 16px; border-radius: 6px; margin: 1px 4px; }
        .dropdown-item:hover { background: #eaf6ed; color: #1a1a2e; }
        .dropdown-divider { margin: 4px 0; }

        /* ─── Responsive ─── */
        @media (max-width: 768px) {
            .sidebar { width: 200px; min-width: 200px; }
            .page-content { padding: 20px 16px 32px; }
            .topbar { padding: 0 16px; }
        }
    </style>

    @stack('styles')
</head>
<body>

<div class="app-shell">

    {{-- ════════ SIDEBAR ════════ --}}
    <nav class="sidebar">

        <div class="sidebar-brand">
            <h4>APGI Admin</h4>
            <small>Panel Administrasi</small>
        </div>

        <div class="sidebar-nav">

            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <div class="nav-group-label">Kegiatan</div>

            <a href="{{ route('admin.galleries.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.galleries*') ? 'active' : '' }}">
                <i class="bi bi-images"></i> Galeri
            </a>

            <a href="{{ route('admin.events.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.events*') ? 'active' : '' }}">
                <i class="bi bi-calendar-event"></i> Event
            </a>

            <a href="{{ route('admin.social-contents.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.social-contents*') ? 'active' : '' }}">
                <i class="bi bi-chat-square-text"></i> Konten Sosial
            </a>

            <div class="nav-group-label">News</div>

            <a href="{{ route('admin.news.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.news*') ? 'active' : '' }}">
                <i class="bi bi-newspaper"></i> News
            </a>
<!-- 
            <div class="nav-group-label">Organisasi</div>

            <a href="{{ route('admin.member.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.member*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> Anggota APGI
            </a>

            <a href="{{ route('admin.structure.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.structure*') ? 'active' : '' }}">
                <i class="bi bi-diagram-3-fill"></i> Struktur Organisasi
            </a> -->

        </div>

        {{-- Logout pinned to bottom --}}
        <div class="sidebar-footer">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>

    </nav>

    {{-- ════════ MAIN AREA ════════ --}}
    <div class="main-area">

        {{-- Top Bar --}}
        <header class="topbar">
            <h1 class="topbar-title">@yield('title', 'Dashboard')</h1>

            <div class="topbar-right">
                <div class="dropdown">
                    <button class="user-btn dropdown-toggle border-0" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::guard('admin')->user()->name, 0, 1)) }}
                        </div>
                        {{ Auth::guard('admin')->user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <span class="dropdown-item-text text-muted" style="font-size:0.78rem; padding: 6px 16px;">
                                {{ Auth::guard('admin')->user()->role }}
                            </span>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                <i class="bi bi-person me-2"></i> Profil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.change-password') }}">
                                <i class="bi bi-key me-2"></i> Ganti Password
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        {{-- Scrollable Page Content --}}
        <main class="page-content">

            {{-- Flash Alerts --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
                    <strong><i class="bi bi-exclamation-triangle-fill me-2"></i>Terdapat kesalahan:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')

        </main>

    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>