@extends('layouts.admin')

@section('title', 'Tambah Halaman')
@section('page-title', 'Tambah Halaman')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-primary">Form Tambah Halaman</h6>
                <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Kembali
                </a>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.pages.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-lg-8">
                            <!-- Title -->
                            <div class="mb-3">
                                <label for="title" class="form-label fw-bold">Judul Halaman *</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Content based on page type -->
                            <div id="content-section">
                                <!-- This will be dynamically updated based on page type selection -->
                                <div id="vision-mission-fields" style="display: none;">
                                    <!-- Vision Text -->
                                    <div class="mb-3">
                                        <label for="vision_text" class="form-label fw-bold">
                                            <i class="fas fa-eye me-2"></i>Teks Visi *
                                        </label>
                                        <textarea class="form-control @error('vision_text') is-invalid @enderror" 
                                                  id="vision_text" name="vision_text" rows="6"
                                                  placeholder="Masukkan visi desa...">{{ old('vision_text') }}</textarea>
                                        @error('vision_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Tuliskan visi desa dengan jelas dan inspiratif.</div>
                                    </div>
                                    
                                    <!-- Mission Text -->
                                    <div class="mb-3">
                                        <label for="mission_text" class="form-label fw-bold">
                                            <i class="fas fa-bullseye me-2"></i>Teks Misi *
                                        </label>
                                        <div class="alert alert-info small mb-2">
                                            <i class="fas fa-lightbulb me-2"></i>
                                            <strong>Tips:</strong> Gunakan <kbd>Ctrl+Shift+8</kbd> untuk bullet points (•) atau <kbd>Ctrl+Shift+7</kbd> untuk numbering (1,2,3). 
                                            Klik tombol <i class="fas fa-list-ul"></i> untuk bullet atau <i class="fas fa-list-ol"></i> untuk numbering di toolbar.
                                        </div>
                                        <textarea class="form-control @error('mission_text') is-invalid @enderror" 
                                                  id="mission_text" name="mission_text" rows="8"
                                                  placeholder="Masukkan misi desa (bisa berupa poin-poin atau paragraf)...">{{ old('mission_text') }}</textarea>
                                        @error('mission_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Tuliskan misi desa yang konkret dan dapat diukur. Gunakan poin-poin untuk kemudahan pembacaan.</div>
                                    </div>
                                    
                                    <!-- Additional Content (Optional) -->
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label for="additional_content" class="form-label fw-bold mb-0">
                                                <i class="fas fa-file-text me-2"></i>Konten Tambahan
                                            </label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="toggleAdditionalContent">
                                                <label class="form-check-label text-muted small" for="toggleAdditionalContent">
                                                    Aktifkan konten tambahan
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div id="additionalContentSection" style="display: none;">
                                            <div class="alert alert-light small mb-2">
                                                <i class="fas fa-info-circle me-2"></i>
                                                <strong>Opsional:</strong> Gunakan bagian ini untuk menambahkan penjelasan latar belakang, 
                                                tujuan, atau informasi pendukung lainnya yang tidak termasuk dalam visi dan misi utama.
                                            </div>
                                            <textarea class="form-control" 
                                                      id="additional_content" name="additional_content" rows="6"
                                                      placeholder="Tambahkan penjelasan, latar belakang, atau informasi pendukung lainnya...">{{ old('additional_content') }}</textarea>
                                            <div class="form-text">Konten tambahan seperti penjelasan latar belakang, tujuan, atau informasi pendukung.</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Regular Content for other page types (except organization_structure) -->
                                <div id="regular-content-field">
                                    <div class="mb-3">
                                        <label for="content" class="form-label fw-bold">Isi Halaman *</label>
                                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                                  id="content" name="content" rows="15" required>{{ old('content') }}</textarea>
                                        @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Organization Structure Message -->
                                <div id="organization-structure-message" style="display: none;">
                                    <div class="alert alert-info">
                                        <i class="fas fa-users me-2"></i>
                                        <strong>Halaman Struktur Organisasi</strong><br>
                                        Setelah halaman ini disimpan, Anda dapat menambahkan anggota organisasi melalui menu pengelolaan anggota.
                                        Halaman ini tidak memerlukan isi konten karena akan menampilkan struktur organisasi berdasarkan anggota yang ditambahkan.
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Meta Title -->
                            <div class="mb-3">
                                <label for="meta_title" class="form-label fw-bold">Meta Title (SEO)</label>
                                <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                       id="meta_title" name="meta_title" value="{{ old('meta_title') }}" placeholder="Akan otomatis menggunakan judul halaman jika kosong">
                                @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Meta Description -->
                            <div class="mb-3">
                                <label for="meta_description" class="form-label fw-bold">Meta Description (SEO)</label>
                                <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                          id="meta_description" name="meta_description" rows="3" placeholder="Deskripsi singkat untuk SEO (maksimal 300 karakter)">{{ old('meta_description') }}</textarea>
                                @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Maksimal 300 karakter. Akan muncul di hasil pencarian Google.</div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <!-- Type -->
                            <div class="mb-3">
                                <label for="type" class="form-label fw-bold">Tipe Halaman *</label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                    <option value="">Pilih Tipe Halaman</option>
                                    @foreach($pageTypes as $key => $label)
                                    <option value="{{ $key }}" {{ (old('type') ?: $selectedType) == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Tentukan jenis halaman ini.</div>
                            </div>
                            
                            <!-- Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label fw-bold">Status *</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Featured Image (not for organization_structure) -->
                            <div class="mb-3" id="featured-image-field">
                                <label for="featured_image" class="form-label fw-bold">Gambar Unggulan</label>
                                <input type="file" class="form-control @error('featured_image') is-invalid @enderror" 
                                       id="featured_image" name="featured_image" accept="image/*">
                                @error('featured_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Format: JPG, PNG, GIF. Maksimal 10MB.</div>
                                
                                <!-- Image Preview -->
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <img id="preview" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                                </div>
                            </div>
                            
                            <!-- Submit Buttons -->
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan Halaman
                                </button>
                                <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">
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

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<style>
.note-editor .note-editing-area .note-editable[contenteditable="true"] ul li {
    margin-bottom: 8px;
    line-height: 1.6;
}
.note-editor .note-editing-area .note-editable[contenteditable="true"] ol li {
    margin-bottom: 8px;
    line-height: 1.6;
}
.alert-info kbd {
    background-color: #495057;
    color: #fff;
    padding: 2px 4px;
    border-radius: 3px;
    font-size: 0.875em;
}
.form-check-input:checked {
    background-color: #198754;
    border-color: #198754;
}
.form-check-input:focus {
    border-color: #86b7fe;
    outline: 0;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}
#additionalContentSection {
    transition: all 0.3s ease-in-out;
}
.alert-light {
    background-color: #f8f9fa;
    border-color: #dee2e6;
    color: #495057;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
$(function() {
    // Inisialisasi Summernote untuk content regular (akan diatur berdasarkan tipe halaman)
    let contentSummernoteInitialized = false;
    
    function initContentSummernote() {
        if (!contentSummernoteInitialized && document.getElementById('content').style.display !== 'none') {
            $('#content').summernote({
                height: 400,
                placeholder: 'Tulis isi halaman di sini...',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
            contentSummernoteInitialized = true;
        }
    }
    
    function destroyContentSummernote() {
        if (contentSummernoteInitialized) {
            $('#content').summernote('destroy');
            contentSummernoteInitialized = false;
        }
    }
    
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
    
    // Auto-generate meta title from title
    const titleField = document.getElementById('title');
    const metaTitleField = document.getElementById('meta_title');
    
    titleField.addEventListener('input', function() {
        if (!metaTitleField.value.trim()) {
            metaTitleField.value = this.value;
        }
    });
    
    // Toggle content fields based on page type
    const typeSelect = document.getElementById('type');
    const visionMissionFields = document.getElementById('vision-mission-fields');
    const regularContentField = document.getElementById('regular-content-field');
    const organizationStructureMessage = document.getElementById('organization-structure-message');
    const featuredImageField = document.getElementById('featured-image-field');
    
    function toggleContentFields() {
        const selectedType = typeSelect.value;
        
        if (selectedType === 'vision_mission') {
            visionMissionFields.style.display = 'block';
            regularContentField.style.display = 'none';
            organizationStructureMessage.style.display = 'none';
            featuredImageField.style.display = 'block';
            
            // Destroy content summernote since it's hidden
            destroyContentSummernote();
            
            // Make vision and mission fields required
            document.getElementById('vision_text').required = true;
            document.getElementById('mission_text').required = true;
            document.getElementById('content').required = false;
        } else if (selectedType === 'organization_structure') {
            visionMissionFields.style.display = 'none';
            regularContentField.style.display = 'none';
            organizationStructureMessage.style.display = 'block';
            featuredImageField.style.display = 'none';
            
            // Destroy content summernote since it's hidden
            destroyContentSummernote();
            
            // No content fields required for organization structure
            document.getElementById('vision_text').required = false;
            document.getElementById('mission_text').required = false;
            document.getElementById('content').required = false;
            document.getElementById('featured_image').required = false;
        } else {
            visionMissionFields.style.display = 'none';
            regularContentField.style.display = 'block';
            organizationStructureMessage.style.display = 'none';
            featuredImageField.style.display = 'block';
            
            // Initialize content summernote since it's visible
            setTimeout(initContentSummernote, 100);
            
            // Make regular content field required
            document.getElementById('vision_text').required = false;
            document.getElementById('mission_text').required = false;
            document.getElementById('content').required = true;
        }
    }
    
    // Initialize on page load
    toggleContentFields();
    
    // Toggle when type changes
    typeSelect.addEventListener('change', toggleContentFields);
});

$(document).ready(function() {
    // Initialize Summernote for vision text
    $('#vision_text').summernote({
        height: 200,
        placeholder: 'Tuliskan visi desa dengan jelas dan inspiratif...',
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview']]
        ]
    });
    
    // Initialize Summernote for mission text with focus on lists
    $('#mission_text').summernote({
        height: 300,
        placeholder: 'Tuliskan misi desa yang konkret dan dapat diukur. Gunakan bullet points atau numbering untuk membuat poin-poin...',
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview']]
        ]
    });
    
    // Initialize Summernote for additional content (will be called when toggled)
    function initAdditionalContentEditor() {
        if (!$('#additional_content').hasClass('note-editable')) {
            $('#additional_content').summernote({
                height: 250,
                placeholder: 'Tulis konten tambahan di sini...',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview']]
                ]
            });
        }
    }
    
    // Toggle additional content section
    const toggleAdditionalContent = document.getElementById('toggleAdditionalContent');
    const additionalContentSection = document.getElementById('additionalContentSection');
    
    if (toggleAdditionalContent && additionalContentSection) {
        toggleAdditionalContent.addEventListener('change', function() {
            if (this.checked) {
                additionalContentSection.style.display = 'block';
                // Initialize Summernote when shown
                setTimeout(initAdditionalContentEditor, 100);
            } else {
                additionalContentSection.style.display = 'none';
                // Clear content when hidden - destroy summernote first, then clear value
                if ($('#additional_content').hasClass('note-editable')) {
                    $('#additional_content').summernote('destroy');
                }
                document.getElementById('additional_content').value = '';
            }
        });
    }
});
</script>
@endpush
