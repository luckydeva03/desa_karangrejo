@extends('layouts.frontend')

@section('title', 'Kontak - Desa Karangrejo')
@section('description', 'Hubungi kami untuk informasi lebih lanjut tentang kegiatan Desa Karangrejo')

@section('content')
<!-- Page Header -->
<section class="bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-5 fw-bold mb-3">Kontak Kami</h1>
                <p class="lead mb-0">Hubungi kami untuk informasi lebih lanjut tentang kegiatan desa</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Content -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <!-- Contact Form -->
            <div class="col-lg-8 mb-5">
                <div class="card border-0 shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-envelope me-2"></i>Kirim Pesan</h5>
                    </div>
                    <div class="card-body p-4">
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('contact.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Nama Lengkap *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Nomor Telepon</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="subject" class="form-label">Subjek *</label>
                                    <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                           id="subject" name="subject" value="{{ old('subject') }}" required>
                                    @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Pesan *</label>
                                <textarea class="form-control @error('message') is-invalid @enderror" 
                                          id="message" name="message" rows="6" required>{{ old('message') }}</textarea>
                                @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i>Kirim Pesan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-4">
                <!-- Office Info -->
                <div class="card mb-4 border-0 shadow">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Informasi Kantor</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6 class="fw-bold">Alamat</h6>
                            <p class="text-muted mb-0">{{ $officeInfo['address'] }}</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="fw-bold">Telepon</h6>
                            <p class="text-muted mb-0">{{ $officeInfo['phone'] }}</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="fw-bold">Email</h6>
                            <p class="text-muted mb-0">{{ $officeInfo['email'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Office Hours -->
                <div class="card mb-4 border-0 shadow">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="fas fa-clock me-2"></i>Jam Pelayanan</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <strong>Senin - Jumat</strong><br>
                            <span class="text-muted">{{ $officeHours['weekday'] }}</span>
                        </div>
                        <div class="mb-2">
                            <strong>Sabtu</strong><br>
                            <span class="text-muted">{{ $officeHours['saturday'] }}</span>
                        </div>
                        <div>
                            <strong>Minggu</strong><br>
                            <span class="text-muted">{{ $officeHours['sunday'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Emergency Contacts -->
                @if(count($emergencyContacts) > 0)
                <div class="card border-0 shadow">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0"><i class="fas fa-phone me-2"></i>Kontak Darurat</h6>
                    </div>
                    <div class="card-body">
                        @php
                            $contactItems = [];
                            if(isset($emergencyContacts['kepala_desa']) && !empty($emergencyContacts['kepala_desa'])) {
                                $contactItems[] = ['label' => 'Kepala Desa', 'number' => $emergencyContacts['kepala_desa']];
                            }
                            if(isset($emergencyContacts['sekretaris']) && !empty($emergencyContacts['sekretaris'])) {
                                $contactItems[] = ['label' => 'Sekretaris Desa', 'number' => $emergencyContacts['sekretaris']];
                            }
                            if(isset($emergencyContacts['babinsa']) && !empty($emergencyContacts['babinsa'])) {
                                $contactItems[] = ['label' => 'Babinsa', 'number' => $emergencyContacts['babinsa']];
                            }
                            if(isset($emergencyContacts['bhabinkamtibmas']) && !empty($emergencyContacts['bhabinkamtibmas'])) {
                                $contactItems[] = ['label' => 'Bhabinkamtibmas', 'number' => $emergencyContacts['bhabinkamtibmas']];
                            }
                        @endphp
                        
                        @foreach($contactItems as $index => $contact)
                        <div class="{{ $index < count($contactItems) - 1 ? 'mb-2' : '' }}">
                            <strong>{{ $contact['label'] }}</strong><br>
                            <span class="text-muted">{{ $contact['number'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Map Section -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-0 shadow">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="fas fa-map me-2"></i>Lokasi Kantor Desa</h5>
                    </div>
                    <div class="card-body p-0">
                        <div style="height: 400px; background: #f8f9fa; position: relative;">
                            <!-- Google Maps Embed - menggunakan URL dari settings -->
                            <iframe 
                                src="{{ $mapSettings['embed_url'] }}"
                                width="100%" 
                                height="400" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>
@endpush