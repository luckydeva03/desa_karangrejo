@extends('layouts.admin')

@section('title', 'Tambah Tipe Data Desa')
@section('page-title', 'Tambah Tipe Data Desa')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Tambah Tipe Data Desa</h1>
        <p class="text-muted">Buat kategori baru untuk data desa</p>
    </div>
    <a href="{{ route('admin.village-data-types.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <form action="{{ route('admin.village-data-types.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Tipe Data <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" 
                               placeholder="Contoh: Demografi" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Nama kategori akan otomatis dibuat slug-nya</div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3" 
                                  placeholder="Deskripsi singkat tentang tipe data ini">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="color" class="form-label">Warna Badge <span class="text-danger">*</span></label>
                                <select class="form-select @error('color') is-invalid @enderror" id="color" name="color" required>
                                    <option value="">Pilih warna...</option>
                                    <option value="primary" {{ old('color') == 'primary' ? 'selected' : '' }}>
                                        <span class="badge bg-primary">Primary (Biru)</span>
                                    </option>
                                    <option value="secondary" {{ old('color') == 'secondary' ? 'selected' : '' }}>
                                        <span class="badge bg-secondary">Secondary (Abu-abu)</span>
                                    </option>
                                    <option value="success" {{ old('color') == 'success' ? 'selected' : '' }}>
                                        <span class="badge bg-success">Success (Hijau)</span>
                                    </option>
                                    <option value="danger" {{ old('color') == 'danger' ? 'selected' : '' }}>
                                        <span class="badge bg-danger">Danger (Merah)</span>
                                    </option>
                                    <option value="warning" {{ old('color') == 'warning' ? 'selected' : '' }}>
                                        <span class="badge bg-warning">Warning (Kuning)</span>
                                    </option>
                                    <option value="info" {{ old('color') == 'info' ? 'selected' : '' }}>
                                        <span class="badge bg-info">Info (Cyan)</span>
                                    </option>
                                    <option value="light" {{ old('color') == 'light' ? 'selected' : '' }}>
                                        <span class="badge bg-light text-dark">Light (Putih)</span>
                                    </option>
                                    <option value="dark" {{ old('color') == 'dark' ? 'selected' : '' }}>
                                        <span class="badge bg-dark">Dark (Hitam)</span>
                                    </option>
                                </select>
                                @error('color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="icon" class="form-label">Icon (Font Awesome)</label>
                                <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                                       id="icon" name="icon" value="{{ old('icon') }}" 
                                       placeholder="Contoh: fas fa-users">
                                @error('icon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Gunakan class Font Awesome. Contoh: <code>fas fa-users</code>, <code>fas fa-chart-bar</code>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sort_order" class="form-label">Urutan</label>
                                <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                       id="sort_order" name="sort_order" value="{{ old('sort_order') }}" 
                                       min="0" placeholder="Kosongkan untuk otomatis">
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Kosongkan untuk ditempatkan di urutan terakhir</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                           {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Status Aktif
                                    </label>
                                </div>
                                <div class="form-text">Tipe data aktif akan tersedia untuk dipilih saat menambah data desa</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.village-data-types.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Tipe Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-lightbulb me-2"></i>Tips
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Gunakan nama yang jelas dan mudah dipahami</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Pilih warna yang mudah dibedakan untuk setiap tipe</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Icon membantu identifikasi visual yang cepat</small>
                    </li>
                    <li class="mb-0">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Urutan menentukan tampilan di daftar data desa</small>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card shadow mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-palette me-2"></i>Preview Badge
                </h6>
            </div>
            <div class="card-body">
                <div id="badge-preview">
                    <span class="badge bg-primary">Preview</span>
                </div>
                <div class="form-text mt-2">Preview akan muncul saat memilih warna dan mengisi nama</div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const colorSelect = document.getElementById('color');
    const preview = document.getElementById('badge-preview');

    function updatePreview() {
        const name = nameInput.value || 'Preview';
        const color = colorSelect.value || 'primary';
        preview.innerHTML = `<span class="badge bg-${color}">${name}</span>`;
    }

    nameInput.addEventListener('input', updatePreview);
    colorSelect.addEventListener('change', updatePreview);
});
</script>
@endsection
