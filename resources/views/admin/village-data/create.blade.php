@extends('layouts.admin')

@section('title', 'Tambah Data Desa')
@section('page-title', 'Tambah Data Desa')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-primary">Form Tambah Data Desa</h6>
                <a href="{{ route('admin.village-data.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Kembali
                </a>
            </div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <form method="POST" action="{{ url('admin/village-data') }}" onsubmit="console.log('Form is being submitted'); return true;">
                    @csrf
                    <div class="mb-3">
                        <label for="label" class="form-label fw-bold">Label *</label>
                        <input type="text" class="form-control @error('label') is-invalid @enderror" id="label" name="label" value="{{ old('label') }}" required placeholder="Contoh: Jumlah Penduduk">
                        @error('label')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="value" class="form-label fw-bold">Nilai *</label>
                        <input type="text" class="form-control @error('value') is-invalid @enderror" id="value" name="value" value="{{ old('value') }}" required placeholder="Contoh: 5,234">
                        @error('value')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="type" class="form-label fw-bold">Kategori *</label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                            <option value="">Pilih Kategori</option>
                            <option value="demografi" {{ old('type') == 'demografi' ? 'selected' : '' }}>Demografi</option>
                            <option value="geografis" {{ old('type') == 'geografis' ? 'selected' : '' }}>Geografis</option>
                            <option value="ekonomi" {{ old('type') == 'ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                            <option value="pendidikan" {{ old('type') == 'pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                            <option value="kesehatan" {{ old('type') == 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                        </select>
                        @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Deskripsi singkat tentang data ini">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="icon" class="form-label fw-bold">Ikon</label>
                        <input type="text" class="form-control @error('icon') is-invalid @enderror" id="icon" name="icon" value="{{ old('icon') }}" placeholder="Contoh: fas fa-users">
                        @error('icon')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Gunakan kelas Font Awesome, contoh: fas fa-users, fas fa-home, fas fa-chart-bar</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="sort_order" class="form-label fw-bold">Urutan Tampilan</label>
                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', 1) }}" min="0" placeholder="1">
                        @error('sort_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Angka yang lebih kecil akan ditampilkan lebih dahulu</div>
                    </div>
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Data
                        </button>
                        <a href="{{ route('admin.village-data.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
