@extends('layouts.admin')

@section('title', isset($announcement) ? 'Edit Pengumuman' : 'Tambah Pengumuman')
@section('page-title', isset($announcement) ? 'Edit Pengumuman' : 'Tambah Pengumuman')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">{{ isset($announcement) ? 'Edit Pengumuman' : 'Tambah Pengumuman' }}</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ isset($announcement) ? route('admin.announcements.update', $announcement) : route('admin.announcements.store') }}">
                    @csrf
                    @if(isset($announcement))
                        @method('PUT')
                    @endif
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul *</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $announcement->title ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Isi Pengumuman *</label>
                        <textarea class="form-control" id="content" name="content" rows="5" required>{{ old('content', $announcement->content ?? '') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="priority" class="form-label">Prioritas *</label>
                        <select class="form-select" id="priority" name="priority" required>
                            <option value="low" {{ old('priority', $announcement->priority ?? '') == 'low' ? 'selected' : '' }}>Rendah</option>
                            <option value="medium" {{ old('priority', $announcement->priority ?? '') == 'medium' ? 'selected' : '' }}>Sedang</option>
                            <option value="high" {{ old('priority', $announcement->priority ?? '') == 'high' ? 'selected' : '' }}>Tinggi</option>
                            <option value="urgent" {{ old('priority', $announcement->priority ?? '') == 'urgent' ? 'selected' : '' }}>Mendesak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="valid_until" class="form-label">Berlaku Sampai</label>
                        <input type="date" class="form-control" id="valid_until" name="valid_until" value="{{ old('valid_until', isset($announcement->valid_until) ? \Carbon\Carbon::parse($announcement->valid_until)->format('Y-m-d') : '') }}">
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active" {{ old('status', $announcement->status ?? '') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ old('status', $announcement->status ?? '') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">{{ isset($announcement) ? 'Update' : 'Simpan' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
