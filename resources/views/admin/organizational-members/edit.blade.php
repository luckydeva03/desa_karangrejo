@extends('layouts.admin')

@section('title', 'Edit Anggota Organisasi')
@section('page-title', 'Edit Anggota Organisasi')

@push('styles')
<style>
.photo-preview {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #dee2e6;
}
.photo-upload-area {
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    transition: all 0.3s ease;
}
.photo-upload-area:hover {
    border-color: #007bff;
    background-color: rgba(0, 123, 255, 0.05);
}
.initials-preview {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 3px solid #dee2e6;
    font-size: 2rem;
    font-weight: bold;
}
.current-photo {
    position: relative;
}
.remove-photo-btn {
    position: absolute;
    top: -10px;
    right: -10px;
    background: #dc3545;
    border: none;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    color: white;
    font-size: 12px;
}
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-primary">Form Edit Anggota Organisasi</h6>
                <div>
                    <a href="{{ route('admin.pages.organizational-members.show', [$page, $organizational_member->id]) }}" class="btn btn-info btn-sm me-2">
                        <i class="fas fa-eye me-1"></i>Lihat Detail
                    </a>
                    <a href="{{ route('admin.pages.organizational-members.index', $page) }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.pages.organizational-members.update', [$page, $organizational_member->id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <!-- Photo Section -->
                        <div class="col-lg-4 mb-4">
                            <div class="text-center">
                                <h6 class="fw-bold mb-3">Foto Profil</h6>
                                
                                <!-- Current Photo -->
                                <div class="mb-3">
                                    @if($organizational_member->photo)
                                    <div id="currentPhoto" class="current-photo d-inline-block">
                                        <img src="{{ $organizational_member->photo_url }}" alt="{{ $organizational_member->name }}" class="photo-preview">
                                        <button type="button" class="btn remove-photo-btn" id="removePhotoBtn" title="Hapus foto">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    @endif
                                    
                                    <div id="photoPreview" class="{{ $organizational_member->photo ? 'd-none' : 'd-none' }}">
                                        <img id="previewImage" src="" alt="Preview" class="photo-preview">
                                    </div>
                                    
                                    <div id="initialsPreview" class="initials-preview bg-primary text-white d-flex align-items-center justify-content-center mx-auto {{ $organizational_member->photo ? 'd-none' : '' }}">
                                        <span id="initialsText">{{ $organizational_member->getInitials() }}</span>
                                    </div>
                                </div>
                                
                                <!-- Upload Area -->
                                <div class="photo-upload-area p-4 text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-camera fa-3x text-muted"></i>
                                    </div>
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror" 
                                           id="photo" name="photo" accept="image/*">
                                    @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text mt-2">
                                        Format: JPG, PNG. Maksimal 5MB.<br>
                                        Kosongkan jika tidak ingin mengubah foto.
                                    </div>
                                </div>
                                
                                <!-- Remove photo flag -->
                                <input type="hidden" id="removePhoto" name="remove_photo" value="0">
                            </div>
                        </div>
                        
                        <!-- Form Fields -->
                        <div class="col-lg-8">
                            <div class="row">
                                <!-- Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label fw-bold">Nama Lengkap *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $organizational_member->name) }}" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Position -->
                                <div class="col-md-6 mb-3">
                                    <label for="position" class="form-label fw-bold">Jabatan *</label>
                                    <input type="text" class="form-control @error('position') is-invalid @enderror" 
                                           id="position" name="position" value="{{ old('position', $organizational_member->position) }}" required
                                           placeholder="Contoh: Kepala Desa, Sekretaris Desa">
                                    @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Department -->
                                <div class="col-md-6 mb-3">
                                    <label for="department" class="form-label fw-bold">Bagian/Unit Kerja</label>
                                    <input type="text" class="form-control @error('department') is-invalid @enderror" 
                                           id="department" name="department" value="{{ old('department', $organizational_member->department) }}"
                                           placeholder="Contoh: Pemerintahan, Pelayanan">
                                    @error('department')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Sort Order -->
                                <div class="col-md-6 mb-3">
                                    <label for="sort_order" class="form-label fw-bold">Urutan Tampil</label>
                                    <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                           id="sort_order" name="sort_order" value="{{ old('sort_order', $organizational_member->sort_order) }}" min="0"
                                           placeholder="0">
                                    @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Nilai lebih kecil akan tampil lebih dulu. Default: 0</div>
                                </div>
                                
                                <!-- Phone -->
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label fw-bold">Nomor Telepon</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone', $organizational_member->phone) }}"
                                           placeholder="08123456789">
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Email -->
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-bold">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $organizational_member->email) }}"
                                           placeholder="nama@email.com">
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Status -->
                                <div class="col-md-12 mb-3">
                                    <label for="status" class="form-label fw-bold">Status *</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="active" {{ old('status', $organizational_member->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                        <option value="inactive" {{ old('status', $organizational_member->status) == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Description -->
                                <div class="col-md-12 mb-3">
                                    <label for="description" class="form-label fw-bold">Deskripsi/Keterangan</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="4"
                                              placeholder="Informasi tambahan tentang anggota ini...">{{ old('description', $organizational_member->description) }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Opsional: Riwayat pendidikan, pengalaman, atau informasi lainnya</div>
                                </div>
                            </div>
                            
                            <!-- Submit Buttons -->
                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('admin.pages.organizational-members.index', $page) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Perbarui Anggota
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    // Photo preview
    const photoInput = document.getElementById('photo');
    const photoPreview = document.getElementById('photoPreview');
    const previewImage = document.getElementById('previewImage');
    const initialsPreview = document.getElementById('initialsPreview');
    const initialsText = document.getElementById('initialsText');
    const nameInput = document.getElementById('name');
    const currentPhoto = document.getElementById('currentPhoto');
    const removePhotoBtn = document.getElementById('removePhotoBtn');
    const removePhotoFlag = document.getElementById('removePhoto');
    
    // Update initials when name changes
    nameInput.addEventListener('input', function() {
        updateInitials(this.value);
    });
    
    // Remove current photo
    if (removePhotoBtn) {
        removePhotoBtn.addEventListener('click', function() {
            currentPhoto.style.display = 'none';
            photoPreview.classList.add('d-none');
            initialsPreview.classList.remove('d-none');
            removePhotoFlag.value = '1';
            photoInput.value = '';
        });
    }
    
    // Photo upload preview
    photoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                photoPreview.classList.remove('d-none');
                initialsPreview.classList.add('d-none');
                if (currentPhoto) {
                    currentPhoto.style.display = 'none';
                }
                removePhotoFlag.value = '0';
            };
            reader.readAsDataURL(file);
        } else {
            photoPreview.classList.add('d-none');
            if (removePhotoFlag.value === '0') {
                if (currentPhoto) {
                    currentPhoto.style.display = 'inline-block';
                } else {
                    initialsPreview.classList.remove('d-none');
                }
            } else {
                initialsPreview.classList.remove('d-none');
            }
        }
    });
    
    function updateInitials(name) {
        if (!name.trim()) {
            initialsText.textContent = '?';
            return;
        }
        
        const words = name.trim().split(' ');
        let initials = '';
        for (let i = 0; i < Math.min(words.length, 2); i++) {
            if (words[i].length > 0) {
                initials += words[i][0].toUpperCase();
            }
        }
        initialsText.textContent = initials || '?';
    }
});
</script>
@endpush
