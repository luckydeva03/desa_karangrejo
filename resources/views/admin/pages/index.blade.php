@extends('layouts.admin')

@section('title', 'Kelola Halaman')
@section('page-title', 'Kelola Halaman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Kelola Halaman</h1>
        <p class="text-muted">Kelola halaman statis seperti Sejarah, Visi & Misi, dan Struktur Organisasi</p>
    </div>
    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Halaman
    </a>
</div>

<!-- Page Type Tabs -->
<div class="card shadow mb-4">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs" id="pageTypeTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ request('type', 'all') === 'all' ? 'active' : '' }}" 
                        onclick="window.location.href='{{ route('admin.pages.index') }}?type=all'"
                        type="button">
                    <i class="fas fa-list me-2"></i>Semua Halaman
                    <span class="badge bg-secondary ms-2">{{ $totalPages }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ request('type') === 'history' ? 'active' : '' }}" 
                        onclick="window.location.href='{{ route('admin.pages.index') }}?type=history'"
                        type="button">
                    <i class="fas fa-history me-2"></i>Sejarah Desa
                    <span class="badge bg-secondary ms-2">{{ $historyCount }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ request('type') === 'vision_mission' ? 'active' : '' }}" 
                        onclick="window.location.href='{{ route('admin.pages.index') }}?type=vision_mission'"
                        type="button">
                    <i class="fas fa-bullseye me-2"></i>Visi & Misi
                    <span class="badge bg-secondary ms-2">{{ $visionMissionCount }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ request('type') === 'organization_structure' ? 'active' : '' }}" 
                        onclick="window.location.href='{{ route('admin.pages.index') }}?type=organization_structure'"
                        type="button">
                    <i class="fas fa-sitemap me-2"></i>Struktur Organisasi
                    <span class="badge bg-secondary ms-2">{{ $organizationCount }}</span>
                </button>
            </li>
        </ul>
    </div>
</div>

<!-- Pages Table -->
<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h6 class="m-0 fw-bold text-primary">
                @if(request('type') === 'history')
                    <i class="fas fa-history me-2"></i>Sejarah Desa
                @elseif(request('type') === 'vision_mission')
                    <i class="fas fa-bullseye me-2"></i>Visi & Misi
                @elseif(request('type') === 'organization_structure')
                    <i class="fas fa-sitemap me-2"></i>Struktur Organisasi
                @else
                    <i class="fas fa-list me-2"></i>Semua Halaman
                @endif
                ({{ $pages->total() }} halaman)
            </h6>
        </div>
        <div class="btn-group">
            @if(request('type') && request('type') !== 'all')
                <a href="{{ route('admin.pages.create', ['type' => request('type')]) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i>Tambah 
                    @if(request('type') === 'history')
                        Sejarah
                    @elseif(request('type') === 'vision_mission')
                        Visi & Misi
                    @elseif(request('type') === 'organization_structure')
                        Struktur Organisasi
                    @endif
                </a>
            @endif
        </div>
    </div>
    
    @if(request('type') && request('type') !== 'all')
    <div class="card-body border-bottom bg-light">
        <div class="alert alert-info mb-0" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            @if(request('type') === 'history')
                <strong>Sejarah Desa:</strong> Halaman ini berisi informasi tentang asal-usul, perkembangan, dan peristiwa penting dalam sejarah desa.
            @elseif(request('type') === 'vision_mission')
                <strong>Visi & Misi:</strong> Halaman ini berisi visi, misi, dan tujuan pembangunan desa untuk masa depan.
            @elseif(request('type') === 'organization_structure')
                <strong>Struktur Organisasi:</strong> Halaman ini berisi informasi tentang susunan pemerintahan desa dan struktur organisasi.
            @endif
        </div>
    </div>
    @endif
    <div class="card-body">
        @if($pages->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="25%">Judul</th>
                        <th width="15%">Tipe</th>
                        <th width="10%">Status</th>
                        <th width="15%">Dibuat Oleh</th>
                        <th width="15%">Tanggal</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $page)
                    <tr>
                        <td>{{ $loop->iteration + ($pages->currentPage() - 1) * $pages->perPage() }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($page->featured_image)
                                <img src="{{ $page->featured_image_url }}" alt="Thumbnail" class="rounded me-3" width="50" height="35" style="object-fit: cover;">
                                @endif
                                <div>
                                    <h6 class="mb-1">{{ $page->title }}</h6>
                                    <small class="text-muted">{{ Str::limit(strip_tags($page->content), 60) }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ ucwords(str_replace('_', ' ', $page->type)) }}</span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $page->status === 'active' ? 'success' : 'warning' }}">
                                {{ ucfirst($page->status) }}
                            </span>
                        </td>
                        <td>
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i>{{ $page->user->name ?? 'Unknown' }}
                            </small>
                        </td>
                        <td>
                            <small class="text-muted">
                                {{ $page->created_at->format('d/m/Y H:i') }}
                            </small>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.pages.show', $page) }}" class="btn btn-sm btn-info" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Yakin ingin menghapus halaman ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $pages->links() }}
        </div>
        @else
        <div class="text-center py-5">
            @if(request('type') === 'history')
                <i class="fas fa-history fa-5x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada halaman Sejarah Desa</h5>
                <p class="text-muted">Buat halaman sejarah untuk menceritakan asal-usul dan perkembangan desa.</p>
                <a href="{{ route('admin.pages.create', ['type' => 'history']) }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Sejarah Desa
                </a>
            @elseif(request('type') === 'vision_mission')
                <i class="fas fa-bullseye fa-5x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada halaman Visi & Misi</h5>
                <p class="text-muted">Buat halaman visi dan misi untuk menjelaskan tujuan dan arah pembangunan desa.</p>
                <a href="{{ route('admin.pages.create', ['type' => 'vision_mission']) }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Visi & Misi
                </a>
            @elseif(request('type') === 'organization_structure')
                <i class="fas fa-sitemap fa-5x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada halaman Struktur Organisasi</h5>
                <p class="text-muted">Buat halaman struktur organisasi untuk menampilkan susunan pemerintahan desa.</p>
                <a href="{{ route('admin.pages.create', ['type' => 'organization_structure']) }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Struktur Organisasi
                </a>
            @else
                <i class="fas fa-file-alt fa-5x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada halaman</h5>
                <p class="text-muted">Klik tombol "Tambah Halaman" untuk membuat halaman baru.</p>
                <div class="btn-group" role="group">
                    <a href="{{ route('admin.pages.create', ['type' => 'history']) }}" class="btn btn-outline-primary">
                        <i class="fas fa-history me-1"></i>Sejarah Desa
                    </a>
                    <a href="{{ route('admin.pages.create', ['type' => 'vision_mission']) }}" class="btn btn-outline-primary">
                        <i class="fas fa-bullseye me-1"></i>Visi & Misi
                    </a>
                    <a href="{{ route('admin.pages.create', ['type' => 'organization_structure']) }}" class="btn btn-outline-primary">
                        <i class="fas fa-sitemap me-1"></i>Struktur Organisasi
                    </a>
                </div>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection
