<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Admin - {{ getSetting('general.site_name', 'Desa Karangrejo') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .register-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            margin: 20px;
        }
        
        .register-left {
            background: linear-gradient(45deg, #2c5aa0, #1e3d72);
            color: white;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            position: relative;
        }
        
        .register-left::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.1;
        }
        
        .register-left h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }
        
        .register-left p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            position: relative;
            z-index: 1;
        }
        
        .logo-section {
            position: relative;
            z-index: 1;
            margin-bottom: 2rem;
        }
        
        .logo-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
        }
        
        .register-right {
            padding: 60px 40px;
        }
        
        .form-title {
            color: #2c5aa0;
            font-weight: 600;
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            font-weight: 500;
            color: #555;
            margin-bottom: 0.5rem;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #2c5aa0;
            box-shadow: 0 0 0 0.2rem rgba(44, 90, 160, 0.25);
        }
        
        .input-group-text {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-right: none;
            border-radius: 10px 0 0 10px;
        }
        
        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }
        
        .btn-register {
            background: linear-gradient(45deg, #2c5aa0, #1e3d72);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(44, 90, 160, 0.3);
            color: white;
        }
        
        .alert {
            border-radius: 10px;
            margin-bottom: 1.5rem;
        }
        
        .login-link {
            color: #2c5aa0;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .login-link:hover {
            color: #1e3d72;
            text-decoration: underline;
        }
        
        .password-requirements {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 1.5rem;
        }
        
        .password-requirements h6 {
            color: #2c5aa0;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }
        
        .password-requirements ul {
            margin: 0;
            padding-left: 1rem;
            font-size: 0.8rem;
        }
        
        .password-requirements li {
            color: #666;
            margin-bottom: 3px;
        }
        
        .features-list {
            position: relative;
            z-index: 1;
        }
        
        .features-list ul {
            list-style: none;
            padding: 0;
        }
        
        .features-list li {
            padding: 0.5rem 0;
            display: flex;
            align-items: center;
        }
        
        .features-list i {
            margin-right: 0.8rem;
            color: rgba(255, 255, 255, 0.8);
        }
        
        @media (max-width: 768px) {
            .register-left {
                padding: 40px 20px;
            }
            
            .register-right {
                padding: 40px 20px;
            }
            
            .register-left h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="row g-0 h-100">
            <!-- Left Side - Branding -->
            <div class="col-lg-6 register-left">
                <div class="logo-section">
                    <div class="logo-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h1>{{ getSetting('general.site_name', 'Desa Karangrejo') }}</h1>
                    <p>Sistem Informasi Desa</p>
                </div>
                
                <div>
                    <h3><i class="fas fa-id-card me-2"></i>Pendaftaran Admin</h3>
                    <p class="mb-4">Bergabunglah untuk mengelola website desa</p>
                    
                    <div class="features-list">
                        <ul>
                            <li>
                                <i class="fas fa-shield-alt"></i>
                                Akses panel administrator yang aman
                            </li>
                            <li>
                                <i class="fas fa-edit"></i>
                                Kelola konten website dengan mudah
                            </li>
                            <li>
                                <i class="fas fa-chart-bar"></i>
                                Monitor aktivitas dan statistik
                            </li>
                            <li>
                                <i class="fas fa-users"></i>
                                Kelola data warga dan pengumuman
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Right Side - Registration Form -->
            <div class="col-lg-6 register-right">
                <h2 class="form-title">
                    <i class="fas fa-user-plus me-2"></i>
                    Daftar Admin Baru
                </h2>
                
                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <!-- Password Requirements -->
                <div class="password-requirements">
                    <h6><i class="fas fa-info-circle me-1"></i>Syarat Password:</h6>
                    <ul>
                        <li id="req-length">Minimal 8 karakter</li>
                        <li id="req-case">Huruf besar dan kecil</li>
                        <li id="req-number">Minimal 1 angka</li>
                        <li id="req-special">Minimal 1 karakter khusus</li>
                    </ul>
                </div>
                
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <!-- Name -->
                    <div class="form-group">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                            <input 
                                id="name" 
                                type="text" 
                                class="form-control @error('name') is-invalid @enderror" 
                                name="name" 
                                value="{{ old('name') }}" 
                                required 
                                autofocus 
                                autocomplete="name"
                                placeholder="Masukkan nama lengkap"
                            >
                        </div>
                        @error('name')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Email Address -->
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input 
                                id="email" 
                                type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                name="email" 
                                value="{{ old('email') }}" 
                                required 
                                autocomplete="username"
                                placeholder="Masukkan alamat email"
                            >
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input 
                                id="password" 
                                type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                name="password" 
                                required 
                                autocomplete="new-password"
                                placeholder="Masukkan password"
                            >
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-check-circle"></i>
                            </span>
                            <input 
                                id="password_confirmation" 
                                type="password" 
                                class="form-control @error('password_confirmation') is-invalid @enderror" 
                                name="password_confirmation" 
                                required 
                                autocomplete="new-password"
                                placeholder="Ulangi password"
                            >
                        </div>
                        @error('password_confirmation')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-register mb-4">
                        <i class="fas fa-user-plus me-2"></i>
                        Daftar Sebagai Admin
                    </button>
                </form>
                
                <!-- Login Link -->
                <div class="text-center">
                    <span class="text-muted">Sudah punya akun? </span>
                    <a href="{{ route('login') }}" class="login-link">
                        <i class="fas fa-sign-in-alt me-1"></i>
                        Masuk di sini
                    </a>
                </div>
                
                <!-- Back to Website -->
                <div class="text-center mt-3">
                    <a href="{{ route('home') }}" class="text-muted text-decoration-none">
                        <i class="fas fa-arrow-left me-1"></i>
                        Kembali ke Website
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            
            // Check each requirement
            const requirements = {
                'req-length': password.length >= 8,
                'req-case': /[a-z]/.test(password) && /[A-Z]/.test(password),
                'req-number': /\d/.test(password),
                'req-special': /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)
            };
            
            // Update visual feedback
            Object.keys(requirements).forEach(reqId => {
                const element = document.getElementById(reqId);
                if (requirements[reqId]) {
                    element.style.color = '#28a745';
                    element.style.fontWeight = '600';
                } else {
                    element.style.color = '#666';
                    element.style.fontWeight = 'normal';
                }
            });
        });
        
        // Confirm password validation
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            
            if (confirmPassword && password !== confirmPassword) {
                this.setCustomValidity('Password tidak cocok');
                this.classList.add('is-invalid');
            } else {
                this.setCustomValidity('');
                this.classList.remove('is-invalid');
            }
        });
        
        // Form submission loading state
        document.querySelector('form').addEventListener('submit', function() {
            const submitBtn = document.querySelector('.btn-register');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mendaftar...';
        });
    </script>
</body>
</html>
