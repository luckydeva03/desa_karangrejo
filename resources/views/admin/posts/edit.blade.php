@extends('layouts.admin')

@section('title', 'Edit Berita')
@section('page-title', 'Edit Berita')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-primary">Form Edit Berita</h6>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Kembali
                </a>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-lg-8">
                            <!-- Title -->
                            <div class="mb-3">
                                <label for="title" class="form-label fw-bold">Judul Berita *</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title', $post->title) }}" required>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Content -->
                            <div class="mb-3">
                                <label for="content" class="form-label fw-bold">Isi Berita *</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" 
                                          id="content" name="content" rows="15" required>{{ old('content', $post->content) }}</textarea>
                                @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Excerpt -->
                            <div class="mb-3">
                                <label for="excerpt" class="form-label fw-bold">Ringkasan (Opsional)</label>
                                <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                          id="excerpt" name="excerpt" rows="3" placeholder="Jika kosong, akan dibuat otomatis dari isi berita...">{{ old('excerpt', $post->excerpt) }}</textarea>
                                @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Maksimal 300 karakter. Akan muncul sebagai preview di halaman daftar berita.</div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <!-- Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label fw-bold">Status *</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Published</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Category -->
                            <div class="mb-3">
                                <label for="category_id" class="form-label fw-bold">Kategori *</label>
                                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Current Featured Image -->
                            @if($post->featured_image)
                            <div class="mb-3">
                                <label class="form-label fw-bold">Gambar Unggulan Saat Ini</label>
                                <div class="border rounded p-2">
                                    <img src="{{ Storage::url($post->featured_image) }}" alt="Current featured image" 
                                         class="img-fluid rounded" style="max-height: 150px;">
                                </div>
                            </div>
                            @endif
                            
                            <!-- Featured Image -->
                            <div class="mb-3">
                                <label for="featured_image" class="form-label fw-bold">
                                    {{ $post->featured_image ? 'Ganti Gambar Unggulan' : 'Gambar Unggulan' }}
                                </label>
                                <input type="file" class="form-control @error('featured_image') is-invalid @enderror" 
                                       id="featured_image" name="featured_image" accept="image/*">
                                @error('featured_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Format: JPG, PNG, GIF. Maksimal 10MB. {{ $post->featured_image ? 'Kosongkan jika tidak ingin mengubah.' : '' }}</div>
                                
                                <!-- Image Preview -->
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <img id="preview" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                                </div>
                            </div>
                            
                            <!-- Published Date -->
                            <div class="mb-3" id="publishedDateField" style="display: none;">
                                <label for="published_at" class="form-label fw-bold">Tanggal Publikasi</label>
                                <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" 
                                       id="published_at" name="published_at" 
                                       value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}">
                                @error('published_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Kosongkan untuk menggunakan waktu sekarang.</div>
                            </div>
                            
                            <!-- Submit Buttons -->
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update Berita
                                </button>
                                <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
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
    // Inisialisasi Summernote
    $('#content').summernote({
        height: 400,
        placeholder: 'Tulis isi berita di sini...',
        codemirror: {
            theme: 'monokai'
        },
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ],
        callbacks: {
            onImageUpload: function(files) {
                let data = new FormData();
                data.append('file', files[0]);
                $.ajax({
                    url: '{{ route('admin.posts.upload-image') }}',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: data,
                    type: 'POST',
                    success: function(response) {
                        if(response.location) {
                            $('#content').summernote('insertImage', response.location);
                        }
                    },
                    error: function(xhr) {
                        alert('Gagal upload gambar');
                    }
                });
            }
        }
    });
    
    // Show/hide published date field based on status
    const statusSelect = document.getElementById('status');
    const publishedDateField = document.getElementById('publishedDateField');
    
    function togglePublishedDate() {
        if (statusSelect.value === 'published') {
            publishedDateField.style.display = 'block';
        } else {
            publishedDateField.style.display = 'none';
        }
    }
    
    statusSelect.addEventListener('change', togglePublishedDate);
    togglePublishedDate(); // Initial check
    
    // Image preview
    const imageInput = document.getElementById('featured_image');
    const imagePreview = document.getElementById('imagePreview');
    const preview = document.getElementById('preview');
    
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.style.display = 'none';
        }
    });
    
    // Auto-generate excerpt from content (Summernote version)
    const excerptField = document.getElementById('excerpt');
    function updateExcerpt() {
        if (!excerptField.value.trim()) {
            const content = $('#content').summernote('code');
            // Remove HTML tags for plain text
            const div = document.createElement('div');
            div.innerHTML = content;
            const text = div.textContent || div.innerText || '';
            const excerpt = text.substring(0, 160).trim();
            if (excerpt) {
                excerptField.value = excerpt + (text.length > 160 ? '...' : '');
            }
        }
    }
    // Update excerpt when content changes (with debounce)
    let excerptTimeout;
    $('#content').on('summernote.change', function() {
        clearTimeout(excerptTimeout);
        excerptTimeout = setTimeout(updateExcerpt, 1000);
    });
});
</script>
@endpush
