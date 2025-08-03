@extends('layouts.admin')

@section('title', 'Edit Halaman')
@section('page-title', 'Edit Halaman')

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
.member-card {
    transition: all 0.3s ease;
}
.member-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.member-avatar {
    width: 50px;
    height: 50px;
    object-fit: cover;
}
.member-initials {
    width: 50px;
    height: 50px;
    font-size: 18px;
    font-weight: bold;
}
.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-primary">Form Edit Halaman</h6>
                <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Kembali
                </a>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.pages.update', $page) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-lg-8">
                            <!-- Title -->
                            <div class="mb-3">
                                <label for="title" class="form-label fw-bold">Judul Halaman *</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title', $page->title) }}" required>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Content based on page type -->
                            @if($page->type === 'vision_mission')
                                <!-- Vision Text -->
                                <div class="mb-3">
                                    <label for="vision_text" class="form-label fw-bold">
                                        <i class="fas fa-eye me-2"></i>Teks Visi *
                                    </label>
                                    <textarea class="form-control @error('vision_text') is-invalid @enderror" 
                                              id="vision_text" name="vision_text" rows="6" required
                                              placeholder="Masukkan visi desa...">{{ old('vision_text', $page->vision_text ?? '') }}</textarea>
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
                                              id="mission_text" name="mission_text" rows="8" required
                                              placeholder="Masukkan misi desa (bisa berupa poin-poin atau paragraf)...">{{ old('mission_text', $page->mission_text ?? '') }}</textarea>
                                    @error('mission_text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Tuliskan misi desa yang konkret dan dapat diukur. Gunakan poin-poin untuk kemudahan pembacaan.</div>
                                </div>
                                
                                <!-- Additional Content (Optional) -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label for="content" class="form-label fw-bold mb-0">
                                            <i class="fas fa-file-text me-2"></i>Konten Tambahan
                                        </label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="toggleAdditionalContent" 
                                                   {{ old('content', $page->content) ? 'checked' : '' }}>
                                            <label class="form-check-label text-muted small" for="toggleAdditionalContent">
                                                Aktifkan konten tambahan
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div id="additionalContentSection" style="display: {{ old('content', $page->content) ? 'block' : 'none' }};">
                                        <div class="alert alert-light small mb-2">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <strong>Opsional:</strong> Gunakan bagian ini untuk menambahkan penjelasan latar belakang, 
                                            tujuan, atau informasi pendukung lainnya yang tidak termasuk dalam visi dan misi utama.
                                        </div>
                                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                                  id="content" name="content" rows="6"
                                                  placeholder="Tambahkan penjelasan, latar belakang, atau informasi pendukung lainnya...">{{ old('content', $page->content) }}</textarea>
                                        @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Konten tambahan seperti penjelasan latar belakang, tujuan, atau informasi pendukung.</div>
                                    </div>
                                </div>
                            @elseif($page->type !== 'organization_structure')
                                <!-- Regular Content for other page types (except organization_structure) -->
                                <div class="mb-3">
                                    <label for="content" class="form-label fw-bold">Isi Halaman *</label>
                                    <textarea class="form-control @error('content') is-invalid @enderror" 
                                              id="content" name="content" rows="15" required>{{ old('content', $page->content) }}</textarea>
                                    @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                            
                            <!-- Organizational Members Section (only for organization structure pages) -->
                            @if($page->type === 'organization_structure')
                            <div class="mb-4">
                                <div class="card bg-light">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 fw-bold text-dark">
                                            <i class="fas fa-users me-2"></i>Anggota Organisasi
                                        </h6>
                                        <a href="{{ route('admin.pages.organizational-members.create', $page) }}" 
                                           class="btn btn-success btn-sm">
                                            <i class="fas fa-plus me-1"></i>Tambah Anggota
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        @if($page->organizationalMembers->count() > 0)
                                            <div class="row">
                                                @foreach($page->organizationalMembers->sortBy('sort_order') as $member)
                                                <div class="col-md-6 col-lg-4 mb-3">
                                                    <div class="card border {{ $member->status === 'active' ? 'border-success' : 'border-secondary' }}">
                                                        <div class="card-body p-3">
                                                            <div class="d-flex align-items-center mb-2">
                                                                @if($member->photo)
                                                                    <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" 
                                                                         class="rounded-circle me-3" width="50" height="50" style="object-fit: cover;">
                                                                @else
                                                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" 
                                                                         style="width: 50px; height: 50px; font-size: 18px; font-weight: bold;">
                                                                        {{ $member->getInitials() }}
                                                                    </div>
                                                                @endif
                                                                <div class="flex-grow-1">
                                                                    <h6 class="mb-1 fw-bold">{{ $member->name }}</h6>
                                                                    <small class="text-muted">{{ $member->position }}</small>
                                                                </div>
                                                            </div>
                                                            
                                                            @if($member->department)
                                                            <div class="mb-2">
                                                                <small class="text-info">
                                                                    <i class="fas fa-building me-1"></i>{{ $member->department }}
                                                                </small>
                                                            </div>
                                                            @endif
                                                            
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div>
                                                                    @if($member->status === 'active')
                                                                        <span class="badge bg-success">Aktif</span>
                                                                    @else
                                                                        <span class="badge bg-secondary">Nonaktif</span>
                                                                    @endif
                                                                    <small class="text-muted ms-1">#{{ $member->sort_order }}</small>
                                                                </div>
                                                                <div class="btn-group btn-group-sm">
                                                                    <a href="{{ route('admin.pages.organizational-members.show', [$page, $member]) }}" 
                                                                       class="btn btn-outline-info btn-sm" title="Lihat Detail">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                    <a href="{{ route('admin.pages.organizational-members.edit', [$page, $member]) }}" 
                                                                       class="btn btn-outline-warning btn-sm" title="Edit">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                    <button type="button" class="btn btn-outline-danger btn-sm" 
                                                                            onclick="deleteMember('{{ route('admin.pages.organizational-members.destroy', [$page, $member]) }}', '{{ $member->name }}')" title="Hapus">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            
                                            <div class="text-center mt-3">
                                                <a href="{{ route('admin.pages.organizational-members.index', $page) }}" 
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-list me-1"></i>Kelola Semua Anggota ({{ $page->organizationalMembers->count() }})
                                                </a>
                                            </div>
                                        @else
                                            <div class="text-center py-4">
                                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                                <h6 class="text-muted">Belum ada anggota organisasi</h6>
                                                <p class="text-muted small mb-3">Mulai bangun struktur organisasi dengan menambah anggota pertama</p>
                                                <a href="{{ route('admin.pages.organizational-members.create', $page) }}" 
                                                   class="btn btn-success">
                                                    <i class="fas fa-plus me-2"></i>Tambah Anggota Pertama
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            <!-- Meta Title -->
                            <div class="mb-3">
                                <label for="meta_title" class="form-label fw-bold">Meta Title (SEO)</label>
                                <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                       id="meta_title" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}" placeholder="Akan otomatis menggunakan judul halaman jika kosong">
                                @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Meta Description -->
                            <div class="mb-3">
                                <label for="meta_description" class="form-label fw-bold">Meta Description (SEO)</label>
                                <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                          id="meta_description" name="meta_description" rows="3" placeholder="Deskripsi singkat untuk SEO (maksimal 300 karakter)">{{ old('meta_description', $page->meta_description) }}</textarea>
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
                                    <option value="{{ $key }}" {{ old('type', $page->type) == $key ? 'selected' : '' }}>
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
                                    <option value="active" {{ old('status', $page->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $page->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Current Featured Image (not for organization_structure) -->
                            @if($page->featured_image && $page->type !== 'organization_structure')
                            <div class="mb-3">
                                <label class="form-label fw-bold">Gambar Unggulan Saat Ini</label>
                                <div class="border rounded p-2">
                                    <img src="{{ $page->featured_image_url }}" alt="Current featured image" 
                                         class="img-fluid rounded" style="max-height: 150px;">
                                </div>
                            </div>
                            @endif
                            
                            <!-- Featured Image (not for organization_structure) -->
                            @if($page->type !== 'organization_structure')
                            <div class="mb-3">
                                <label for="featured_image" class="form-label fw-bold">
                                    {{ $page->featured_image ? 'Ganti Gambar Unggulan' : 'Gambar Unggulan' }}
                                </label>
                                <input type="file" class="form-control @error('featured_image') is-invalid @enderror" 
                                       id="featured_image" name="featured_image" accept="image/*">
                                @error('featured_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Format: JPG, PNG, GIF. Maksimal 10MB. {{ $page->featured_image ? 'Kosongkan jika tidak ingin mengubah.' : '' }}</div>
                                
                                <!-- Image Preview -->
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <img id="preview" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                                </div>
                            </div>
                            @endif
                            
                            <!-- Submit Buttons -->
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update Halaman
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
$(function() {
    // Inisialisasi Summernote untuk regular content (non-vision_mission and non-organization_structure pages)
    if ($('#content').length && !$('#vision_text').length && '{{ $page->type }}' !== 'organization_structure') {
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
    }
    
    // Inisialisasi Summernote untuk additional content pada vision_mission (jika sudah ada content)
    if ($('#content').length && $('#vision_text').length && $('#content').val().trim() !== '') {
        $('#content').summernote({
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
    
    // Summernote untuk vision text
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
    
    // Summernote untuk mission text dengan fokus pada list/poin-poin
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
        ],
        callbacks: {
            onInit: function() {
                // Set default styling untuk lists
                var editable = this.layoutInfo.editable;
                editable.on('keydown', function(e) {
                    if (e.which === 13) { // Enter key
                        setTimeout(function() {
                            var selection = window.getSelection();
                            if (selection.rangeCount > 0) {
                                var range = selection.getRangeAt(0);
                                var parent = range.commonAncestorContainer.parentElement;
                                if (parent.tagName === 'LI') {
                                    // Tambahkan styling untuk list items
                                    $(parent).css({
                                        'margin-bottom': '8px',
                                        'line-height': '1.5'
                                    });
                                }
                            }
                        }, 10);
                    }
                });
            }
        }
    });
    
    // Image preview (only for non-organization_structure pages)
    const imageInput = document.getElementById('featured_image');
    const imagePreview = document.getElementById('imagePreview');
    const preview = document.getElementById('preview');
    
    if (imageInput && '{{ $page->type }}' !== 'organization_structure') {
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
    }
    
    // Auto-generate meta title from title
    const titleField = document.getElementById('title');
    const metaTitleField = document.getElementById('meta_title');
    
    if (titleField && metaTitleField) {
        titleField.addEventListener('input', function() {
            if (!metaTitleField.value.trim()) {
                metaTitleField.value = this.value;
            }
        });
    }
    
    // Toggle additional content section
    const toggleAdditionalContent = document.getElementById('toggleAdditionalContent');
    const additionalContentSection = document.getElementById('additionalContentSection');
    const additionalContentTextarea = document.getElementById('content');
    
    if (toggleAdditionalContent && additionalContentSection) {
        toggleAdditionalContent.addEventListener('change', function() {
            if (this.checked) {
                additionalContentSection.style.display = 'block';
                // Initialize Summernote when shown
                if (!$('#content').hasClass('note-editable')) {
                    $('#content').summernote({
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
            } else {
                additionalContentSection.style.display = 'none';
                // Clear content when hidden - destroy summernote first, then clear value
                if ($('#content').hasClass('note-editable')) {
                    $('#content').summernote('destroy');
                }
                if (additionalContentTextarea) {
                    additionalContentTextarea.value = '';
                }
            }
        });
    }
    
    // Function to delete organizational member
    window.deleteMember = function(deleteUrl, memberName) {
        console.log('deleteMember called with:', {
            deleteUrl: deleteUrl,
            memberName: memberName
        });
        
        if (confirm(`Apakah Anda yakin ingin menghapus anggota "${memberName}"?\n\nData yang akan dihapus:\n- Profil anggota\n- Foto profil\n- Semua informasi terkait\n\nTindakan ini tidak dapat dibatalkan.`)) {
            console.log('User confirmed deletion');
            
            // Create and submit delete form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = deleteUrl;
            
            console.log('Form created with action:', form.action);
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            
            form.appendChild(csrfToken);
            form.appendChild(methodField);
            document.body.appendChild(form);
            
            console.log('Form elements added:', {
                csrfToken: csrfToken.value,
                method: methodField.value,
                formHTML: form.innerHTML
            });
            
            console.log('Submitting form...');
            form.submit();
        } else {
            console.log('User cancelled deletion');
        }
    };
});
</script>
@endpush
