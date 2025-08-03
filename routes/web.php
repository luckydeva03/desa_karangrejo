<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\GalleryController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Debug Route for Hosting Issues
|--------------------------------------------------------------------------
*/
Route::get('/debug-hosting-config', function () {
    // Emergency debug route for hosting issues
    $output = "<h1>🔧 Laravel Configuration Debug</h1>";
    $output .= "<p><strong>Timestamp:</strong> " . now() . "</p><hr>";
    
    // Check database config
    $output .= "<h2>📊 Database Configuration</h2>";
    try {
        $config = config('database.connections.mysql');
        $output .= "<table border='1' style='border-collapse: collapse;'>";
        $output .= "<tr><th>Setting</th><th>Value</th></tr>";
        $output .= "<tr><td>Host</td><td>" . $config['host'] . "</td></tr>";
        $output .= "<tr><td>Database</td><td>" . $config['database'] . "</td></tr>";
        $output .= "<tr><td>Username</td><td>" . $config['username'] . "</td></tr>";
        $output .= "<tr><td>Password</td><td>" . (empty($config['password']) ? '❌ EMPTY' : '✅ SET') . "</td></tr>";
        $output .= "</table>";
        
        // Test connection
        $output .= "<h3>🔌 Connection Test</h3>";
        DB::connection()->getPdo();
        $output .= "<p>✅ Database connection successful!</p>";
        
        // Test sessions table
        $sessionCount = DB::table('sessions')->count();
        $output .= "<p>✅ Sessions table accessible ($sessionCount records)</p>";
        
    } catch (Exception $e) {
        $output .= "<p>❌ Database error: " . $e->getMessage() . "</p>";
    }
    
    // Environment check
    $output .= "<h2>🌍 Environment</h2>";
    $output .= "<p><strong>APP_ENV:</strong> " . config('app.env') . "</p>";
    $output .= "<p><strong>APP_DEBUG:</strong> " . (config('app.debug') ? 'true' : 'false') . "</p>";
    $output .= "<p><strong>Cache Store:</strong> " . config('cache.default') . "</p>";
    $output .= "<p><strong>Session Driver:</strong> " . config('session.driver') . "</p>";
    
    $output .= "<hr><p><strong>⚠️ Delete this route after debugging!</strong></p>";
    
    return response($output);
})->name('debug.hosting');

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Posts Routes
Route::prefix('berita')->name('posts.')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('index');
    Route::get('/kategori/{slug}', [PostController::class, 'category'])->name('category');
    Route::get('/cari', [PostController::class, 'search'])->name('search');
    Route::get('/{post}', [PostController::class, 'show'])->name('show');
});

// Pages Routes
Route::get('/profil', [PageController::class, 'profile'])->name('profile');
Route::get('/sejarah', [PageController::class, 'history'])->name('history');
Route::get('/visi-misi', [PageController::class, 'visionMission'])->name('vision-mission');
Route::get('/struktur-organisasi', [PageController::class, 'organizationStructure'])->name('organization');
// Route layanan dihapus
Route::get('/halaman/{page}', [PageController::class, 'show'])->name('pages.show');

// Gallery Routes
Route::prefix('galeri')->name('galleries.')->group(function () {
    Route::get('/', [GalleryController::class, 'index'])->name('index');
    Route::get('/foto', [GalleryController::class, 'photos'])->name('photos');
    Route::get('/video', [GalleryController::class, 'videos'])->name('videos');
    Route::get('/kategori/{category}', [GalleryController::class, 'category'])->name('category');
    Route::get('/{gallery}', [GalleryController::class, 'show'])->name('show');
});

// Contact Routes
Route::prefix('kontak')->name('contact.')->group(function () {
    Route::get('/', [ContactController::class, 'index'])->name('index');
    Route::post('/', [ContactController::class, 'store'])->name('store');
    Route::get('/jam-operasional', [ContactController::class, 'getOfficeHours'])->name('office-hours');
});

// Alternative logout route for testing
Route::post('/logout-alt', function(\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('home')->with('success', 'Logout berhasil.');
})->name('logout.alt')->middleware('auth');

// Debug session info (only in development)
Route::get('/debug/session', function(\Illuminate\Http\Request $request) {
    if (app()->environment(['local', 'development'])) {
        return response()->json([
            'session_id' => $request->session()->getId(),
            'csrf_token' => $request->session()->token(),
            'user' => \Illuminate\Support\Facades\Auth::user(),
            'session_data' => $request->session()->all(),
        ]);
    }
    return abort(404);
})->name('debug.session');

