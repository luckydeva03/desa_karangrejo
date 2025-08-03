<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Admin') - Desa Karangrejo</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Mobile-First Admin Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin-responsive.css') }}">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    
    <!-- Summernote, jQuery, Bootstrap, and CodeMirror for codeview -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/theme/monokai.min.css">
    
    <!-- CSRF Fix Script untuk cPanel Hosting -->
    <script src="{{ asset('js/admin-csrf-fix.js') }}"></script>
    
    <style>
        :root {
            --sidebar-width: 280px;
            --primary-color: #2563eb;
            --sidebar-bg: #1e293b;
            --sidebar-text: #94a3b8;
            --sidebar-active: #2563eb;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #f8fafc;
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            transition: all 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
        }
        
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #334155;
        }
        
        .sidebar-brand {
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.25rem;
        }
        
        .sidebar-nav {
            padding: 1rem 0;
        }
        
        .nav-item {
            margin: 0.25rem 1rem;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--sidebar-text);
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            position: relative;
        }
        
        .nav-link:hover,
        .nav-link.active {
            color: white;
            background-color: var(--sidebar-active);
        }
        
        .nav-link i {
            width: 20px;
            margin-right: 0.75rem;
            text-align: center;
        }
        
        /* Nav Section Styles */
        .nav-section {
            margin: 0.25rem 1rem;
        }
        
        .nav-section-header {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--sidebar-text);
            background-color: transparent;
            border: none;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            cursor: pointer;
            width: 100%;
            font-size: 1rem;
            text-align: left;
        }
        
        .nav-section-header:hover {
            color: white;
            background-color: rgba(37, 99, 235, 0.3);
        }
        
        .nav-section-arrow {
            margin-left: auto;
            font-size: 0.8rem;
            transition: transform 0.3s ease;
        }
        
        .nav-section.open .nav-section-arrow {
            transform: rotate(180deg);
        }
        
        .nav-section-content {
            background-color: rgba(51, 65, 85, 0.3);
            border-radius: 0.5rem;
            margin: 0.25rem 0 0.5rem 0;
            padding: 0.25rem 0;
            display: none;
            overflow: hidden;
            border-left: 3px solid rgba(37, 99, 235, 0.5);
        }
        
        .nav-section.open .nav-section-content {
            display: block;
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                max-height: 0;
                padding: 0;
            }
            to {
                opacity: 1;
                max-height: 500px;
                padding: 0.25rem 0;
            }
        }
        
        .nav-link.sub-menu {
            margin: 0.125rem 0.5rem;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            background-color: transparent;
        }
        
        .nav-link.sub-menu:hover {
            background-color: rgba(37, 99, 235, 0.4);
        }
        
        .nav-link.sub-menu.active {
            background-color: var(--sidebar-active);
            color: white;
        }
        
        .nav-link.sub-menu i {
            width: 16px;
            margin-right: 0.5rem;
            font-size: 0.8rem;
        }
        
        /* Dropdown styles for sidebar */
        .sidebar .has-dropdown .dropdown-arrow {
            margin-left: auto;
            font-size: 0.8rem;
            transition: transform 0.3s ease;
        }
        
        .sidebar .has-dropdown.open .dropdown-arrow {
            transform: rotate(180deg);
        }
        
        .sidebar .dropdown-submenu {
            background-color: #334155;
            border-radius: 0.5rem;
            margin: 0.25rem 1rem 0.5rem 1rem;
            padding: 0.5rem 0;
            display: none;
            overflow: hidden;
            width: calc(100% - 2rem); /* Sama dengan lebar nav-item */
        }
        
        .sidebar .has-dropdown.open .dropdown-submenu {
            display: block;
        }
        
        .sidebar .dropdown-item {
            color: var(--sidebar-text);
            padding: 0.75rem 1rem; /* Sama dengan padding nav-link */
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
            border-radius: 0.375rem;
            margin: 0.125rem 0.5rem; /* Margin konsisten */
        }
        
        .sidebar .dropdown-item:hover,
        .sidebar .dropdown-item.active {
            color: white;
            background-color: var(--sidebar-active);
        }
        
        .sidebar .dropdown-item i {
            width: 20px; /* Sama dengan width icon nav-link */
            margin-right: 0.75rem; /* Sama dengan margin nav-link */
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s ease;
        }
        
        .top-navbar {
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .content-wrapper {
            padding: 0 1.5rem 1.5rem;
        }
        
        .page-title {
            margin-bottom: 1.5rem;
        }
        
        .stats-card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: all 0.2s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .sidebar-toggle {
            display: none;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .sidebar-toggle {
                display: block;
            }
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            color: #374151;
        }
        
        .badge {
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .btn {
            border-radius: 0.5rem;
            font-weight: 500;
        }
        
        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .card-header {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            border-radius: 0.75rem 0.75rem 0 0 !important;
            padding: 1rem 1.5rem;
        }
        
        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
        }
    </style>
    
    @stack('styles')
</head>
<body class="admin-layout">
    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Sidebar -->
    <aside class="sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                <i class="fas fa-tachometer-alt me-2"></i>
                Panel Admin
            </a>
        </div>
        
        <nav class="sidebar-nav">
            <div class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </div>
            
            <!-- Menu Berita -->
            <div class="nav-item">
                <a href="{{ route('admin.posts.index') }}" class="nav-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper"></i>
                    Kelola Berita
                </a>
            </div>
            
            <div class="nav-item">
                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i>
                    Kategori
                </a>
            </div>
            
            <!-- Section Halaman -->
            <div class="nav-section">
                <div class="nav-section-header">
                    <i class="fas fa-file-alt me-2"></i>
                    <span>Halaman</span>
                    <i class="fas fa-chevron-down nav-section-arrow"></i>
                </div>
                <div class="nav-section-content">
                    @php
                        $pages = \App\Models\Page::all();
                        $pageRoutes = [
                            'profil-desa' => ['label' => 'Profil Desa', 'icon' => 'fas fa-building'],
                            'sejarah-desa' => ['label' => 'Sejarah Desa', 'icon' => 'fas fa-history'],
                            'visi-misi' => ['label' => 'Visi & Misi', 'icon' => 'fas fa-eye'],
                            'struktur-organisasi' => ['label' => 'Struktur Organisasi', 'icon' => 'fas fa-sitemap']
                        ];
                    @endphp
                    
                    @foreach($pageRoutes as $slug => $pageInfo)
                        @php
                            $page = $pages->where('slug', $slug)->first();
                        @endphp
                        @if($page)
                            <div class="nav-item">
                                <a href="{{ route('admin.pages.edit', $page->slug) }}" class="nav-link sub-menu {{ request()->routeIs('admin.pages.edit') && request()->route('page')->slug === $slug ? 'active' : '' }}">
                                    <i class="{{ $pageInfo['icon'] }}"></i>
                                    {{ $pageInfo['label'] }}
                                </a>
                            </div>
                        @endif
                    @endforeach
                    
                    <div class="nav-item">
                        <a href="{{ route('admin.pages.index') }}" class="nav-link sub-menu {{ request()->routeIs('admin.pages.index') ? 'active' : '' }}">
                            <i class="fas fa-list"></i>
                            Kelola Semua Halaman
                        </a>
                    </div>
                    
                    <div class="nav-item">
                        <a href="{{ route('admin.pages.create') }}" class="nav-link sub-menu {{ request()->routeIs('admin.pages.create') ? 'active' : '' }}">
                            <i class="fas fa-plus"></i>
                            Tambah Halaman Baru
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="nav-item">
                <a href="{{ route('admin.galleries.index') }}" class="nav-link {{ request()->routeIs('admin.galleries.*') ? 'active' : '' }}">
                    <i class="fas fa-images"></i>
                    Galeri
                </a>
            </div>
            
            <div class="nav-item">
                <a href="{{ route('admin.village-data.index') }}" class="nav-link {{ request()->routeIs('admin.village-data.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i>
                    Data Desa
                </a>
            </div>
            
            <div class="nav-item">
                <a href="{{ route('admin.announcements.index') }}" class="nav-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
                    <i class="fas fa-bullhorn"></i>
                    Pengumuman
                </a>
            </div>
            
            <div class="nav-item">
                <a href="{{ route('admin.messages.index') }}" class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i>
                    Pesan Kontak
                </a>
            </div>
            
            <div class="nav-item">
                <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i>
                    Pengaturan
                </a>
            </div>
            
            @if(auth()->user()->isAdmin())
            <hr class="mx-3 my-3 border-secondary">
            
            <div class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    Kelola User
                </a>
            </div>
            @endif
        </nav>
    </aside>
    
    <!-- Main Content Area -->
    <div class="main-content">
        <!-- Top Navigation Bar -->
        <header class="top-navbar">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-outline-primary sidebar-toggle me-3" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="h4 mb-0">@yield('page-title', 'Dashboard')</h1>
                </div>
                
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-secondary d-none d-sm-flex align-items-center">
                        <i class="fas fa-external-link-alt me-2"></i>
                        <span class="d-none d-md-inline">Lihat Website</span>
                    </a>
                    
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle d-flex align-items-center p-0" data-bs-toggle="dropdown">
                            <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="rounded-circle me-2" style="width: 32px; height: 32px;">
                            <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                    @csrf
                                    <button type="submit" class="dropdown-item" onclick="return confirmLogout()">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Main Content -->
        <div class="content-wrapper">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/xml/xml.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- Mobile-First Admin JavaScript -->
    <script src="{{ asset('js/admin-mobile.js') }}"></script>
    
    <script>
        // Global CSRF Setup
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        };

        // jQuery CSRF Setup
        if (window.$) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': window.Laravel.csrfToken
                }
            });
        }
        
        // Nav Section Toggle Handler
        document.addEventListener('DOMContentLoaded', function() {
            // Handle nav section toggle
            const navSectionHeaders = document.querySelectorAll('.nav-section-header');
            
            navSectionHeaders.forEach(header => {
                header.addEventListener('click', function() {
                    const navSection = this.closest('.nav-section');
                    const isOpen = navSection.classList.contains('open');
                    
                    // Close all other nav sections first
                    document.querySelectorAll('.nav-section').forEach(section => {
                        if (section !== navSection) {
                            section.classList.remove('open');
                        }
                    });
                    
                    // Toggle current section
                    if (!isOpen) {
                        navSection.classList.add('open');
                    } else {
                        navSection.classList.remove('open');
                    }
                });
            });
            
            // Auto-open nav section if current page matches any sub-menu
            const currentPath = window.location.pathname;
            const navSections = document.querySelectorAll('.nav-section');
            
            navSections.forEach(section => {
                const subMenus = section.querySelectorAll('.nav-link.sub-menu');
                let shouldOpen = false;
                
                subMenus.forEach(link => {
                    const linkHref = link.getAttribute('href');
                    if (link.classList.contains('active') || 
                        currentPath === linkHref ||
                        (linkHref && currentPath.includes(linkHref.split('/').pop()))) {
                        shouldOpen = true;
                        link.classList.add('active');
                    }
                });
                
                if (shouldOpen) {
                    section.classList.add('open');
                }
            });
        });
        
        // Logout confirmation and CSRF refresh
        function confirmLogout() {
            // Refresh CSRF token before logout
            const form = document.getElementById('logout-form');
            const tokenInput = form.querySelector('input[name="_token"]');
            if (tokenInput) {
                tokenInput.value = window.Laravel.csrfToken;
            }
            
            return confirm('Apakah Anda yakin ingin logout?');
        }
        
        // Auto-refresh CSRF token every 30 minutes
        setInterval(function() {
            fetch('/admin/dashboard', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (response.headers.get('X-CSRF-TOKEN')) {
                    const newToken = response.headers.get('X-CSRF-TOKEN');
                    window.Laravel.csrfToken = newToken;
                    
                    // Update all CSRF tokens in forms
                    document.querySelectorAll('input[name="_token"]').forEach(input => {
                        input.value = newToken;
                    });
                    
                    // Update meta tag
                    const metaTag = document.querySelector('meta[name="csrf-token"]');
                    if (metaTag) {
                        metaTag.setAttribute('content', newToken);
                    }
                }
            })
            .catch(error => {
                console.log('CSRF token refresh failed:', error);
            });
        }, 30 * 60 * 1000); // 30 minutes
        
        // Initialize DataTables with Mobile Responsive
        $(document).ready(function() {
            if ($.fn.dataTable) {
                $('.data-table').DataTable({
                    responsive: {
                        details: {
                            type: 'column',
                            target: 'tr'
                        }
                    },
                    columnDefs: [{
                        className: 'dtr-control',
                        orderable: false,
                        targets: 0
                    }],
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
                    },
                    pageLength: 25,
                    lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                         '<"row"<"col-sm-12"tr>>' +
                         '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
                });
            }
        });
        
        // Auto-dismiss alerts
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000);
    </script>
    
    @stack('scripts')
</body>
</html>