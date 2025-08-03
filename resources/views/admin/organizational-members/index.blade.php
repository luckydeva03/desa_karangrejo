@extends('layouts.admin')

@section('title', 'Kelola Anggota - ' . $page->title)
@section('page-title', 'Kelola Anggota Organisasi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Kelola Anggota Organisasi</h1>
        <p class="text-muted">{{ $page->title }} - {{ $members->count() }} anggota</p>
    </div>
    <div class="btn-group">
        <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-outline-secondary">
            <i class="fas fa-edit me-2"></i>Edit Halaman
        </a>
        <a href="{{ route('admin.pages.organizational-members.create', $page) }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Anggota
        </a>
    </div>
</div>

<!-- Members Grid -->
<div class="row">
    @forelse($members as $member)
    <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
        <div class="card shadow h-100">
            <!-- Photo -->
            <div class="card-header bg-light text-center p-3">
                <div class="position-relative d-inline-block">
                    @if($member->photo)
                        <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" 
                             class="rounded-circle" width="80" height="80" style="object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; font-size: 1.5rem; font-weight: bold;">
                            {{ $member->getInitials() }}
                        </div>
                    @endif
                    
                    <!-- Status Badge -->
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-{{ $member->status === 'active' ? 'success' : 'secondary' }}">
                        {{ $member->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
            </div>
            
            <!-- Member Info -->
            <div class="card-body text-center">
                <h6 class="card-title fw-bold mb-1">{{ $member->name }}</h6>
                <p class="text-primary small fw-semibold mb-2">{{ $member->position }}</p>
                
                @if($member->department)
                <p class="text-muted small mb-2">
                    <i class="fas fa-building me-1"></i>{{ $member->department }}
                </p>
                @endif
                
                @if($member->description)
                <p class="text-muted small mb-3">{{ Str::limit($member->description, 60) }}</p>
                @endif
                
                <!-- Contact Info -->
                <div class="mb-3">
                    @if($member->phone)
                    <a href="tel:{{ $member->phone }}" class="btn btn-outline-success btn-sm me-1" title="Telepon">
                        <i class="fas fa-phone"></i>
                    </a>
                    @endif
                    @if($member->email)
                    <a href="mailto:{{ $member->email }}" class="btn btn-outline-info btn-sm" title="Email">
                        <i class="fas fa-envelope"></i>
                    </a>
                    @endif
                </div>
            </div>
            
            <!-- Actions -->
            <div class="card-footer bg-transparent border-0 pt-0">
                <div class="btn-group w-100" role="group">
                    <a href="{{ route('admin.pages.organizational-members.edit', [$page, $member->id]) }}" 
                       class="btn btn-outline-warning btn-sm" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="{{ route('admin.pages.organizational-members.show', [$page, $member->id]) }}" 
                       class="btn btn-outline-info btn-sm" title="Lihat">
                        <i class="fas fa-eye"></i>
                    </a>
                    <form action="{{ route('admin.pages.organizational-members.destroy', [$page, $member->id]) }}" 
                          method="POST" class="d-inline" 
                          onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card shadow">
            <div class="card-body text-center py-5">
                <i class="fas fa-users fa-5x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada anggota organisasi</h5>
                <p class="text-muted">Klik tombol "Tambah Anggota" untuk menambahkan anggota organisasi pertama.</p>
                <a href="{{ route('admin.pages.organizational-members.create', $page) }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Anggota Pertama
                </a>
            </div>
        </div>
    </div>
    @endforelse
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-left-primary shadow">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h6 class="text-primary mb-1">Tip: Pengurutan Anggota</h6>
                        <p class="text-muted small mb-0">
                            Atur urutan tampilan anggota dengan mengubah nilai "Urutan Tampil" saat edit anggota. 
                            Nilai lebih kecil akan tampil lebih dulu.
                        </p>
                    </div>
                    <div class="col-4 text-end">
                        <i class="fas fa-sort-numeric-down fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div class="toast show" role="alert">
        <div class="toast-header">
            <strong class="me-auto text-success">Berhasil</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
            {{ session('success') }}
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
// Auto hide toast after 5 seconds
setTimeout(function() {
    $('.toast').toast('hide');
}, 5000);
</script>
@endpush
