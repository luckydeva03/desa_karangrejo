@extends('layouts.admin')

@section('title', 'Edit Data Desa')
@section('page-title', 'Edit Data Desa')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-primary">Form Edit Data Desa</h6>
                <a href="{{ route('admin.village-data.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Kembali
                </a>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.village-data.update', $villageData->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="label" class="form-label fw-bold">Label *</label>
                        <input type="text" class="form-control @error('label') is-invalid @enderror" id="label" name="label" value="{{ old('label', $villageData->label) }}" required>
                        @error('label')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="value" class="form-label fw-bold">Nilai *</label>
                        <input type="text" class="form-control @error('value') is-invalid @enderror" id="value" name="value" value="{{ old('value', $villageData->value) }}" required>
                        @error('value')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="type" class="form-label fw-bold">Kategori *</label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                            <option value="">Pilih Kategori</option>
                            <option value="demografi" {{ old('type', $villageData->type) == 'demografi' ? 'selected' : '' }}>Demografi</option>
                            <option value="geografis" {{ old('type', $villageData->type) == 'geografis' ? 'selected' : '' }}>Geografis</option>
                            <option value="ekonomi" {{ old('type', $villageData->type) == 'ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                            <option value="pendidikan" {{ old('type', $villageData->type) == 'pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                            <option value="kesehatan" {{ old('type', $villageData->type) == 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                        </select>
                        @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Deskripsi singkat tentang data ini">{{ old('description', $villageData->description) }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="icon" class="form-label fw-bold">Ikon</label>
                        <input type="text" class="form-control @error('icon') is-invalid @enderror" id="icon" name="icon" value="{{ old('icon', $villageData->icon) }}" placeholder="Contoh: fas fa-users">
                        @error('icon')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Gunakan kelas Font Awesome, contoh: fas fa-users, fas fa-home, fas fa-chart-bar</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="sort_order" class="form-label fw-bold">Urutan Tampilan</label>
                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', $villageData->sort_order) }}" min="0" placeholder="1">
                        @error('sort_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Angka yang lebih kecil akan ditampilkan lebih dahulu</div>
                    </div>
                    
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Data
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

@push('scripts')
<script>
// Auto refresh CSRF token every 30 minutes to prevent expiration
setInterval(function() {
    fetch('{{ route("admin.dashboard") }}', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        // Extract new CSRF token from response
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newToken = doc.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        if (newToken) {
            // Update all CSRF token inputs
            document.querySelectorAll('input[name="_token"]').forEach(input => {
                input.value = newToken;
            });
            
            // Update meta tag
            document.querySelector('meta[name="csrf-token"]')?.setAttribute('content', newToken);
            
            console.log('CSRF token refreshed successfully');
        }
    })
    .catch(error => {
        console.warn('Failed to refresh CSRF token:', error);
    });
}, 30 * 60 * 1000); // Refresh every 30 minutes

// Show warning when session is about to expire
let sessionTimeout = {{ config('session.lifetime') }} * 60 * 1000; // Convert minutes to milliseconds
let warningTime = sessionTimeout - (5 * 60 * 1000); // Warn 5 minutes before expiry

setTimeout(function() {
    if (confirm('Session Anda akan berakhir dalam 5 menit. Klik OK untuk memperpanjang session.')) {
        // Refresh page to extend session
        window.location.reload();
    }
}, warningTime);
</script>
@endpush
@endsection
