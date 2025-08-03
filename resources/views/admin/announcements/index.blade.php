@extends('layouts.admin')

@section('title', 'Kelola Pengumuman')
@section('page-title', 'Kelola Pengumuman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Kelola Pengumuman</h1>
        <p class="text-muted">Kelola pengumuman resmi desa</p>
    </div>
    <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Pengumuman
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Status</th>
                        <th>Prioritas</th>
                        <th>Berlaku Sampai</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($announcements as $announcement)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $announcement->title }}</td>
                        <td>
                            <span class="badge bg-{{ $announcement->status == 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($announcement->status) }}
                            </span>
                        </td>
                        <td><span class="badge bg-info">{{ ucfirst($announcement->priority) }}</span></td>
                        <td>{{ $announcement->valid_until ? \Carbon\Carbon::parse($announcement->valid_until)->format('d/m/Y') : '-' }}</td>
                        <td>{{ $announcement->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('admin.announcements.edit', $announcement) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus pengumuman?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada pengumuman</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $announcements->links() }}
        </div>
    </div>
</div>
@endsection
