<?php
// view.php - Serve hosted HTML, CSS, JS files
session_start();

// Get requested site name
$site_name = isset($_GET['site']) ? trim($_GET['site']) : '';

if (empty($site_name)) {
    header("Location: index.php");
    exit;
}

// Security check - prevent directory traversal
if (strpos($site_name, '..') !== false || strpos($site_name, '/') !== false || strpos($site_name, '\\') !== false) {
    http_response_code(403);
    showError("Access forbidden - Invalid site name");
    exit;
}

// Look for the site file with different extensions
$extensions = [
    'html', 'htm', 'css', 'js',
    'mp3', 'wav', 'ogg', 'oga', 'm4a', 'aac', 'flac',
    'mp4', 'webm', 'mov', 'mkv', 'avi', 'ogv',
    'jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp', 'ico'
];
$file_path = null;
$is_zip_site = false;

// First check if it's a directory (ZIP extracted site)
$dir_path = 'sites/' . $site_name;
if (is_dir($dir_path)) {
    // Look for HTML files in the directory
    $html_files = glob($dir_path . '/*.{html,htm}', GLOB_BRACE);
    if (!empty($html_files)) {
        $file_path = $html_files[0]; // Use the first HTML file found
        $is_zip_site = true;
    }
} else {
    // Look for single files with different extensions
    foreach ($extensions as $ext) {
        $possible_path = 'sites/' . $site_name . '.' . $ext;
        if (file_exists($possible_path)) {
            $file_path = $possible_path;
            break;
        }
    }
}

// Check if file exists
if (!$file_path || !file_exists($file_path)) {
    http_response_code(404);
    showError("Site not found - '$site_name' doesn't exist or has been removed");
    exit;
}

// Get file extension and set content type
$file_ext = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
$content_types = [
    'html' => 'text/html; charset=UTF-8',
    'htm'  => 'text/html; charset=UTF-8',
    'css'  => 'text/css; charset=UTF-8',
    'js'   => 'application/javascript; charset=UTF-8',

    // Audio
    'mp3'  => 'audio/mpeg',
    'wav'  => 'audio/wav',
    'ogg'  => 'audio/ogg',
    'oga'  => 'audio/ogg',
    'm4a'  => 'audio/mp4',
    'aac'  => 'audio/aac',
    'flac' => 'audio/flac',

    // Video
    'mp4'  => 'video/mp4',
    'webm' => 'video/webm',
    'mov'  => 'video/quicktime',
    'mkv'  => 'video/x-matroska',
    'avi'  => 'video/x-msvideo',
    'ogv'  => 'video/ogg',

    // Photo
    'jpg'  => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png'  => 'image/png',
    'gif'  => 'image/gif',
    'webp' => 'image/webp',
    'svg'  => 'image/svg+xml',
    'bmp'  => 'image/bmp',
    'ico'  => 'image/x-icon'
];

if (isset($content_types[$file_ext])) {
    header('Content-Type: ' . $content_types[$file_ext]);
} else {
    header('Content-Type: text/plain; charset=UTF-8');
}

// Allow direct embedding (profile pictures, <img>, <audio>, <video> tags on other sites)
header('Content-Disposition: inline; filename="' . basename($file_path) . '"');
header('Cache-Control: public, max-age=31536000, immutable');
header('Accept-Ranges: bytes');

$file_size = filesize($file_path);

// Handle HTTP Range requests so audio/video can stream and seek properly
if (isset($_SERVER['HTTP_RANGE'])) {
    $range = $_SERVER['HTTP_RANGE'];
    if (preg_match('/bytes=(\d*)-(\d*)/', $range, $matches)) {
        $start = $matches[1] === '' ? 0 : (int)$matches[1];
        $end = $matches[2] === '' ? $file_size - 1 : (int)$matches[2];
        $end = min($end, $file_size - 1);

        if ($start <= $end) {
            http_response_code(206);
            header("Content-Range: bytes $start-$end/$file_size");
            header('Content-Length: ' . ($end - $start + 1));

            $fp = fopen($file_path, 'rb');
            fseek($fp, $start);
            $bytes_left = $end - $start + 1;
            while ($bytes_left > 0 && !feof($fp)) {
                $chunk = min(8192, $bytes_left);
                echo fread($fp, $chunk);
                $bytes_left -= $chunk;
                flush();
            }
            fclose($fp);
            exit;
        }
    }
}

header('Content-Length: ' . $file_size);

// Output file content
readfile($file_path);
exit;

function showError($message) {
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Error - WASEEM HOSTING</title>
        <style>
            body { 
                font-family: 'Courier New', monospace; 
                margin: 0;
                padding: 40px;
                background: linear-gradient(135deg, #05060f, #0b0d1e);
                color: #f1f3ff;
                text-align: center;
            }
            .error-container {
                max-width: 600px;
                margin: 50px auto;
                background: rgba(0,229,255,0.06);
                border: 1px solid rgba(0,229,255,0.25);
                padding: 40px;
                border-radius: 15px;
                backdrop-filter: blur(10px);
            }
            h1 { 
                color: #f44336;
                margin-bottom: 20px;
            }
            .btn {
                display: inline-block;
                background: linear-gradient(135deg, #00e5ff, #a855f7);
                color: #05060f;
                font-weight: 700;
                padding: 12px 24px;
                text-decoration: none;
                border-radius: 8px;
                margin-top: 20px;
                transition: background 0.3s;
            }
            .btn:hover {
                background: linear-gradient(135deg, #a855f7, #ec4899);
            }
        </style>
    </head>
    <body>
        <div class='error-container'>
            <h1>❌ Error</h1>
            <p style='font-size: 1.2rem; line-height: 1.6;'>$message</p>
            <a href='index.php' class='btn'>← Back to Hosting</a>
        </div>
    </body>
    </html>";
}
?>