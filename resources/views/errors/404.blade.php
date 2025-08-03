@extends('layouts.frontend')

@section('title', 'Halaman Tidak Ditemukan')

@section('content')
<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
            <div class="error-page">
                <div class="error-code mb-4">
                    <h1 class="display-1 fw-bold text-primary">404</h1>
                </div>
                <div class="error-message">
                    <h2 class="h3 mb-3">Halaman Tidak Ditemukan</h2>
                    <p class="lead text-muted mb-4">
                        Maaf, halaman yang Anda cari tidak dapat ditemukan. 
                        Mungkin halaman telah dipindahkan atau tidak ada.
                    </p>
                    <div class="error-actions">
                        <a href="{{ route('home') }}" class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-home me-2"></i>
                            Kembali ke Beranda
                        </a>
                        <button onclick="history.back()" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>
                            Halaman Sebelumnya
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Suggestions -->
    <div class="row justify-content-center mt-5">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Mungkin Anda mencari:</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
                                <li><a href="{{ route('profile') }}" class="text-decoration-none">Profil Desa</a></li>
                                <li><a href="{{ route('posts.index') }}" class="text-decoration-none">Berita</a></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li><a href="{{ route('galleries.index') }}" class="text-decoration-none">Galeri</a></li>
                                <li><a href="{{ route('contact.index') }}" class="text-decoration-none">Kontak</a></li>
                                <li><a href="{{ route('vision-mission') }}" class="text-decoration-none">Visi & Misi</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.error-page {
    padding: 2rem 0;
}

.error-code h1 {
    font-size: 8rem;
    line-height: 1;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
}

@media (max-width: 768px) {
    .error-code h1 {
        font-size: 6rem;
    }
    
    .error-actions .btn {
        display: block;
        margin: 0.5rem 0;
        width: 100%;
    }
}
</style>
@endsection
