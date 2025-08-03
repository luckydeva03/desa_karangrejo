@extends('layouts.admin')

@section('title', 'Edit Galeri')
@section('page-title', 'Edit Galeri')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit Galeri</h5>
                <a href="{{ route('admin.galleries.index') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Kembali
                </a>
            </div>
            <div class="card-body">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <form method="POST" action="{{ route('admin.galleries.update', $gallery) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul *</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $gallery->title) }}" required>
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori *</label>
                        <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                            <option value="">Pilih Kategori</option>
                            <option value="foto" {{ old('category', $gallery->category) == 'foto' ? 'selected' : '' }}>Foto</option>
                            <option value="video" {{ old('category', $gallery->category) == 'video' ? 'selected' : '' }}>Video</option>
                        </select>
                        @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="active" {{ old('status', $gallery->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ old('status', $gallery->status) == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Current Files Display -->
                    @if(!empty($gallery->images) && is_array($gallery->images))
                    <div class="mb-3">
                        <label class="form-label fw-bold">File Saat Ini</label>
                        <div class="border rounded p-3 bg-light">
                            @foreach($gallery->images as $index => $image)
                            <div class="d-inline-block me-3 mb-2">
                                @if($gallery->type === 'photo')
                                <img src="{{ asset('storage/' . $image) }}" alt="Current image {{ $index + 1 }}" 
                                     class="img-thumbnail" style="max-height: 150px;">
                                @else
                                <video controls class="img-thumbnail" style="max-height: 150px;">
                                    <source src="{{ asset('storage/' . $image) }}" type="video/mp4">
                                    Browser Anda tidak mendukung tag video.
                                </video>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <div class="mb-3">
                        <label for="file" class="form-label">
                            {{ !empty($gallery->images) ? 'Ganti File (Foto/Video)' : 'File (Foto/Video)' }}
                        </label>
                        <input type="file" class="form-control @error('file') is-invalid @enderror" 
                               id="file" name="file" accept="image/*,video/*">
                        @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Format yang didukung: JPG, JPEG, PNG untuk foto | MP4, MOV, AVI untuk video. 
                            Maksimal ukuran file: 20MB. {{ !empty($gallery->images) ? 'Kosongkan jika tidak ingin mengubah file.' : '' }}
                        </div>
                        
                        <!-- File Preview -->
                        <div id="filePreview" class="mt-3" style="display: none;">
                            <div class="border rounded p-3 bg-light">
                                <h6>Preview File Baru:</h6>
                                <img id="imagePreview" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px; display: none;">
                                <video id="videoPreview" controls class="img-fluid rounded" style="max-height: 200px; display: none;"></video>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description', $gallery->description) }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('file');
    const filePreview = document.getElementById('filePreview');
    const imagePreview = document.getElementById('imagePreview');
    const videoPreview = document.getElementById('videoPreview');
    const categorySelect = document.getElementById('category');
    
    // File preview functionality
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Check file size (20MB = 20 * 1024 * 1024 bytes)
            if (file.size > 20 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 20MB.');
                this.value = '';
                hidePreview();
                return;
            }
            
            const fileType = file.type;
            const reader = new FileReader();
            
            reader.onload = function(e) {
                if (fileType.startsWith('image/')) {
                    showImagePreview(e.target.result);
                } else if (fileType.startsWith('video/')) {
                    showVideoPreview(e.target.result);
                }
            };
            
            reader.readAsDataURL(file);
        } else {
            hidePreview();
        }
    });
    
    function showImagePreview(src) {
        imagePreview.src = src;
        imagePreview.style.display = 'block';
        videoPreview.style.display = 'none';
        filePreview.style.display = 'block';
    }
    
    function showVideoPreview(src) {
        videoPreview.src = src;
        videoPreview.style.display = 'block';
        imagePreview.style.display = 'none';
        filePreview.style.display = 'block';
    }
    
    function hidePreview() {
        filePreview.style.display = 'none';
        imagePreview.src = '';
        videoPreview.src = '';
    }
    
    // Category change validation
    categorySelect.addEventListener('change', function() {
        const file = fileInput.files[0];
        if (file) {
            const fileType = file.type;
            const category = this.value;
            
            if (category === 'foto' && !fileType.startsWith('image/')) {
                alert('File yang dipilih harus berupa gambar untuk kategori Foto.');
                fileInput.value = '';
                hidePreview();
            } else if (category === 'video' && !fileType.startsWith('video/')) {
                alert('File yang dipilih harus berupa video untuk kategori Video.');
                fileInput.value = '';
                hidePreview();
            }
        }
    });
});
</script>
@endpush
