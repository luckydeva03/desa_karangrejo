<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container align-items-center">
        <a class="navbar-brand d-flex align-items-center gap-2 py-0" href="{{ route('home') }}" style="min-width:220px;">
            <img src="{{ asset('images/logo_desa.png') }}" alt="Logo Desa Karangrejo" style="height:38px;width:auto;object-fit:contain;" onerror="this.onerror=null;this.src='https://via.placeholder.com/38x38?text=Logo';">
            <span class="fw-bold text-primary fs-5 mb-0">Desa Karangrejo</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-3 me-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="fas fa-home me-1"></i>Beranda
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="fas fa-info-circle me-1"></i>Profil Desa
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('profile') }}">Profil Desa</a></li>
                        <li><a class="dropdown-item" href="{{ route('history') }}">Sejarah</a></li>
                        <li><a class="dropdown-item" href="{{ route('vision-mission') }}">Visi & Misi</a></li>
                        <li><a class="dropdown-item" href="{{ route('organization') }}">Struktur Organisasi</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('posts.*') ? 'active' : '' }}" href="{{ route('posts.index') }}">
                        <i class="fas fa-newspaper me-1"></i>Berita
                    </a>
                </li>
                <!-- Fitur Layanan dihapus -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('galleries.*') ? 'active' : '' }}" href="{{ route('galleries.index') }}">
                        <i class="fas fa-images me-1"></i>Galeri
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact.*') ? 'active' : '' }}" href="{{ route('contact.index') }}">
                        <i class="fas fa-envelope me-1"></i>Kontak
                    </a>
                </li>
            </ul>
            <!-- Search Form -->
            <form class="d-flex ms-lg-3 mt-2 mt-lg-0" action="{{ route('posts.index') }}" method="GET" style="max-width:260px;width:100%;">
                <div class="input-group">
                    <input class="form-control" type="search" name="search" placeholder="Cari berita..." value="{{ request('search') }}">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</nav>