// API Routes for Frontend (public access)
Route::prefix('api')->name('api.')->group(function () {
    Route::get('/announcements/active', function() {
        return response()->json(
            \App\Models\Announcement::active()
                ->latest()
                ->limit(5)
                ->get()
        );
    })->name('announcements.active');
    
    Route::get('/village-stats', function() {
        return response()->json(
            \App\Models\VillageData::byType('demografi')
                ->ordered()
                ->get()
        );
    })->name('village.stats');
});

/*
|--------------------------------------------------------------------------
| Dashboard Route (untuk redirect default setelah login)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    
    $user = Auth::user();
    
    if ($user && in_array($user->role, ['admin', 'operator'])) {
        return redirect()->route('admin.dashboard');
    }
    
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'admin'])->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Posts Management
    Route::resource('posts', \App\Http\Controllers\Admin\PostController::class);
    
    // Categories Management
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)
        ->except(['show']);
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::post('bulk-action', [\App\Http\Controllers\Admin\CategoryController::class, 'bulkAction'])->name('bulk-action');
        Route::patch('{category}/toggle-status', [\App\Http\Controllers\Admin\CategoryController::class, 'toggleStatus'])->name('toggle-status');
        Route::get('export', [\App\Http\Controllers\Admin\CategoryController::class, 'export'])->name('export');
        Route::get('select', [\App\Http\Controllers\Admin\CategoryController::class, 'getForSelect'])->name('select');
    });
    
    // Pages Management
    Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);
    
    // Organizational Members Management (nested under pages)
    Route::resource('pages.organizational-members', \App\Http\Controllers\Admin\OrganizationalMemberController::class);

    // Post Image Upload (for TinyMCE or similar)
    Route::post('posts/upload-image', [\App\Http\Controllers\Admin\PostController::class, 'uploadImageForEditor'])->name('posts.upload-image');

    // Gallery Management
    Route::resource('galleries', \App\Http\Controllers\Admin\GalleryController::class);
    
    // Village Data Management
    Route::resource('village-data', \App\Http\Controllers\Admin\VillageDataController::class);
    
    // Village Data Types Management
    Route::resource('village-data-types', \App\Http\Controllers\Admin\VillageDataTypeController::class);
    
    // Announcements Management
    Route::resource('announcements', \App\Http\Controllers\Admin\AnnouncementController::class);
    
    // Contact Messages
    Route::resource('messages', \App\Http\Controllers\Admin\ContactMessageController::class)
        ->only(['index', 'show', 'update', 'destroy']);
    
    // Settings Management
    Route::get('settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
    
    // Admin Only Routes
    Route::middleware('admin')->group(function () {
        // User Management
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    });
    
    // API Routes for Admin (AJAX)
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('stats', [DashboardController::class, 'getStats'])->name('stats');
        Route::get('notifications', [DashboardController::class, 'getNotifications'])->name('notifications');
    });
});

/*
|--------------------------------------------------------------------------
| Sitemap Routes
|--------------------------------------------------------------------------
*/

Route::get('/sitemap.xml', function() {
    $posts = \App\Models\Post::published()->latest()->get();
    $pages = \App\Models\Page::published()->get();
    $galleries = \App\Models\Gallery::active()->latest()->get();
    $categories = \App\Models\Category::active()->get();
    
    return response()->view('frontend.sitemap', compact('posts', 'pages', 'galleries', 'categories'))
        ->header('Content-Type', 'text/xml');
})->name('sitemap');

/*
|--------------------------------------------------------------------------
| Feed Routes
|--------------------------------------------------------------------------
*/

Route::get('/feed', function() {
    $posts = \App\Models\Post::published()
        ->with(['category', 'user'])
        ->latest()
        ->limit(20)
        ->get();
    
    return response()->view('frontend.feed', compact('posts'))
        ->header('Content-Type', 'application/xml');
})->name('feed');

/*
|--------------------------------------------------------------------------
| Health Check Route
|--------------------------------------------------------------------------
*/

Route::get('/health', function() {
    try {
        // Check database connection
        DB::connection()->getPdo();
        
        // Check storage access
        $storageWritable = is_writable(storage_path());
        
        return response()->json([
            'status' => 'ok',
            'timestamp' => now()->toISOString(),
            'checks' => [
                'database' => 'ok',
                'storage' => $storageWritable ? 'ok' : 'error'
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Service unavailable',
            'timestamp' => now()->toISOString()
        ], 503);
    }
})->name('health');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Fallback Route (404 handler)
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    if (view()->exists('errors.404')) {
        return response()->view('errors.404', [], 404);
    }
    
    return response()->json([
        'message' => 'Page not found',
        'status' => 404
    ], 404);
});