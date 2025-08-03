@extends('layouts.admin')

@section('title', 'Detail Anggota Organisasi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold text-primary">Detail Anggota Organisasi</h5>
                    <div>
                        <a href="{{ route('admin.pages.organizational-members.edit', [$page, $organizational_member->id]) }}" class="btn btn-warning btn-sm me-2">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <a href="{{ route('admin.pages.organizational-members.index', $page) }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Profile Section -->
                        <div class="col-lg-4 mb-4">
                            <div class="text-center mb-4">
                                @if($organizational_member->photo)
                                    <img src="{{ $organizational_member->photo_url }}" alt="{{ $organizational_member->name }}" 
                                         class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                         style="width: 150px; height: 150px; font-size: 2rem; font-weight: bold;">
                                        {{ $organizational_member->getInitials() }}
                                    </div>
                                @endif
                            </div>
                            
                            <div class="text-center">
                                <h4 class="fw-bold mb-2">{{ $organizational_member->name }}</h4>
                                <h6 class="text-primary mb-3">{{ $organizational_member->position }}</h6>
                                
                                @if($organizational_member->status === 'active')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Aktif
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times-circle me-1"></i>Nonaktif
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Contact Information -->
                            @if($organizational_member->phone || $organizational_member->email)
                            <div class="mt-4">
                                <h6 class="fw-bold mb-3">Kontak</h6>
                                @if($organizational_member->phone)
                                <div class="mb-2">
                                    <i class="fas fa-phone text-primary me-2"></i>
                                    <a href="tel:{{ $organizational_member->phone }}" class="text-decoration-none">{{ $organizational_member->phone }}</a>
                                </div>
                                @endif
                                @if($organizational_member->email)
                                <div class="mb-2">
                                    <i class="fas fa-envelope text-primary me-2"></i>
                                    <a href="mailto:{{ $organizational_member->email }}" class="text-decoration-none">{{ $organizational_member->email }}</a>
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>
                        
                        <!-- Information Section -->
                        <div class="col-lg-8">
                            <div class="row">
                                <!-- Basic Information -->
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="fw-bold mb-3 text-primary">
                                                <i class="fas fa-user me-2"></i>Informasi Dasar
                                            </h6>
                                            <div class="mb-3">
                                                <small class="text-muted">Nama Lengkap</small>
                                                <div class="fw-bold">{{ $organizational_member->name }}</div>
                                            </div>
                                            <div class="mb-3">
                                                <small class="text-muted">Jabatan</small>
                                                <div class="fw-bold">{{ $organizational_member->position }}</div>
                                            </div>
                                            @if($organizational_member->department)
                                            <div class="mb-3">
                                                <small class="text-muted">Bagian/Unit Kerja</small>
                                                <div class="fw-bold">{{ $organizational_member->department }}</div>
                                            </div>
                                            @endif
                                            <div class="mb-3">
                                                <small class="text-muted">Urutan Tampil</small>
                                                <div class="fw-bold">{{ $organizational_member->sort_order }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Status & Additional Info -->
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="fw-bold mb-3 text-primary">
                                                <i class="fas fa-info-circle me-2"></i>Status & Info Tambahan
                                            </h6>
                                            <div class="mb-3">
                                                <small class="text-muted">Status</small>
                                                <div>
                                                    @if($organizational_member->status === 'active')
                                                        <span class="badge bg-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-danger">Nonaktif</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <small class="text-muted">Dibuat Pada</small>
                                                <div class="fw-bold">{{ $organizational_member->created_at->format('d F Y H:i') }}</div>
                                            </div>
                                            <div class="mb-3">
                                                <small class="text-muted">Terakhir Diperbarui</small>
                                                <div class="fw-bold">{{ $organizational_member->updated_at->format('d F Y H:i') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Description -->
                                @if($organizational_member->description)
                                <div class="col-12 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="fw-bold mb-3 text-primary">
                                                <i class="fas fa-file-text me-2"></i>Deskripsi/Keterangan
                                            </h6>
                                            <div>
                                                {!! nl2br(e($organizational_member->description)) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.pages.organizational-members.index', $page) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar
                                </a>
                                <div>
                                    <a href="{{ route('admin.pages.organizational-members.edit', [$page, $organizational_member->id]) }}" class="btn btn-warning me-2">
                                        <i class="fas fa-edit me-1"></i>Edit Anggota
                                    </a>
                                    <form method="POST" action="{{ route('admin.pages.organizational-members.destroy', [$page, $organizational_member->id]) }}" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash me-1"></i>Hapus
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
