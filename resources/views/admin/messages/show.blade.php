@extends('layouts.admin')

@section('title', 'Detail Pesan Kontak')
@section('page-title', 'Detail Pesan Kontak')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Detail Pesan Kontak</h5>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Nama</dt>
                    <dd class="col-sm-8">{{ $message->name }}</dd>

                    <dt class="col-sm-4">Email</dt>
                    <dd class="col-sm-8">{{ $message->email }}</dd>

                    <dt class="col-sm-4">Telepon</dt>
                    <dd class="col-sm-8">{{ $message->phone ?: '-' }}</dd>

                    <dt class="col-sm-4">Subjek</dt>
                    <dd class="col-sm-8">{{ $message->subject }}</dd>

                    <dt class="col-sm-4">Pesan</dt>
                    <dd class="col-sm-8">{{ $message->message }}</dd>

                    <dt class="col-sm-4">Status</dt>
                    <dd class="col-sm-8">
                        <span class="badge bg-{{ $message->status == 'read' ? 'success' : 'secondary' }}">
                            {{ $message->status == 'read' ? 'Dibaca' : 'Baru' }}
                        </span>
                    </dd>

                    <dt class="col-sm-4">Dikirim</dt>
                    <dd class="col-sm-8">{{ $message->created_at->format('d/m/Y H:i') }}</dd>

                    @if($message->reply)
                    <dt class="col-sm-4">Balasan</dt>
                    <dd class="col-sm-8">{{ $message->reply }}</dd>
                    @endif
                </dl>
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.messages.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
