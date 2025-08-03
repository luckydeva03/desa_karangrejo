@extends('layouts.frontend')

@section('title', 'Akses Ditolak')

@section('content')
<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
            <div class="error-page">
                <div class="error-code mb-4">
                    <h1 class="display-1 fw-bold text-warning">403</h1>
                </div>
                <div class="error-message">
                    <h2 class="h3 mb-3">Akses Ditolak</h2>
                    <p class="lead text-muted mb-4">
                        Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.
                        Silakan hubungi administrator jika Anda merasa ini adalah kesalahan.
                    </p>
                    <div class="error-actions">
                        <a href="{{ route('home') }}" class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-home me-2"></i>
                            Kembali ke Beranda
                        </a>
                        @auth
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Login
                            </a>
                        @endauth
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
