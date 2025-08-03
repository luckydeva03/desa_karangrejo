@extends('layouts.admin')

@section('title', 'Detail Halaman')
@section('page-title', 'Detail Halaman')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-primary">Detail Halaman: {{ $page->title }}</h6>
                <div>
                    <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-warning btn-sm me-2">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8">
                        <!-- Title -->
                        <div class="mb-4">
                            <h3 class="mb-3">{{ $page->title }}</h3>
                            <div class="text-muted mb-3">
                                <small>
                                    <i class="fas fa-user me-1"></i>{{ $page->user->name ?? 'Unknown' }} &bull;
                                    <i class="fas fa-calendar me-1"></i>{{ $page->created_at->format('d F Y, H:i') }} &bull;
                                    <i class="fas fa-edit me-1"></i>{{ $page->updated_at->format('d F Y, H:i') }}
                                </small>
                            </div>
                        </div>
                        
                        <!-- Featured Image -->
                        @if($page->featured_image)
                        <div class="mb-4">
                            <img src="{{ $page->featured_image_url }}" alt="{{ $page->title }}" 
                                 class="img-fluid rounded shadow-sm">
                        </div>
                        @endif
                        
                        <!-- Content -->
                        <div class="mb-4">
                            <h5 class="mb-3">Isi Halaman</h5>
                            <div class="content-preview border rounded p-3" style="background-color: #f8f9fa;">
                                {!! $page->content !!}
                            </div>
                        </div>
                        
                        <!-- SEO Information -->
                        @if($page->meta_title || $page->meta_description)
                        <div class="mb-4">
                            <h5 class="mb-3">Informasi SEO</h5>
                            <div class="card">
                                <div class="card-body">
                                    @if($page->meta_title)
                                    <div class="mb-2">
                                        <strong>Meta Title:</strong><br>
                                        <span class="text-muted">{{ $page->meta_title }}</span>
                                    </div>
                                    @endif
                                    @if($page->meta_description)
                                    <div>
                                        <strong>Meta Description:</strong><br>
                                        <span class="text-muted">{{ $page->meta_description }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <div class="col-lg-4">
                        <!-- Page Info -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="m-0 fw-bold">Informasi Halaman</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <strong>Tipe:</strong><br>
                                    <span class="badge bg-info">{{ ucwords(str_replace('_', ' ', $page->type)) }}</span>
                                </div>
                                <div class="mb-3">
                                    <strong>Status:</strong><br>
                                    <span class="badge bg-{{ $page->status === 'active' ? 'success' : 'warning' }}">
                                        {{ ucfirst($page->status) }}
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <strong>Slug:</strong><br>
                                    <code>{{ $page->slug }}</code>
                                </div>
                                <div class="mb-3">
                                    <strong>URL Frontend:</strong><br>
                                    @php
                                        $frontendUrl = '';
                                        switch($page->type) {
                                            case 'history':
                                                $frontendUrl = route('history');
                                                break;
                                            case 'vision_mission':
                                                $frontendUrl = route('vision-mission');
                                                break;
                                            case 'organization_structure':
                                                $frontendUrl = route('organization');
                                                break;
                                            default:
                                                $frontendUrl = route('pages.show', $page);
                                        }
                                    @endphp
                                    <a href="{{ $frontendUrl }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-external-link-alt me-1"></i>Lihat Halaman
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="card">
                            <div class="card-header">
                                <h6 class="m-0 fw-bold">Aksi</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-warning">
                                        <i class="fas fa-edit me-2"></i>Edit Halaman
                                    </a>
                                    <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" 
                                          onsubmit="return confirm('Yakin ingin menghapus halaman ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger w-100">
                                            <i class="fas fa-trash me-2"></i>Hapus Halaman
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.content-preview {
    max-height: 500px;
    overflow-y: auto;
}

.content-preview h1, .content-preview h2, .content-preview h3, 
.content-preview h4, .content-preview h5, .content-preview h6 {
    margin-top: 1rem;
    margin-bottom: 0.5rem;
}

.content-preview p {
    margin-bottom: 1rem;
}

.content-preview img {
    max-width: 100%;
    height: auto;
    border-radius: 0.375rem;
}
</style>
@endpush
