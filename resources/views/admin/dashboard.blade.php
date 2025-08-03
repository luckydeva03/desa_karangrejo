@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card border-start border-primary border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-xs fw-bold text-primary text-uppercase mb-1">Total Berita</div>
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ $stats['total_posts'] }}</div>
                    </div>
                    <div class="text-primary">
                        <i class="fas fa-newspaper fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card border-start border-success border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-xs fw-bold text-success text-uppercase mb-1">Berita Published</div>
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ $stats['published_posts'] }}</div>
                    </div>
                    <div class="text-success">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card border-start border-warning border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-xs fw-bold text-warning text-uppercase mb-1">Pesan Belum Dibaca</div>
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ $stats['unread_messages'] }}</div>
                    </div>
                    <div class="text-warning">
                        <i class="fas fa-envelope fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card border-start border-info border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-xs fw-bold text-info text-uppercase mb-1">Total Users</div>
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ $stats['total_users'] }}</div>
                    </div>
                    <div class="text-info">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Recent Posts -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-primary">Berita Terbaru</h6>
                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i>Tambah Berita
                </a>
            </div>
            <div class="card-body">
                @if($recentPosts->count() > 0)
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Views</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentPosts as $post)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.posts.show', $post) }}" class="text-decoration-none">
                                        {{ Str::limit($post->title, 50) }}
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $post->category->name }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $post->status === 'published' ? 'success' : 'warning' }}">
                                        {{ ucfirst($post->status) }}
                                    </span>
                                </td>
                                <td>{{ $post->created_at->format('d M Y') }}</td>
                                <td>
                                    <i class="fas fa-eye text-muted me-1"></i>{{ $post->views }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada berita</p>
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Tambah Berita Pertama
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Recent Messages & Quick Actions -->
    <div class="col-xl-4 col-lg-5">
        <!-- Recent Messages -->
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-primary">Pesan Terbaru</h6>
                <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-primary btn-sm">Lihat Semua</a>
            </div>
            <div class="card-body">
                @if($recentMessages->count() > 0)
                @foreach($recentMessages as $message)
                <div class="d-flex align-items-center {{ !$loop->last ? 'border-bottom pb-3 mb-3' : '' }}">
                    <div class="me-3">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fas fa-user text-white"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">{{ $message->name }}</h6>
                                <p class="mb-1 text-muted small">{{ Str::limit($message->subject, 30) }}</p>
                                <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                            </div>
                            <span class="badge bg-{{ $message->status_color }}">{{ $message->status }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="text-center py-3">
                    <i class="fas fa-envelope fa-2x text-muted mb-2"></i>
                    <p class="text-muted mb-0">Belum ada pesan</p>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 fw-bold text-primary">Aksi Cepat</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Berita
                    </a>
                    <a href="{{ route('admin.announcements.create') }}" class="btn btn-warning">
                        <i class="fas fa-bullhorn me-2"></i>Buat Pengumuman
                    </a>
                    <a href="{{ route('admin.galleries.create') }}" class="btn btn-success">
                        <i class="fas fa-images me-2"></i>Upload Galeri
                    </a>
                    <a href="{{ route('admin.village-data.index') }}" class="btn btn-info">
                        <i class="fas fa-chart-bar me-2"></i>Update Data Desa
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Urgent Announcements -->
@if(isset($urgentAnnouncements) && $urgentAnnouncements->count() > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow border-start border-danger border-4">
            <div class="card-header bg-danger text-white">
                <h6 class="m-0 fw-bold">
                    <i class="fas fa-exclamation-triangle me-2"></i>Pengumuman Urgent
                </h6>
            </div>
            <div class="card-body">
                @foreach($urgentAnnouncements as $announcement)
                <div class="alert alert-danger {{ !$loop->last ? 'mb-3' : 'mb-0' }}" role="alert">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="alert-heading">{{ $announcement->title }}</h6>
                            <p class="mb-1">{{ Str::limit($announcement->content, 100) }}</p>
                            <small class="text-muted">{{ $announcement->created_at->diffForHumans() }}</small>
                        </div>
                        <a href="{{ route('admin.announcements.edit', $announcement) }}" class="btn btn-sm btn-outline-danger">
                            Edit
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
// Auto-refresh dashboard setiap 5 menit
setTimeout(function() {
    location.reload();
}, 300000); // 5 minutes
</script>
@endpush