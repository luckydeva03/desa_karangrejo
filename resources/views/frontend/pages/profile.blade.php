@extends('layouts.frontend')

@section('title', 'Profil Desa - Desa Karangrejo')
@section('description', 'Profil lengkap Desa Karangrejo meliputi data demografis, geografis, dan informasi umum desa')

@section('content')
<!-- Page Header -->
<section class="bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-5 fw-bold mb-3">Profil Desa Karangrejo</h1>
                <p class="lead mb-0">Informasi lengkap tentang Desa Karangrejo</p>
            </div>
        </div>
    </div>
</section>

<!-- Profile Content -->
<section class="section-padding">
    <div class="container">
        <!-- Demographics Section -->
        @if($demographics->count() > 0)
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="fw-bold mb-4">Data Demografis</h2>
                <div class="row">
                    @foreach($demographics as $demo)
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card text-center h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="text-primary mb-3">
                                    <i class="{{ $demo->icon }} fa-3x"></i>
                                </div>
                                <h3 class="stats-counter text-primary">{{ $demo->value }}</h3>
                                <h6 class="text-dark">{{ $demo->label }}</h6>
                                <p class="text-muted small">{{ $demo->description }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Geography Section -->
        @if($geography->count() > 0)
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="fw-bold mb-4">Data Geografis</h2>
                <div class="row">
                    @foreach($geography as $geo)
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card text-center h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="text-success mb-3">
                                    <i class="{{ $geo->icon }} fa-3x"></i>
                                </div>
                                <h3 class="text-success">{{ $geo->value }}</h3>
                                <h6 class="text-dark">{{ $geo->label }}</h6>
                                <p class="text-muted small">{{ $geo->description }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Economy Section -->
        @if($economy->count() > 0)
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="fw-bold mb-4">Data Ekonomi</h2>
                <div class="row">
                    @foreach($economy as $econ)
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card text-center h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="text-warning mb-3">
                                    <i class="{{ $econ->icon }} fa-3x"></i>
                                </div>
                                <h3 class="text-warning">{{ $econ->value }}</h3>
                                <h6 class="text-dark">{{ $econ->label }}</h6>
                                <p class="text-muted small">{{ $econ->description }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Additional Info Sections -->
        <div class="row">
            <!-- Sejarah Desa -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100 border-0 shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-history me-2"></i>Sejarah Singkat</h5>
                    </div>
                    <div class="card-body">
                        @if($historyPage)
                            @php
                                // Ambil paragraf pertama dari konten sejarah
                                $content = strip_tags($historyPage->content);
                                // Ambil 200 karakter pertama dan pastikan berakhir dengan kata utuh
                                $excerpt = Str::limit($content, 300, '...');
                            @endphp
                            <p>{{ $excerpt }}</p>
                            <a href="{{ route('history') }}" class="btn btn-outline-primary">Baca Selengkapnya</a>
                        @else
                            <p>Desa Karangrejo didirikan pada tahun 1945 oleh para sesepuh desa yang berasal dari berbagai daerah. Nama Karangrejo berasal dari kata "Karang" yang berarti batu dan "Rejo" yang berarti sejahtera.</p>
                            <p>Sejak didirikan, Desa Karangrejo terus mengalami perkembangan dalam berbagai bidang, mulai dari infrastruktur, pendidikan, kesehatan, hingga perekonomian masyarakat.</p>
                            <a href="{{ route('history') }}" class="btn btn-outline-primary">Baca Selengkapnya</a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Visi Misi -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100 border-0 shadow">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-bullseye me-2"></i>Visi & Misi</h5>
                    </div>
                    <div class="card-body">
                        @if($visionMissionPage)
                            @if($visionMissionPage->vision_text)
                                <h6 class="fw-bold text-primary">
                                    <i class="fas fa-eye me-2"></i>Visi
                                </h6>
                                <div class="mb-3 p-3 bg-light rounded">
                                    {!! Str::limit(strip_tags($visionMissionPage->vision_text), 200, '...') !!}
                                </div>
                            @endif
                            
                            @if($visionMissionPage->mission_text)
                                <h6 class="fw-bold text-success">
                                    <i class="fas fa-bullseye me-2"></i>Misi
                                </h6>
                                <div class="mb-3 p-3 bg-light rounded">
                                    {!! Str::limit(strip_tags($visionMissionPage->mission_text), 200, '...') !!}
                                </div>
                            @endif
                            
                            <a href="{{ route('vision-mission') }}" class="btn btn-outline-success">
                                <i class="fas fa-arrow-right me-2"></i>Baca Selengkapnya
                            </a>
                        @else
                            <h6 class="fw-bold">Visi</h6>
                            <p class="small">"Mewujudkan Desa Karangrejo yang Maju, Mandiri, dan Sejahtera Berdasarkan Gotong Royong"</p>
                            
                            <h6 class="fw-bold">Misi</h6>
                            <ul class="small">
                                <li>Meningkatkan kualitas pelayanan publik</li>
                                <li>Mengembangkan potensi ekonomi lokal</li>
                                <li>Memperkuat infrastruktur desa</li>
                                <li>Memberdayakan masyarakat</li>
                            </ul>
                            <a href="{{ route('vision-mission') }}" class="btn btn-outline-success">Baca Selengkapnya</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
@endsection