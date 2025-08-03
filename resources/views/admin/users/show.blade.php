@extends('layouts.admin')

@section('title', 'Detail User')
@section('page-title', 'Detail User')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Detail User</h5>
                <div>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center mb-4">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 150px; height: 150px;">
                                    <i class="fas fa-user text-white fa-3x"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold" style="width: 150px;">Nama</td>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Email</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Telepon</td>
                                <td>{{ $user->phone ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Role</td>
                                <td>
                                    <span class="badge bg-{{ $user->role == 'admin' ? 'primary' : 'secondary' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Status</td>
                                <td>
                                    <span class="badge bg-{{ $user->status == 'active' ? 'success' : 'danger' }}">
                                        {{ $user->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Email Terverifikasi</td>
                                <td>
                                    @if($user->email_verified_at)
                                        <span class="badge bg-success">Ya</span>
                                        <small class="text-muted">({{ $user->email_verified_at->format('d M Y H:i') }})</small>
                                    @else
                                        <span class="badge bg-warning">Belum</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Bergabung</td>
                                <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Terakhir Update</td>
                                <td>{{ $user->updated_at->format('d M Y H:i') }}</td>
                            </tr>
                        </table>
                        
                        @if($user->bio)
                        <div class="mt-3">
                            <h6 class="fw-bold">Bio</h6>
                            <p class="text-muted">{{ $user->bio }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                @if($user->posts && $user->posts->count() > 0)
                <hr>
                <h6 class="fw-bold">Postingan ({{ $user->posts->count() }})</h6>
                <div class="row">
                    @foreach($user->posts->take(6) as $post)
                    <div class="col-md-4 mb-3">
                        <div class="card card-sm">
                            <div class="card-body p-3">
                                <h6 class="card-title mb-1">{{ Str::limit($post->title, 50) }}</h6>
                                <small class="text-muted">{{ $post->created_at->format('d M Y') }}</small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @if($user->posts->count() > 6)
                <p class="text-muted">Dan {{ $user->posts->count() - 6 }} postingan lainnya...</p>
                @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
