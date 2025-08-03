@extends('layouts.frontend')

@section('title', $post->title . ' - Desa Karangrejo')
@section('description', $post->excerpt)

@section('content')
<!-- Breadcrumb -->
<section class="py-3 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Berita</a></li>
                <li class="breadcrumb-item"><a href="{{ route('posts.index', ['category' => $post->category->slug]) }}">{{ $post->category->name }}</a></li>
                <li class="breadcrumb-item active">{{ $post->title }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Post Content -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <article class="mb-5">
                    <!-- Post Header -->
                    <header class="mb-4">
                        <span class="badge bg-primary mb-2">{{ $post->category->name }}</span>
                        <h1 class="display-6 fw-bold mb-3">{{ $post->title }}</h1>
                        
                        <div class="d-flex align-items-center text-muted mb-4">
                            <div class="me-4">
                                <i class="fas fa-user me-2"></i>{{ $post->user->name }}
                            </div>
                            <div class="me-4">
                                <i class="fas fa-calendar me-2"></i>{{ $post->published_at->format('d F Y') }}
                            </div>
                            <div class="me-4">
                                <i class="fas fa-eye me-2"></i>{{ $post->views }} views
                            </div>
                            <div>
                                <i class="fas fa-clock me-2"></i>{{ $post->published_at->diffForHumans() }}
                            </div>
                        </div>
                    </header>

                    <!-- Featured Image -->
                    @if($post->featured_image)
                    <div class="mb-4">
                        <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="img-fluid rounded shadow">
                    </div>
                    @endif

                    <!-- Post Content -->
                    <div class="post-content">
                        {!! nl2br(e($post->content)) !!}
                    </div>

                    <!-- Social Sharing -->
                    <div class="border-top pt-4 mt-5">
                        <h6 class="mb-3">Bagikan Artikel Ini:</h6>
                        <div class="d-flex gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="fab fa-facebook-f me-1"></i>Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($post->title) }}" target="_blank" class="btn btn-outline-info btn-sm">
                                <i class="fab fa-twitter me-1"></i>Twitter
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . request()->fullUrl()) }}" target="_blank" class="btn btn-outline-success btn-sm">
                                <i class="fab fa-whatsapp me-1"></i>WhatsApp
                            </a>
                            <button onclick="copyToClipboard()" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-link me-1"></i>Copy Link
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Navigation -->
                @if($previousPost || $nextPost)
                <nav class="border-top pt-4 mb-5">
                    <div class="row">
                        @if($previousPost)
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('posts.show', $previousPost) }}" class="text-decoration-none">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-chevron-left me-3 text-primary"></i>
                                    <div>
                                        <small class="text-muted">Artikel Sebelumnya</small>
                                        <h6 class="mb-0">{{ Str::limit($previousPost->title, 50) }}</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endif
                        
                        @if($nextPost)
                        <div class="col-md-6 mb-3 text-md-end">
                            <a href="{{ route('posts.show', $nextPost) }}" class="text-decoration-none">
                                <div class="d-flex align-items-center justify-content-md-end">
                                    <div class="text-md-end me-md-3">
                                        <small class="text-muted">Artikel Selanjutnya</small>
                                        <h6 class="mb-0">{{ Str::limit($nextPost->title, 50) }}</h6>
                                    </div>
                                    <i class="fas fa-chevron-right ms-3 text-primary"></i>
                                </div>
                            </a>
                        </div>
                        @endif
                    </div>
                </nav>
                @endif

                <!-- Related Posts -->
                @if($relatedPosts->count() > 0)
                <section class="border-top pt-4">
                    <h4 class="mb-4">Berita Terkait</h4>
                    <div class="row">
                        @foreach($relatedPosts as $related)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                @if($related->featured_image)
                                <img src="{{ $related->featured_image_url }}" class="card-img-top" alt="{{ $related->title }}" style="height: 150px; object-fit: cover;">
                                @endif
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <a href="{{ route('posts.show', $related) }}" class="text-decoration-none text-dark">
                                            {{ $related->title }}
                                        </a>
                                    </h6>
                                    <p class="card-text text-muted small">{{ Str::limit($related->excerpt, 100) }}</p>
                                    <small class="text-muted">{{ $related->published_at->format('d M Y') }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Author Info -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="fas fa-user me-2"></i>Tentang Penulis</h6>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ $post->user->avatar_url }}" alt="{{ $post->user->name }}" class="rounded-circle mb-3" width="80" height="80">
                        <h6>{{ $post->user->name }}</h6>
                        @if($post->user->bio)
                        <p class="text-muted small">{{ $post->user->bio }}</p>
                        @endif
                        <small class="text-muted">{{ $post->user->role === 'admin' ? 'Administrator' : 'Operator Desa' }}</small>
                    </div>
                </div>

                <!-- Latest Posts -->
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0"><i class="fas fa-newspaper me-2"></i>Berita Terbaru</h6>
                    </div>
                    <div class="card-body">
                        <!-- This will be populated with latest posts -->
                        <p class="text-muted">Loading berita terbaru...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
function copyToClipboard() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        alert('Link berhasil disalin!');
    });
}
</script>
@endpush