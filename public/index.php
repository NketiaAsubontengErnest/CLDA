<?php
/**
 * CLDA Web Application
 * MVC Entry Point
 */

// Define constants
// Define constants
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];

$script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$path = dirname($script);

// If web root is pointing to public, go one level up for app root context if needed,
// but usually assets are relative to public.
// However, in this app, ROOT is used to prefix /public/assets...
// So ROOT should point to the base URL where 'public' resides relative to.
// e.g. http://localhost/CLDA (ROOT) -> /public/css (Asset)

// If script is /CLDA/public/index.php, dirname is /CLDA/public.
// We want /CLDA.
if (basename($path) == 'public') {
    $path = dirname($path);
}

// Ensure no trailing slash
if ($path == '/' || $path == '.') {
    $path = '';
}
$path = rtrim($path, '/');

define('ROOT', $protocol . '://' . $host . $path);

// Autoload core classes
spl_autoload_register(function ($class) {
    // 1. Convert namespace separators to directory separators
    $path = str_replace('\\', '/', $class);
    
    // 2. Handle 'App' namespace mapping to 'app' directory
    if (strpos($path, 'App/') === 0) {
        $path = 'app/' . substr($path, 4); 
        
        // Handle subdirectories that are lowercase in filesystem
        $parts = explode('/', $path);
        // $parts[0] is 'app'
        if (isset($parts[1])) {
            $lowercase_dirs = ['Core', 'Controllers', 'Models', 'Views'];
            // Check strictly or just lowercase it if it matches
            if (in_array($parts[1], $lowercase_dirs)) {
                $parts[1] = strtolower($parts[1]);
            }
        }
        $path = implode('/', $parts);
    }

    $file = __DIR__ . '/../' . $path . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

// Start the application
use App\Core\App;

$app = new App();
