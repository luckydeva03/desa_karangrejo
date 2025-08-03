@extends('layouts.frontend')

@section('title', 'Server Error')

@section('content')
<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
            <div class="error-page">
                <div class="error-code mb-4">
                    <h1 class="display-1 fw-bold text-danger">500</h1>
                </div>
                <div class="error-message">
                    <h2 class="h3 mb-3">Terjadi Kesalahan Server</h2>
                    <p class="lead text-muted mb-4">
                        Maaf, terjadi kesalahan pada server kami. Tim teknis sedang bekerja untuk memperbaikinya.
                        Silakan coba lagi dalam beberapa saat.
                    </p>
                    <div class="error-actions">
                        <a href="{{ route('home') }}" class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-home me-2"></i>
                            Kembali ke Beranda
                        </a>
                        <button onclick="location.reload()" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-redo me-2"></i>
                            Muat Ulang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Contact Info -->
    <div class="row justify-content-center mt-5">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Butuh Bantuan?</h5>
                    <p class="card-text">
                        Jika masalah terus berlanjut, silakan hubungi tim teknis kami.
                    </p>
                    <a href="{{ route('contact.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-envelope me-2"></i>
                        Hubungi Kami
                    </a>
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
