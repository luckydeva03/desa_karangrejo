@extends('layouts.admin')

@section('title', 'Kelola Berita')
@section('page-title', 'Kelola Berita')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Kelola Berita</h1>
        <p class="text-muted">Kelola semua berita dan artikel desa</p>
    </div>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Berita
    </a>
</div>

<!-- Filter Card -->
<div class="card shadow mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.posts.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Cari berita..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Posts Table -->
<div class="card shadow">
    <div class="card-header">
        <h6 class="m-0 fw-bold text-primary">Daftar Berita ({{ $posts->total() }} total)</h6>
    </div>
    <div class="card-body">
        @if($posts->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="40%">Judul</th>
                        <th width="15%">Kategori</th>
                        <th width="10%">Status</th>
                        <th width="10%">Views</th>
                        <th width="10%">Tanggal</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                    <tr>
                        <td>{{ $loop->iteration + ($posts->currentPage() - 1) * $posts->perPage() }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($post->featured_image)
                                <img src="{{ $post->featured_image_url }}" alt="Thumbnail" class="rounded me-3" width="60" height="40" style="object-fit: cover;">
                                @endif
                                <div>
                                    <h6 class="mb-1">{{ $post->title }}</h6>
                                    <small class="text-muted">{{ Str::limit($post->excerpt, 80) }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $post->category->name }}</span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $post->status === 'published' ? 'success' : 'warning' }}">
                                {{ ucfirst($post->status) }}
                            </span>
                        </td>
                        <td>
                            <i class="fas fa-eye text-muted me-1"></i>{{ $post->views }}
                        </td>
                        <td>
                            <small>{{ $post->created_at->format('d M Y') }}</small>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('posts.show', $post) }}" target="_blank" class="btn btn-outline-info" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-outline-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger" onclick="deletePost('{{ $post->slug }}')" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $posts->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
            <h5>Belum ada berita</h5>
            <p class="text-muted">Mulai dengan menambahkan berita pertama</p>
            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Berita
            </a>
        </div>
        @endif
    </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus berita ini? Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
    </div>
    @endsection

    @push('scripts')
    <script>
    function deletePost(slug) {
        const form = document.getElementById('deleteForm');
        // Menggunakan route helper Laravel dengan slug
        const deleteUrl = "{{ route('admin.posts.destroy', ['post' => 'POST_SLUG']) }}".replace('POST_SLUG', slug);
        form.action = deleteUrl;
        
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
    </script>
    @endpush