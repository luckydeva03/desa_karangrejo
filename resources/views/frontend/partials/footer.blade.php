@php
    // Data dari database melalui helper function
    $footerData = getFooterData();
    
    // Fallback data jika database kosong
    $fallbackData = [
        'site_name' => 'Desa Karangrejo',
        'site_description' => 'Website resmi Desa Karangrejo yang menyediakan informasi terkini tentang kegiatan, layanan, dan pembangunan desa.',
        'contact_address' => "Jl. Raya Karangrejo No. 123\nKecamatan Sukodadi\nKabupaten Lamongan, Jawa Timur",
        'contact_phone' => '(0322) 123456',
        'contact_email' => 'info@desakarangrejo.id',
        'contact_hours' => 'Senin - Jumat: 08:00 - 16:00',
        'social_facebook' => '#',
        'social_instagram' => '#',
        'social_youtube' => '#',
        'social_whatsapp' => '#',
        'footer_copyright' => 'Desa Karangrejo. All rights reserved.',
        'footer_developer' => 'Developed with ❤️ by Tim IT Desa',
    ];
    
    // Merge dengan fallback untuk memastikan semua key tersedia
    $footerData = array_merge($fallbackData, $footerData);
@endphp

<footer class="footer mt-5">
    <div class="container">
        <div class="row">
            <!-- Site Info Column -->
            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="text-white mb-3">{{ $footerData['site_name'] }}</h5>
                <p class="mb-3">{{ $footerData['site_description'] }}</p>
                
                <!-- Social Media Links -->
                <div class="d-flex gap-3">
                    @if(!empty($footerData['social_facebook']) && $footerData['social_facebook'] !== '#')
                        <a href="{{ $footerData['social_facebook'] }}" class="text-decoration-none" target="_blank" rel="noopener">
                            <i class="fab fa-facebook-f fa-lg text-primary"></i>
                        </a>
                    @endif
                    
                    @if(!empty($footerData['social_instagram']) && $footerData['social_instagram'] !== '#')
                        <a href="{{ $footerData['social_instagram'] }}" class="text-decoration-none" target="_blank" rel="noopener">
                            <i class="fab fa-instagram fa-lg text-danger"></i>
                        </a>
                    @endif
                    
                    @if(!empty($footerData['social_youtube']) && $footerData['social_youtube'] !== '#')
                        <a href="{{ $footerData['social_youtube'] }}" class="text-decoration-none" target="_blank" rel="noopener">
                            <i class="fab fa-youtube fa-lg text-danger"></i>
                        </a>
                    @endif
                    
                    @if(!empty($footerData['social_whatsapp']) && $footerData['social_whatsapp'] !== '#')
                        <a href="{{ $footerData['social_whatsapp'] }}" class="text-decoration-none" target="_blank" rel="noopener">
                            <i class="fab fa-whatsapp fa-lg text-success"></i>
                        </a>
                    @endif
                </div>
            </div>
            
            <!-- Menu Column -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h6 class="text-white mb-3">Menu Utama</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ route('home') }}" class="text-decoration-none text-white-50 hover-text-white">
                            Beranda
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('profile') }}" class="text-decoration-none text-white-50 hover-text-white">
                            Profil Desa
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('posts.index') }}" class="text-decoration-none text-white-50 hover-text-white">
                            Berita
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('galleries.index') }}" class="text-decoration-none text-white-50 hover-text-white">
                            Galeri
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('contact.index') }}" class="text-decoration-none text-white-50 hover-text-white">
                            Kontak
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact Info Column -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h6 class="text-white mb-3">Kontak Kami</h6>
                
                @if(!empty($footerData['contact_address']))
                    <div class="d-flex mb-2">
                        <i class="fas fa-map-marker-alt me-3 mt-1 text-primary"></i>
                        <span class="text-white-50">{!! nl2br(e($footerData['contact_address'])) !!}</span>
                    </div>
                @endif
                
                @if(!empty($footerData['contact_phone']))
                    <div class="d-flex mb-2">
                        <i class="fas fa-phone me-3 mt-1 text-primary"></i>
                        <span class="text-white-50">{{ $footerData['contact_phone'] }}</span>
                    </div>
                @endif
                
                @if(!empty($footerData['contact_email']))
                    <div class="d-flex mb-2">
                        <i class="fas fa-envelope me-3 mt-1 text-primary"></i>
                        <a href="mailto:{{ $footerData['contact_email'] }}" class="text-white-50 text-decoration-none">
                            {{ $footerData['contact_email'] }}
                        </a>
                    </div>
                @endif
                
                @if(!empty($footerData['contact_hours']))
                    <div class="d-flex">
                        <i class="fas fa-clock me-3 mt-1 text-primary"></i>
                        <span class="text-white-50">{{ $footerData['contact_hours'] }}</span>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Bottom Section -->
        <hr class="my-4" style="border-color: #6c757d;">
        
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0 text-white-50">
                    &copy; {{ date('Y') }} {{ $footerData['footer_copyright'] }}
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-0 text-white-50">
                    {{ $footerData['footer_developer'] }}
                </p>
            </div>
        </div>
    </div>
</footer>

<style>
.footer {
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    color: #e2e8f0;
    padding: 2rem 0 1rem 0;
    margin-top: auto;
}

.footer .hover-text-white:hover {
    color: #ffffff !important;
    transition: color 0.3s ease;
}

.footer .text-white-50 {
    color: rgba(255, 255, 255, 0.75) !important;
}

.footer a:hover {
    color: #ffffff !important;
}

.footer i.text-primary {
    color: #3b82f6 !important;
}

.footer i.text-danger {
    color: #ef4444 !important;
}

.footer i.text-success {
    color: #22c55e !important;
}
</style>
