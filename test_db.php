<?php
// Debug script for 419 error
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

echo "=== DEBUG 419 ERROR ===\n\n";

// 1. Check APP_KEY
$key = env('APP_KEY');
echo "1. APP_KEY: " . ($key ? "SET (" . substr($key, 0, 15) . "...)" : "MISSING!") . "\n";

// 2. Check Session Driver
echo "2. SESSION_DRIVER: " . config('session.driver') . "\n";

// 3. Check Session Domain
echo "3. SESSION_DOMAIN: " . (config('session.domain') ?: 'null (default)') . "\n";

// 4. Check Session Path
echo "5. SESSION_PATH: " . config('session.path') . "\n";

// 5. Check Session Secure Cookie
echo "6. SESSION_SECURE_COOKIE: " . (config('session.secure') ? 'true' : 'false/null') . "\n";

// 6. Check Same Site
echo "7. SESSION_SAME_SITE: " . (config('session.same_site') ?: 'null') . "\n";

// 7. Check Cache Store  
echo "8. CACHE_STORE: " . config('cache.default') . "\n";

// 8. Check APP_ENV
echo "9. APP_ENV: " . config('app.env') . "\n";

// 9. Check APP_URL
echo "10. APP_URL: " . config('app.url') . "\n";

// 10. Check Middleware
echo "\n=== MIDDLEWARE CHECK ===\n";
$middlewareGroups = $app->make('router')->getMiddlewareGroups();
if (isset($middlewareGroups['web'])) {
    echo "Web middleware group:\n";
    foreach ($middlewareGroups['web'] as $m) {
        echo "  - $m\n";
    }
} else {
    echo "No 'web' middleware group found (using Laravel 11+ defaults)\n";
}

// 11. Check if sessions table exists (if using database driver)
if (config('session.driver') === 'database') {
    try {
        $exists = Illuminate\Support\Facades\Schema::hasTable('sessions');
        echo "\n11. Sessions table exists: " . ($exists ? 'YES' : 'NO - THIS IS THE PROBLEM!') . "\n";
    } catch (Exception $e) {
        echo "\n11. Cannot check sessions table: " . $e->getMessage() . "\n";
    }
}

// 12. Check storage permissions
$storagePath = storage_path('framework/sessions');
echo "\n=== STORAGE CHECK ===\n";
echo "Sessions dir exists: " . (is_dir($storagePath) ? 'YES' : 'NO') . "\n";
echo "Sessions dir writable: " . (is_writable($storagePath) ? 'YES' : 'NO') . "\n";

$cachePath = storage_path('framework/cache');
echo "Cache dir exists: " . (is_dir($cachePath) ? 'YES' : 'NO') . "\n";
echo "Cache dir writable: " . (is_writable($cachePath) ? 'YES' : 'NO') . "\n";

$viewsPath = storage_path('framework/views');
echo "Views dir exists: " . (is_dir($viewsPath) ? 'YES' : 'NO') . "\n";
echo "Views dir writable: " . (is_writable($viewsPath) ? 'YES' : 'NO') . "\n";

echo "\n=== ENCRYPTION CHECK ===\n";
try {
    $encrypted = encrypt('test-csrf-token');
    $decrypted = decrypt($encrypted);
    echo "Encryption/Decryption: " . ($decrypted === 'test-csrf-token' ? 'WORKING' : 'BROKEN') . "\n";
} catch (Exception $e) {
    echo "Encryption FAILED: " . $e->getMessage() . "\n";
}

echo "\nDone.\n";
