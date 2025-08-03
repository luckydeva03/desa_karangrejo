@extends('layouts.admin')

@section('title', 'Pengaturan Website')
@section('page-title', 'Pengaturan Website')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-cog me-2"></i>
                    Pengaturan Website
                </h5>
            </div>
            <div class="card-body">
                
                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        {{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('admin.settings.update') }}" id="settingsForm">
                    @csrf
                    
                    <!-- Tabs Navigation -->
                    <ul class="nav nav-tabs mb-4" id="settingsTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button">
                                <i class="fas fa-cog me-1"></i> Umum
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button">
                                <i class="fas fa-address-book me-1"></i> Kontak
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button">
                                <i class="fab fa-facebook me-1"></i> Media Sosial
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="footer-tab" data-bs-toggle="tab" data-bs-target="#footer" type="button">
                                <i class="fas fa-window-minimize me-1"></i> Footer
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contact-page-tab" data-bs-toggle="tab" data-bs-target="#contact-page" type="button">
                                <i class="fas fa-map-marker-alt me-1"></i> Halaman Kontak
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="settingsTabContent">
                        
                        <!-- General Settings Tab -->
                        <div class="tab-pane fade show active" id="general" role="tabpanel">
                            <h6 class="mb-3 text-primary border-bottom pb-2">Pengaturan Umum</h6>
                            <div class="row">
                                @forelse($generalSettings as $setting)
                                    <div class="col-md-6 mb-3">
                                        <label for="{{ $setting->key }}" class="form-label fw-bold">
                                            {{ $setting->label }}
                                        </label>
                                        
                                        @if($setting->type == 'textarea')
                                            <textarea 
                                                class="form-control" 
                                                id="{{ $setting->key }}" 
                                                name="settings[{{ $setting->key }}]" 
                                                rows="4"
                                                placeholder="{{ $setting->description ?? $setting->label }}"
                                            >{{ old('settings.'.$setting->key, $setting->value) }}</textarea>
                                        @else
                                            <input 
                                                type="{{ $setting->type }}" 
                                                class="form-control" 
                                                id="{{ $setting->key }}" 
                                                name="settings[{{ $setting->key }}]" 
                                                value="{{ old('settings.'.$setting->key, $setting->value) }}"
                                                placeholder="{{ $setting->description ?? $setting->label }}"
                                            >
                                        @endif
                                        
                                        @if($setting->description)
                                            <small class="text-muted">{{ $setting->description }}</small>
                                        @endif
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <p class="text-muted">Tidak ada pengaturan umum.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Contact Settings Tab -->
                        <div class="tab-pane fade" id="contact" role="tabpanel">
                            <h6 class="mb-3 text-primary border-bottom pb-2">Informasi Kontak</h6>
                            <div class="row">
                                @forelse($contactSettings as $setting)
                                    <div class="col-md-6 mb-3">
                                        <label for="{{ $setting->key }}" class="form-label fw-bold">
                                            {{ $setting->label }}
                                        </label>
                                        
                                        @if($setting->type == 'textarea')
                                            <textarea 
                                                class="form-control" 
                                                id="{{ $setting->key }}" 
                                                name="settings[{{ $setting->key }}]" 
                                                rows="4"
                                                placeholder="{{ $setting->description ?? $setting->label }}"
                                            >{{ old('settings.'.$setting->key, $setting->value) }}</textarea>
                                        @else
                                            <input 
                                                type="{{ $setting->type }}" 
                                                class="form-control" 
                                                id="{{ $setting->key }}" 
                                                name="settings[{{ $setting->key }}]" 
                                                value="{{ old('settings.'.$setting->key, $setting->value) }}"
                                                placeholder="{{ $setting->description ?? $setting->label }}"
                                            >
                                        @endif
                                        
                                        @if($setting->description)
                                            <small class="text-muted">{{ $setting->description }}</small>
                                        @endif
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <p class="text-muted">Tidak ada pengaturan kontak.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Social Media Settings Tab -->
                        <div class="tab-pane fade" id="social" role="tabpanel">
                            <h6 class="mb-3 text-primary border-bottom pb-2">Media Sosial</h6>
                            <div class="row">
                                @forelse($socialSettings as $setting)
                                    <div class="col-md-6 mb-3">
                                        <label for="{{ $setting->key }}" class="form-label fw-bold">
                                            {{ $setting->label }}
                                        </label>
                                        <input 
                                            type="{{ $setting->type }}" 
                                            class="form-control" 
                                            id="{{ $setting->key }}" 
                                            name="settings[{{ $setting->key }}]" 
                                            value="{{ old('settings.'.$setting->key, $setting->value) }}"
                                            placeholder="{{ $setting->description ?? $setting->label }}"
                                        >
                                        @if($setting->description)
                                            <small class="text-muted">{{ $setting->description }}</small>
                                        @endif
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <p class="text-muted">Tidak ada pengaturan media sosial.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Footer Settings Tab -->
                        <div class="tab-pane fade" id="footer" role="tabpanel">
                            <h6 class="mb-3 text-primary border-bottom pb-2">Pengaturan Footer</h6>
                            <div class="row">
                                @forelse($footerSettings as $setting)
                                    <div class="col-md-6 mb-3">
                                        <label for="{{ $setting->key }}" class="form-label fw-bold">
                                            {{ $setting->label }}
                                        </label>
                                        
                                        @if($setting->type == 'textarea')
                                            <textarea 
                                                class="form-control" 
                                                id="{{ $setting->key }}" 
                                                name="settings[{{ $setting->key }}]" 
                                                rows="4"
                                                placeholder="{{ $setting->description ?? $setting->label }}"
                                            >{{ old('settings.'.$setting->key, $setting->value) }}</textarea>
                                        @else
                                            <input 
                                                type="{{ $setting->type }}" 
                                                class="form-control" 
                                                id="{{ $setting->key }}" 
                                                name="settings[{{ $setting->key }}]" 
                                                value="{{ old('settings.'.$setting->key, $setting->value) }}"
                                                placeholder="{{ $setting->description ?? $setting->label }}"
                                            >
                                        @endif
                                        
                                        @if($setting->description)
                                            <small class="text-muted">{{ $setting->description }}</small>
                                        @endif
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <p class="text-muted">Tidak ada pengaturan footer.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        
                        <!-- Contact Page Settings Tab -->
                        <div class="tab-pane fade" id="contact-page" role="tabpanel">
                            <!-- Office Info Sub-section -->
                            <div class="mb-5">
                                <h6 class="mb-3 text-primary border-bottom pb-2">
                                    <i class="fas fa-building me-2"></i>Informasi Kantor
                                </h6>
                                <div class="row">
                                    @forelse($contactOfficeSettings as $setting)
                                        <div class="col-md-6 mb-3">
                                            <label for="{{ $setting->key }}" class="form-label fw-bold">
                                                {{ $setting->label }}
                                            </label>
                                            
                                            @if($setting->type == 'textarea')
                                                <textarea 
                                                    class="form-control" 
                                                    id="{{ $setting->key }}" 
                                                    name="settings[{{ $setting->key }}]" 
                                                    rows="4"
                                                    placeholder="{{ $setting->description ?? $setting->label }}"
                                                >{{ old('settings.'.$setting->key, $setting->value) }}</textarea>
                                            @else
                                                <input 
                                                    type="{{ $setting->type }}" 
                                                    class="form-control" 
                                                    id="{{ $setting->key }}" 
                                                    name="settings[{{ $setting->key }}]" 
                                                    value="{{ old('settings.'.$setting->key, $setting->value) }}"
                                                    placeholder="{{ $setting->description ?? $setting->label }}"
                                                >
                                            @endif
                                            
                                            @if($setting->description)
                                                <small class="text-muted">{{ $setting->description }}</small>
                                            @endif
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <p class="text-muted">Tidak ada pengaturan informasi kantor.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            
                            <!-- Office Hours Sub-section -->
                            <div class="mb-5">
                                <h6 class="mb-3 text-primary border-bottom pb-2">
                                    <i class="fas fa-clock me-2"></i>Jam Pelayanan
                                </h6>
                                <div class="row">
                                    @forelse($contactHoursSettings as $setting)
                                        <div class="col-md-4 mb-3">
                                            <label for="{{ $setting->key }}" class="form-label fw-bold">
                                                {{ $setting->label }}
                                            </label>
                                            <input 
                                                type="{{ $setting->type }}" 
                                                class="form-control" 
                                                id="{{ $setting->key }}" 
                                                name="settings[{{ $setting->key }}]" 
                                                value="{{ old('settings.'.$setting->key, $setting->value) }}"
                                                placeholder="{{ $setting->description ?? $setting->label }}"
                                            >
                                            @if($setting->description)
                                                <small class="text-muted">{{ $setting->description }}</small>
                                            @endif
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <p class="text-muted">Tidak ada pengaturan jam pelayanan.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            
                            <!-- Emergency Contacts Sub-section -->
                            <div class="mb-5">
                                <h6 class="mb-3 text-primary border-bottom pb-2">
                                    <i class="fas fa-phone-alt me-2"></i>Kontak Darurat
                                </h6>
                                <div class="row">
                                    @forelse($contactEmergencySettings as $setting)
                                        <div class="col-md-6 mb-3">
                                            <label for="{{ $setting->key }}" class="form-label fw-bold">
                                                {{ $setting->label }}
                                            </label>
                                            <input 
                                                type="{{ $setting->type }}" 
                                                class="form-control" 
                                                id="{{ $setting->key }}" 
                                                name="settings[{{ $setting->key }}]" 
                                                value="{{ old('settings.'.$setting->key, $setting->value) }}"
                                                placeholder="{{ $setting->description ?? $setting->label }}"
                                            >
                                            @if($setting->description)
                                                <small class="text-muted">{{ $setting->description }}</small>
                                            @endif
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <p class="text-muted">Tidak ada pengaturan kontak darurat.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            
                            <!-- Map Settings Sub-section -->
                            <div class="mb-5">
                                <h6 class="mb-3 text-primary border-bottom pb-2">
                                    <i class="fas fa-map me-2"></i>Pengaturan Peta
                                </h6>
                                <div class="row">
                                    @forelse($contactMapSettings as $setting)
                                        <div class="col-12 mb-3">
                                            <label for="{{ $setting->key }}" class="form-label fw-bold">
                                                {{ $setting->label }}
                                            </label>
                                            <input 
                                                type="{{ $setting->type }}" 
                                                class="form-control" 
                                                id="{{ $setting->key }}" 
                                                name="settings[{{ $setting->key }}]" 
                                                value="{{ old('settings.'.$setting->key, $setting->value) }}"
                                                placeholder="{{ $setting->description ?? $setting->label }}"
                                            >
                                            @if($setting->description)
                                                <small class="text-muted">{{ $setting->description }}</small>
                                            @endif
                                            <div class="mt-2">
                                                <small class="text-info">
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    Untuk mendapatkan URL embed Google Maps: 
                                                    <br>1. Buka Google Maps → Cari lokasi kantor desa
                                                    <br>2. Klik "Share" → Pilih "Embed a map" 
                                                    <br>3. Copy URL dari src="..." (tanpa tanda kutip)
                                                </small>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <p class="text-muted">Tidak ada pengaturan peta.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-4 pt-3 border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Perubahan akan disimpan ke database dan cache akan dibersihkan.
                            </small>
                            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                <i class="fas fa-save me-2"></i>
                                Simpan Pengaturan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('settingsForm');
    const submitBtn = document.getElementById('submitBtn');
    
    if (form && submitBtn) {
        form.addEventListener('submit', function(e) {
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
            
            console.log('Form submitted successfully');
        });
    }
    
    console.log('Settings page loaded');
});
</script>

@endsection
