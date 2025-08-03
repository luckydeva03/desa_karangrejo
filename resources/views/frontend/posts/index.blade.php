@extends('layouts.frontend')

@section('title', 'Berita - Desa Karangrejo')
@section('description', 'Kumpulan berita terkini dan informasi penting dari Desa Karangrejo')

@section('content')
<!-- Page Header -->
<section class="bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-5 fw-bold mb-3">Berita Desa</h1>
                <p class="lead mb-0">Informasi terkini seputar kegiatan dan perkembangan Desa Karangrejo</p>
            </div>
        </div>
    </div>
</section>

<!-- Search and Filter Section -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <form method="GET" action="{{ route('posts.index') }}" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control" placeholder="Cari berita..." value="{{ request('search') }}">
                    <select name="category" class="form-select" style="width: 200px;">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                            {{ $category->name }} ({{ $category->posts_count }})
                        </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            <div class="col-md-4 text-md-end">
                <small class="text-muted">
                    Menampilkan {{ $posts->count() }} dari {{ $posts->total() }} berita
                </small>
            </div>
        </div>
    </div>
</section>

<!-- Posts Content -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                @if($posts->count() > 0)
                    <div class="row">
                        @foreach($posts as $post)
                        <div class="col-md-6 mb-4">
                            <article class="card h-100 border-0 shadow-sm">
                                @if($post->featured_image)
                                <img src="{{ $post->featured_image_url }}" class="card-img-top" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
                                @endif
                                <div class="card-body d-flex flex-column">
                                    <div class="mb-2">
                                        <span class="badge bg-primary">{{ $post->category->name }}</span>
                                        <small class="text-muted ms-2">
                                            <i class="fas fa-calendar me-1"></i>{{ $post->published_at->format('d M Y') }}
                                        </small>
                                    </div>
                                    <h5 class="card-title">
                                        <a href="{{ route('posts.show', $post) }}" class="text-decoration-none text-dark">
                                            {{ $post->title }}
                                        </a>
                                    </h5>
                                    <p class="card-text text-muted flex-grow-1">{{ $post->excerpt }}</p>
                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <small class="text-muted">
                                            <i class="fas fa-user me-1"></i>{{ $post->user->name }}
                                        </small>
                                        <div>
                                            <small class="text-muted me-3">
                                                <i class="fas fa-eye me-1"></i>{{ $post->views }}
                                            </small>
                                            <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-outline-primary">
                                                Baca Selengkapnya
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $posts->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                        <h4>Tidak ada berita ditemukan</h4>
                        <p class="text-muted">Coba ubah kata kunci pencarian atau pilih kategori lain.</p>
                        <a href="{{ route('posts.index') }}" class="btn btn-primary">Lihat Semua Berita</a>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Categories Widget -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="fas fa-tags me-2"></i>Kategori</h6>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @foreach($categories as $category)
                            <a href="{{ route('posts.index', ['category' => $category->slug]) }}" 
                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                {{ $category->name }}
                                <span class="badge bg-primary rounded-pill">{{ $category->posts_count }}</span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Popular Posts Widget -->
                @if(isset($popularPosts) && $popularPosts->count() > 0)
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0"><i class="fas fa-fire me-2"></i>Berita Populer</h6>
                    </div>
                    <div class="card-body">
                        @foreach($popularPosts as $popular)
                        <div class="d-flex mb-3 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
                            @if($popular->featured_image)
                            <img src="{{ $popular->featured_image_url }}" alt="{{ $popular->title }}" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                            @endif
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <a href="{{ route('posts.show', $popular) }}" class="text-decoration-none text-dark">
                                        {{ Str::limit($popular->title, 50) }}
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    <i class="fas fa-eye me-1"></i>{{ $popular->views }} views
                                </small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Archive Widget -->
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="fas fa-archive me-2"></i>Arsip</h6>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item list-group-item-action">Juli 2025</a>
                            <a href="#" class="list-group-item list-group-item-action">Juni 2025</a>
                            <a href="#" class="list-group-item list-group-item-action">Mei 2025</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection