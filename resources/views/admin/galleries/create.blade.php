@extends('layouts.admin')

@section('title', 'Tambah Galeri')
@section('page-title', 'Tambah Galeri')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Tambah Galeri</h5>
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
                
                <form method="POST" action="{{ route('admin.galleries.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul *</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori *</label>
                        <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                            <option value="">Pilih Kategori</option>
                            <option value="foto" {{ old('category') == 'foto' ? 'selected' : '' }}>Foto</option>
                            <option value="video" {{ old('category') == 'video' ? 'selected' : '' }}>Video</option>
                        </select>
                        @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">File (Foto/Video) *</label>
                        <input type="file" class="form-control @error('file') is-invalid @enderror" 
                               id="file" name="file" accept="image/*,video/*" required>
                        @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Format yang didukung: JPG, JPEG, PNG untuk foto | MP4, MOV, AVI untuk video. 
                            Maksimal ukuran file: 20MB.
                        </div>
                        
                        <!-- File Preview -->
                        <div id="filePreview" class="mt-3" style="display: none;">
                            <div class="border rounded p-3 bg-light">
                                <h6>Preview:</h6>
                                <img id="imagePreview" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px; display: none;">
                                <video id="videoPreview" controls class="img-fluid rounded" style="max-height: 200px; display: none;"></video>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan
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
                    // Auto set category to foto if image selected
                    if (categorySelect.value === '') {
                        categorySelect.value = 'foto';
                    }
                } else if (fileType.startsWith('video/')) {
                    showVideoPreview(e.target.result);
                    // Auto set category to video if video selected
                    if (categorySelect.value === '') {
                        categorySelect.value = 'video';
                    }
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
