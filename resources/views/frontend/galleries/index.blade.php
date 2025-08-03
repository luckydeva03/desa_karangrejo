@extends('layouts.frontend')

@section('title', 'Galeri - Desa Karangrejo')
@section('description', 'Dokumentasi kegiatan dan momen penting di Desa Karangrejo')

@section('content')
<!-- Page Header -->
<section class="bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-5 fw-bold mb-3">Galeri Desa</h1>
                <p class="lead mb-0">Dokumentasi kegiatan dan momen penting di Desa Karangrejo</p>
            </div>
        </div>
    </div>
</section>

<!-- Filter Section -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="btn-group" role="group">
                    <a href="{{ route('galleries.index') }}" class="btn {{ !request('type') ? 'btn-primary' : 'btn-outline-primary' }}">
                        Semua ({{ $photoCount + $videoCount }})
                    </a>
                    <a href="{{ route('galleries.index', ['type' => 'photo']) }}" class="btn {{ request('type') == 'photo' ? 'btn-primary' : 'btn-outline-primary' }}">
                        Foto ({{ $photoCount }})
                    </a>
                    <a href="{{ route('galleries.index', ['type' => 'video']) }}" class="btn {{ request('type') == 'video' ? 'btn-primary' : 'btn-outline-primary' }}">
                        Video ({{ $videoCount }})
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <form method="GET" action="{{ route('galleries.index') }}" class="d-flex gap-2">
                    @if(request('type'))
                    <input type="hidden" name="type" value="{{ request('type') }}">
                    @endif
                    <select name="category" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                            {{ ucfirst($category) }}
                        </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Content -->
<section class="section-padding">
    <div class="container">
        @if($galleries->count() > 0)
        <div class="row" id="gallery-container">
            @foreach($galleries as $gallery)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm gallery-item" data-bs-toggle="modal" data-bs-target="#galleryModal{{ $gallery->id }}">
                    <div class="position-relative overflow-hidden">
                        @if($gallery->type === 'video')
                        <!-- Video Thumbnail with Play Overlay -->
                        <div class="video-thumbnail-container" style="height: 250px; position: relative; background: #000; cursor: pointer;">
                            <video style="width: 100%; height: 100%; object-fit: cover;" preload="metadata" muted playsinline poster="">
                                <source src="{{ $gallery->video_url }}" type="video/mp4">
                                <source src="{{ $gallery->video_url }}" type="video/quicktime">
                                <!-- Fallback image for unsupported browsers -->
                                <img src="{{ asset('images/default-video.svg') }}" alt="{{ $gallery->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </video>
                            <div class="position-absolute top-50 start-50 translate-middle" style="pointer-events: none;">
                                <div class="bg-dark bg-opacity-75 rounded-circle p-3">
                                    <i class="fas fa-play text-white" style="font-size: 2rem; margin-left: 3px;"></i>
                                </div>
                            </div>
                        </div>
                        @else
                        <!-- Photo Thumbnail -->
                        <img src="{{ $gallery->thumbnail }}" class="card-img-top" alt="{{ $gallery->title }}" style="height: 250px; object-fit: cover; cursor: pointer;">
                        @endif
                        
                        <div class="position-absolute top-0 end-0 p-2">
                            @if($gallery->type === 'video')
                            <span class="badge bg-danger">
                                <i class="fas fa-play me-1"></i>Video
                            </span>
                            @else
                            <span class="badge bg-primary">
                                <i class="fas fa-image me-1"></i>{{ is_array($gallery->images) ? count($gallery->images) : 0 }} Foto
                            </span>
                            @endif
                        </div>
                        <div class="position-absolute bottom-0 start-0 end-0 bg-gradient-to-t from-black/70 to-transparent p-3 text-white">
                            <h6 class="mb-1">{{ $gallery->title }}</h6>
                            @if($gallery->category)
                            <small class="opacity-75">{{ ucfirst($gallery->category) }}</small>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Modal for each gallery -->
                <div class="modal fade" id="galleryModal{{ $gallery->id }}" tabindex="-1">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ $gallery->title }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body p-0">
                                @if($gallery->type === 'photo')
                                <div id="carousel{{ $gallery->id }}" class="carousel slide">
                                    <div class="carousel-inner">
                                        @if(is_array($gallery->images))
                                            @foreach($gallery->images as $index => $image)
                                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                <img src="{{ asset('storage/' . $image) }}" class="d-block w-100" alt="Image {{ $index + 1 }}" style="max-height: 70vh; object-fit: contain;">
                                            </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    @if(is_array($gallery->images) && count($gallery->images) > 1)
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $gallery->id }}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $gallery->id }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                    </button>
                                    @endif
                                </div>
                                @elseif($gallery->type === 'video')
                                <!-- Video Player -->
                                <div class="d-flex justify-content-center align-items-center" style="background: #000; min-height: 400px;">
                                    @if($gallery->video_url)
                                    <video controls class="w-100" style="max-height: 70vh; max-width: 100%;" preload="metadata">
                                        <source src="{{ $gallery->video_url }}" type="video/mp4">
                                        <source src="{{ $gallery->video_url }}" type="video/quicktime">
                                        <source src="{{ $gallery->video_url }}" type="video/x-msvideo">
                                        <p class="text-white">Browser Anda tidak mendukung tag video. 
                                        <a href="{{ $gallery->video_url }}" class="text-primary">Download video</a></p>
                                    </video>
                                    @else
                                    <p class="text-white">Video tidak ditemukan.</p>
                                    @endif
                                </div>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <div class="me-auto">
                                    @if($gallery->description)
                                    <p class="mb-0 text-muted">{{ $gallery->description }}</p>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $galleries->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-images fa-3x text-muted mb-3"></i>
            <h4>Tidak ada galeri ditemukan</h4>
            <p class="text-muted">Belum ada galeri yang tersedia untuk kategori ini.</p>
        </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
.gallery-item {
    transition: transform 0.3s ease;
    cursor: pointer;
}

.gallery-item:hover {
    transform: translateY(-5px);
}

.bg-gradient-to-t {
    background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 100%);
}

.video-thumbnail-container {
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.video-thumbnail-container video {
    pointer-events: none;
    transition: transform 0.3s ease;
}

.video-thumbnail-container:hover video {
    transform: scale(1.05);
}

.video-thumbnail-container:hover .fa-play {
    transform: scale(1.1);
}

.video-thumbnail-container .fa-play {
    transition: transform 0.3s ease;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));
}

/* Modal video styling */
.modal-body video {
    background: #000;
    border-radius: 8px;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Pause all videos when modal is closed
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.addEventListener('hidden.bs.modal', function() {
            const videos = this.querySelectorAll('video');
            videos.forEach(video => {
                video.pause();
                video.currentTime = 0;
            });
        });
    });
    
    // Auto play video when modal is opened (optional)
    modals.forEach(modal => {
        modal.addEventListener('shown.bs.modal', function() {
            const videos = this.querySelectorAll('video');
            videos.forEach(video => {
                // Uncomment next line if you want auto-play
                // video.play();
            });
        });
    });
});
</script>
@endpush