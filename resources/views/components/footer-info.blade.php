{{-- Footer Info Component --}}
{{-- Usage: <x-footer-info /> --}}

<div class="footer-info">
    <!-- Site Info -->
    <div class="site-info mb-4">
        <h5 class="text-white mb-3">{{ $footerData['site_name'] ?? 'Desa Karangrejo' }}</h5>
        <p class="mb-3">{{ $footerData['site_description'] ?? 'Website resmi desa' }}</p>
        
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
    
    <!-- Contact Info -->
    <div class="contact-info">
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
    
    <!-- Copyright -->
    <div class="copyright-info mt-4 pt-3 border-top" style="border-color: #6c757d;">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0 text-white-50">
                    &copy; {{ date('Y') }} {{ $footerData['footer_copyright'] ?? 'All rights reserved.' }}
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-0 text-white-50">
                    {{ $footerData['footer_developer'] ?? 'Developed with ❤️' }}
                </p>
            </div>
        </div>
    </div>
</div>