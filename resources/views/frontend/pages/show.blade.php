@extends('layouts.frontend')

@section('title', $page->meta_title ?: $page->title)
@section('meta_description', $page->meta_description ?: Str::limit(strip_tags($page->content), 160))

@push('styles')
<style>
.vision-content ul, .mission-content ul, .additional-content ul {
    padding-left: 1.5rem;
    margin-bottom: 1rem;
}

.vision-content ul li, .mission-content ul li, .additional-content ul li {
    margin-bottom: 0.5rem;
    line-height: 1.6;
    list-style-type: disc;
}

.vision-content ol, .mission-content ol, .additional-content ol {
    padding-left: 1.5rem;
    margin-bottom: 1rem;
}

.vision-content ol li, .mission-content ol li, .additional-content ol li {
    margin-bottom: 0.5rem;
    line-height: 1.6;
    list-style-type: decimal;
}

.mission-content {
    font-size: 1rem;
}

.mission-content p, .vision-content p {
    margin-bottom: 1rem;
    line-height: 1.7;
}

.member-card {
    transition: all 0.3s ease;
}

.member-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.contact-info a {
    color: inherit;
}

.contact-info a:hover {
    color: #0d6efd;
}
</style>
@endpush

@push('meta')
    <meta property="og:title" content="{{ $page->meta_title ?: $page->title }}">
    <meta property="og:description" content="{{ $page->meta_description ?: Str::limit(strip_tags($page->content), 160) }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->url() }}">
    @if($page->featured_image)
    <meta property="og:image" content="{{ $page->featured_image_url }}">
    @endif
@endpush

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Page Header -->
            <div class="mb-5">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $page->title }}</li>
                    </ol>
                </nav>
                
                <h1 class="display-4 fw-bold text-primary mb-3">{{ $page->title }}</h1>
                
                @if($page->featured_image)
                <div class="mb-4">
                    <img src="{{ $page->featured_image_url }}" alt="{{ $page->title }}" 
                         class="img-fluid rounded shadow-sm w-100" style="max-height: 400px; object-fit: cover;">
                </div>
                @endif
            </div>

            <!-- Page Content -->
            @if($page->type === 'vision_mission')
                <!-- Vision & Mission Specific Layout -->
                <div class="row g-4">
                    <!-- Vision Section -->
                    @if($page->vision_text)
                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-primary text-white">
                                <h3 class="card-title mb-0">
                                    <i class="fas fa-eye me-2"></i>VISI
                                </h3>
                            </div>
                            <div class="card-body p-4">
                                <div class="vision-content">
                                    {!! strip_tags($page->vision_text, '<p><br><strong><em><ul><ol><li>') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Mission Section -->
                    @if($page->mission_text)
                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-success text-white">
                                <h3 class="card-title mb-0">
                                    <i class="fas fa-bullseye me-2"></i>MISI
                                </h3>
                            </div>
                            <div class="card-body p-4">
                                <div class="mission-content">
                                    {!! strip_tags($page->mission_text, '<p><br><strong><em><ul><ol><li>') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                
                <!-- Additional Content if exists -->
                @if($page->content && trim(strip_tags($page->content)) !== '')
                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-header bg-light">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-info-circle me-2"></i>Informasi Tambahan
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="additional-content">
                            {!! $page->content !!}
                        </div>
                    </div>
                </div>
                @endif
            @elseif($page->type === 'organization_structure')
                <!-- Organization Structure Specific Layout -->
                @if($page->organizationalMembers->where('status', 'active')->count() > 0)
                    <div class="row g-4">
                        @foreach($page->organizationalMembers->where('status', 'active')->sortBy('sort_order') as $member)
                        <div class="col-lg-6 col-xl-4">
                            <div class="card border-0 shadow-sm h-100 member-card">
                                <div class="card-body text-center p-4">
                                    <!-- Member Photo/Avatar -->
                                    <div class="mb-3">
                                        @if($member->photo)
                                            <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" 
                                                 class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" 
                                                 style="width: 120px; height: 120px; font-size: 2.5rem; font-weight: bold;">
                                                {{ $member->getInitials() }}
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Member Info -->
                                    <h5 class="fw-bold text-primary mb-2">{{ $member->name }}</h5>
                                    <p class="text-muted mb-2 fw-semibold">{{ $member->position }}</p>
                                    
                                    @if($member->department)
                                    <p class="text-info small mb-3">
                                        <i class="fas fa-building me-1"></i>{{ $member->department }}
                                    </p>
                                    @endif
                                    
                                    @if($member->description)
                                    <p class="text-muted small mb-3">{{ Str::limit($member->description, 100) }}</p>
                                    @endif
                                    
                                    <!-- Contact Info -->
                                    @if($member->phone || $member->email)
                                    <div class="contact-info">
                                        @if($member->phone)
                                        <p class="small mb-1">
                                            <i class="fas fa-phone text-success me-2"></i>
                                            <a href="tel:{{ $member->phone }}" class="text-decoration-none">{{ $member->phone }}</a>
                                        </p>
                                        @endif
                                        @if($member->email)
                                        <p class="small mb-0">
                                            <i class="fas fa-envelope text-primary me-2"></i>
                                            <a href="mailto:{{ $member->email }}" class="text-decoration-none">{{ $member->email }}</a>
                                        </p>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted mb-2">Struktur Organisasi Belum Tersedia</h4>
                            <p class="text-muted">Informasi anggota organisasi sedang dalam proses pembaruan.</p>
                        </div>
                    </div>
                @endif
            @else
                <!-- Regular Page Layout -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="page-content">
                            {!! $page->content !!}
                        </div>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="text-center mt-5">
                <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.page-content {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #495057;
}

.page-content h1, .page-content h2, .page-content h3, 
.page-content h4, .page-content h5, .page-content h6 {
    color: #2c5aa0;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.page-content h1 {
    font-size: 2.25rem;
    border-bottom: 3px solid #2c5aa0;
    padding-bottom: 0.5rem;
}

.page-content h2 {
    font-size: 1.875rem;
    border-bottom: 2px solid #6c757d;
    padding-bottom: 0.25rem;
}

.page-content h3 {
    font-size: 1.5rem;
}

.page-content p {
    margin-bottom: 1.5rem;
    text-align: justify;
}

.page-content img {
    max-width: 100%;
    height: auto;
    border-radius: 0.5rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    margin: 1rem 0;
}

.page-content ul, .page-content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.page-content li {
    margin-bottom: 0.5rem;
}

.page-content blockquote {
    border-left: 4px solid #2c5aa0;
    padding-left: 1rem;
    margin: 2rem 0;
    font-style: italic;
    background-color: #f8f9fa;
    padding: 1rem 1rem 1rem 2rem;
    border-radius: 0.375rem;
}

.page-content table {
    width: 100%;
    margin-bottom: 1.5rem;
    border-collapse: collapse;
}

.page-content table th,
.page-content table td {
    padding: 0.75rem;
    border: 1px solid #dee2e6;
    text-align: left;
}

.page-content table th {
    background-color: #f8f9fa;
    font-weight: 600;
}

.page-content table tbody tr:nth-of-type(odd) {
    background-color: rgba(0, 0, 0, 0.025);
}
</style>
@endpush
