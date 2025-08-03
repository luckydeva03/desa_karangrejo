@extends('layouts.admin')

@section('title', 'Data Desa')
@section('page-title', 'Data Desa')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Data Desa</h1>
        <p class="text-muted">Kelola data statistik dan informasi desa</p>
    </div>
    <a href="{{ route('admin.village-data.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Data
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Label</th>
                        <th>Tipe</th>
                        <th>Nilai</th>
                        <th>Deskripsi</th>
                        <th>Urutan</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($villageData as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->label }}</td>
                        <td><span class="badge bg-info">{{ ucfirst($data->type) }}</span></td>
                        <td>{{ $data->value }}</td>
                        <td>{{ $data->description ?: '-' }}</td>
                        <td>{{ $data->sort_order }}</td>
                        <td>{{ $data->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('admin.village-data.edit', $data->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.village-data.destroy', $data->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">Belum ada data desa</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $villageData->links() }}
        </div>
    </div>
</div>
@endsection
