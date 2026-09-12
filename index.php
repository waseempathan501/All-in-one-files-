<?php
// WASEEM MULTIPLE HOSTING - Professional Web Hosting Platform
session_start();

// Handle file upload with custom URL
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Single file upload
    if (isset($_FILES['html_file']) && !empty($_FILES['html_file']['name'])) {
        $file = $_FILES['html_file'];
        $custom_url = trim($_POST['custom_url']) ?: generateCustomUrl($file['name']);
        
        if ($file['error'] === UPLOAD_ERR_OK) {
            $file_name = $file['name'];
            $file_tmp = $file['tmp_name'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            
            // Allowed file types - ONLY HTML, CSS, JS, ZIP
            $allowed_types = ['html', 'htm', 'css', 'js', 'zip'];
            
            if (in_array($file_ext, $allowed_types)) {
                if (!is_dir('sites')) {
                    mkdir('sites', 0777, true);
                }
                
                // Clean custom URL
                $custom_url = cleanCustomUrl($custom_url);
                
                if ($file_ext === 'zip') {
                    // Handle ZIP file upload
                    $result = handleZipUpload($file_tmp, $custom_url);
                    if ($result['success']) {
                        $website_url = getWebsiteUrl($custom_url);
                        $_SESSION['success'] = "ZIP Extracted! " . $result['message'];
                        $_SESSION['file_url'] = $website_url;
                        $_SESSION['file_name'] = $file_name;
                    } else {
                        $_SESSION['error'] = $result['message'];
                    }
                } else {
                    // Handle single file upload
                    $file_path = 'sites/' . $custom_url . '.' . $file_ext;
                    
                    // Check if URL already exists
                    if (file_exists($file_path)) {
                        $_SESSION['error'] = "URL taken. Choose another.";
                    } else {
                        if (move_uploaded_file($file_tmp, $file_path)) {
                            $website_url = getWebsiteUrl($custom_url);
                            $_SESSION['success'] = "Deployed Successfully!";
                            $_SESSION['file_url'] = $website_url;
                            $_SESSION['file_name'] = $file_name;
                        } else {
                            $_SESSION['error'] = "Upload failed. Permission denied.";
                        }
                    }
                }
            } else {
                $_SESSION['error'] = "Only HTML, CSS, JS, and ZIP allowed.";
            }
        } else {
            $_SESSION['error'] = "Upload Error: " . $file['error'];
        }
    }
    
    // Audio file upload
    elseif (isset($_FILES['audio_file']) && !empty($_FILES['audio_file']['name'])) {
        $file = $_FILES['audio_file'];
        $custom_url = trim($_POST['audio_custom_url']) ?: generateCustomUrl($file['name']);

        if ($file['error'] === UPLOAD_ERR_OK) {
            $file_name = $file['name'];
            $file_tmp = $file['tmp_name'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            $allowed_audio = ['mp3', 'wav', 'ogg', 'oga', 'm4a', 'aac', 'flac'];

            if (in_array($file_ext, $allowed_audio)) {
                if (!is_dir('sites')) {
                    mkdir('sites', 0777, true);
                }

                $custom_url = cleanCustomUrl($custom_url);
                $file_path = 'sites/' . $custom_url . '.' . $file_ext;

                if (file_exists($file_path)) {
                    $_SESSION['error'] = "URL taken. Choose another.";
                } else {
                    if (move_uploaded_file($file_tmp, $file_path)) {
                        $website_url = getWebsiteUrl($custom_url);
                        $_SESSION['success'] = "Audio Deployed Successfully!";
                        $_SESSION['file_url'] = $website_url;
                        $_SESSION['file_name'] = $file_name;
                    } else {
                        $_SESSION['error'] = "Upload failed. Permission denied.";
                    }
                }
            } else {
                $_SESSION['error'] = "Only MP3, WAV, OGG, M4A, AAC and FLAC audio allowed.";
            }
        } else {
            $_SESSION['error'] = "Upload Error: " . $file['error'];
        }
    }

    // Video file upload
    elseif (isset($_FILES['video_file']) && !empty($_FILES['video_file']['name'])) {
        $file = $_FILES['video_file'];
        $custom_url = trim($_POST['video_custom_url']) ?: generateCustomUrl($file['name']);

        if ($file['error'] === UPLOAD_ERR_OK) {
            $file_name = $file['name'];
            $file_tmp = $file['tmp_name'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            $allowed_video = ['mp4', 'webm', 'mov', 'mkv', 'avi', 'ogv'];

            if (in_array($file_ext, $allowed_video)) {
                if (!is_dir('sites')) {
                    mkdir('sites', 0777, true);
                }

                $custom_url = cleanCustomUrl($custom_url);
                $file_path = 'sites/' . $custom_url . '.' . $file_ext;

                if (file_exists($file_path)) {
                    $_SESSION['error'] = "URL taken. Choose another.";
                } else {
                    if (move_uploaded_file($file_tmp, $file_path)) {
                        $website_url = getWebsiteUrl($custom_url);
                        $_SESSION['success'] = "Video Deployed Successfully!";
                        $_SESSION['file_url'] = $website_url;
                        $_SESSION['file_name'] = $file_name;
                    } else {
                        $_SESSION['error'] = "Upload failed. Permission denied.";
                    }
                }
            } else {
                $_SESSION['error'] = "Only MP4, WEBM, MOV, MKV, AVI and OGV video allowed.";
            }
        } else {
            $_SESSION['error'] = "Upload Error: " . $file['error'];
        }
    }

    // Photo file upload
    elseif (isset($_FILES['photo_file']) && !empty($_FILES['photo_file']['name'])) {
        $file = $_FILES['photo_file'];
        $custom_url = trim($_POST['photo_custom_url']) ?: generateCustomUrl($file['name']);

        if ($file['error'] === UPLOAD_ERR_OK) {
            $file_name = $file['name'];
            $file_tmp = $file['tmp_name'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            $allowed_photo = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp', 'ico'];

            if (in_array($file_ext, $allowed_photo)) {
                if (!is_dir('sites')) {
                    mkdir('sites', 0777, true);
                }

                $custom_url = cleanCustomUrl($custom_url);
                $file_path = 'sites/' . $custom_url . '.' . $file_ext;

                if (file_exists($file_path)) {
                    $_SESSION['error'] = "URL taken. Choose another.";
                } else {
                    if (move_uploaded_file($file_tmp, $file_path)) {
                        $website_url = getWebsiteUrl($custom_url);
                        $_SESSION['success'] = "Photo Deployed Successfully!";
                        $_SESSION['file_url'] = $website_url;
                        $_SESSION['file_name'] = $file_name;
                    } else {
                        $_SESSION['error'] = "Upload failed. Permission denied.";
                    }
                }
            } else {
                $_SESSION['error'] = "Only JPG, PNG, GIF, WEBP, SVG, BMP and ICO photos allowed.";
            }
        } else {
            $_SESSION['error'] = "Upload Error: " . $file['error'];
        }
    }

    // Code editor upload
    elseif (isset($_POST['html_code'])) {
        $html_code = $_POST['html_code'];
        $custom_url = trim($_POST['code_custom_url']) ?: generateCustomUrl('my-website');
        
        if (!empty($html_code)) {
            if (!is_dir('sites')) {
                mkdir('sites', 0777, true);
            }
            
            $custom_url = cleanCustomUrl($custom_url);
            $file_path = 'sites/' . $custom_url . '.html';
            
            // Check if URL already exists
            if (file_exists($file_path)) {
                $_SESSION['error'] = "URL taken. Choose another.";
            } else {
                if (file_put_contents($file_path, $html_code)) {
                    $website_url = getWebsiteUrl($custom_url);
                    $_SESSION['success'] = "Code Deployed Successfully!";
                    $_SESSION['file_url'] = $website_url;
                    $_SESSION['file_name'] = $custom_url . '.html';
                } else {
                    $_SESSION['error'] = "Write error. Check permissions.";
                }
            }
        } else {
            $_SESSION['error'] = "Please enter HTML code.";
        }
    }
    // Delete a deployed project (file or ZIP-extracted folder)
    elseif (isset($_POST['delete_project'])) {
        // basename() strips any path components — blocks directory traversal
        $target = basename(trim($_POST['delete_project']));

        if ($target === '' || $target === '.' || $target === '..') {
            $_SESSION['error'] = "Invalid project.";
        } else {
            $target_path = 'sites/' . $target;

            if (is_dir($target_path)) {
                if (deleteDirectory($target_path)) {
                    $_SESSION['success'] = "Project deleted successfully.";
                } else {
                    $_SESSION['error'] = "Failed to delete project.";
                }
            } elseif (is_file($target_path)) {
                if (unlink($target_path)) {
                    $_SESSION['success'] = "Project deleted successfully.";
                } else {
                    $_SESSION['error'] = "Failed to delete project.";
                }
            } else {
                $_SESSION['error'] = "Project not found.";
            }
        }
    }
    
    header("Location: index.php");
    exit;
}

// Recursively delete a directory and all its contents
function deleteDirectory($dir) {
    if (!is_dir($dir)) {
        return false;
    }
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }
        $path = $dir . '/' . $item;
        if (is_dir($path)) {
            deleteDirectory($path);
        } else {
            unlink($path);
        }
    }
    return rmdir($dir);
}

// Handle ZIP file upload and extraction
function handleZipUpload($zip_tmp, $custom_url) {
    if (!class_exists('ZipArchive')) {
        return ['success' => false, 'message' => 'ZIP extension missing.'];
    }
    
    $zip = new ZipArchive();
    $result = ['success' => false, 'message' => ''];
    
    if ($zip->open($zip_tmp) === TRUE) {
        $extract_path = 'sites/' . $custom_url;
        
        // Create directory for extracted files
        if (!is_dir($extract_path)) {
            mkdir($extract_path, 0777, true);
        }
        
        $allowed_extensions = ['html', 'htm', 'css', 'js', 'txt', 'jpg', 'jpeg', 'png', 'gif', 'svg', 'ico', 'pdf'];
        $has_html = false;
        $extracted_files = [];
        
        // Extract allowed files only
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $filename = $zip->getNameIndex($i);
            $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            // Skip directories and non-allowed files
            if (substr($filename, -1) === '/' || !in_array($file_ext, $allowed_extensions)) {
                continue;
            }
            
            // Extract file
            $file_content = $zip->getFromIndex($i);
            $safe_filename = basename($filename);
            
            if ($file_content !== false) {
                file_put_contents($extract_path . '/' . $safe_filename, $file_content);
                $extracted_files[] = $safe_filename;
                
                if ($file_ext === 'html' || $file_ext === 'htm') {
                    $has_html = true;
                }
            }
        }
        
        $zip->close();
        
        if ($has_html) {
            $result['success'] = true;
            $result['message'] = count($extracted_files) . " files extracted.";
        } else {
            // Clean up if no HTML file found
            array_map('unlink', glob("$extract_path/*"));
            rmdir($extract_path);
            $result['message'] = "ZIP must contain an HTML file.";
        }
    } else {
        $result['message'] = "Invalid ZIP file.";
    }
    
    return $result;
}

// Generate custom URL from filename
function generateCustomUrl($filename) {
    $name = pathinfo($filename, PATHINFO_FILENAME);
    $name = preg_replace('/[^a-z0-9]/', '-', strtolower($name));
    $name = preg_replace('/-+/', '-', $name);
    $name = trim($name, '-');
    return $name ?: 'project-' . rand(1000,9999);
}

// Clean custom URL
function cleanCustomUrl($url) {
    $url = preg_replace('/[^a-z0-9-]/', '', strtolower($url));
    $url = preg_replace('/-+/', '-', $url);
    $url = trim($url, '-');
    return $url ?: 'project-' . rand(1000,9999);
}

// Get website full URL
function getWebsiteUrl($path) {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $base_url = $protocol . '://' . $host . dirname($_SERVER['PHP_SELF']);
    return rtrim($base_url, '/') . '/view.php?site=' . $path;
}

// Get list of uploaded sites
$uploaded_sites = [];
$total_size = 0;

if (is_dir('sites')) {
    $files = scandir('sites');
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            $file_path = 'sites/' . $file;
            
            if (is_dir($file_path)) {
                // Handle directory (ZIP extracted sites)
                $html_files = glob($file_path . '/*.{html,htm}', GLOB_BRACE);
                if (!empty($html_files)) {
                    $main_file = basename($html_files[0]);
                    $site_name = $file;
                    
                    $uploaded_sites[] = [
                        'name' => $site_name,
                        'filename' => $file,
                        'url' => getWebsiteUrl($site_name),
                        'time' => filemtime($file_path),
                        'size' => getDirectorySize($file_path),
                        'type' => 'zip',
                        'is_dir' => true
                    ];
                    
                    $total_size += getDirectorySize($file_path);
                }
            } else {
                // Handle single files
                $file_ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                
                // Only show allowed file types
                if (in_array($file_ext, ['html', 'htm', 'css', 'js', 'mp3', 'wav', 'ogg', 'oga', 'm4a', 'aac', 'flac', 'mp4', 'webm', 'mov', 'mkv', 'avi', 'ogv', 'jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp', 'ico'])) {
                    $site_name = pathinfo($file, PATHINFO_FILENAME);
                    
                    $uploaded_sites[] = [
                        'name' => $site_name,
                        'filename' => $file,
                        'url' => getWebsiteUrl($site_name),
                        'time' => filemtime($file_path),
                        'size' => filesize($file_path),
                        'type' => $file_ext,
                        'is_dir' => false
                    ];
                    
                    $total_size += filesize($file_path);
                }
            }
        }
    }
    
    // Sort by newest first
    usort($uploaded_sites, function($a, $b) {
        return $b['time'] - $a['time'];
    });
}

// Get directory size recursively
function getDirectorySize($path) {
    $total_size = 0;
    $files = scandir($path);
    
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            $file_path = $path . '/' . $file;
            if (is_file($file_path)) {
                $total_size += filesize($file_path);
            } elseif (is_dir($file_path)) {
                $total_size += getDirectorySize($file_path);
            }
        }
    }
    
    return $total_size;
}

// Convert bytes to human readable format
function formatSize($bytes) {
    if ($bytes == 0) return '0 B';
    $units = ['B', 'KB', 'MB', 'GB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, 2) . ' ' . $units[$pow];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Prevent Zooming -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">
    <!-- Prevent iOS zoom on input focus -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">

    <!-- ============================================================
         SEO — Primary Meta Tags
         Title/description are written so Google shows "Waseem Hosting"
         as the result name when someone searches that term.
         ============================================================ -->
    <title>Waseem Hosting | Free Static Website Hosting Platform</title>
    <meta name="title" content="Waseem Hosting | Free Static Website Hosting Platform">
    <meta name="description" content="Waseem Hosting is a free cloud platform to deploy HTML, CSS, JS and ZIP websites instantly. Upload your project and get a live link in seconds — fast, secure and reliable.">
    <meta name="keywords" content="Waseem Hosting, waseem hosting, free website hosting, deploy html online, free static site hosting, html css js hosting, free cloud hosting">
    <meta name="author" content="Waseem Hosting">
    <meta name="robots" content="index, follow">
    <meta name="language" content="English">
    <meta name="revisit-after" content="1 days">

    <!-- Canonical URL — prevents duplicate-content issues with Google -->
    <link rel="canonical" href="https://waseemkhan.kesug.com/">

    <!-- ============================================================
         GOOGLE SEARCH CONSOLE VERIFICATION
         Paste the content value Google gives you into the line below
         (keep the tag, just replace PASTE_YOUR_CODE_HERE), e.g.:
         <meta name="google-site-verification" content="abc123XYZ..." />
         ============================================================ -->
    <meta name="google-site-verification" content="_uDcyFiKVhkQ7zJmCuh-havKKzH2EHFOiAb8E5TzM1U" />

    <!-- Open Graph / Facebook / WhatsApp link previews -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://waseemkhan.kesug.com/">
    <meta property="og:title" content="Waseem Hosting | Free Static Website Hosting Platform">
    <meta property="og:description" content="Deploy HTML, CSS, JS and ZIP websites instantly with Waseem Hosting — free, fast and reliable cloud hosting.">
    <meta property="og:image" content="https://raw.githubusercontent.com/waseempathan501/Photo-link-/refs/heads/main/IMG-20260625-WA0003.jpg">
    <meta property="og:site_name" content="Waseem Hosting">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="https://waseemkhan.kesug.com/">
    <meta name="twitter:title" content="Waseem Hosting | Free Static Website Hosting Platform">
    <meta name="twitter:description" content="Deploy HTML, CSS, JS and ZIP websites instantly with Waseem Hosting — free, fast and reliable cloud hosting.">
    <meta name="twitter:image" content="https://raw.githubusercontent.com/waseempathan501/Photo-link-/refs/heads/main/IMG-20260625-WA0003.jpg">

    <!-- Favicon (uses your profile photo) -->
    <link rel="icon" type="image/jpeg" href="https://raw.githubusercontent.com/waseempathan501/Photo-link-/refs/heads/main/IMG-20260625-WA0003.jpg">
    <link rel="apple-touch-icon" href="https://raw.githubusercontent.com/waseempathan501/Photo-link-/refs/heads/main/IMG-20260625-WA0003.jpg">

    <!-- Structured Data — tells Google this brand's exact name is "Waseem Hosting" -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "Waseem Hosting",
      "alternateName": "WASEEM HOSTING",
      "url": "https://waseemkhan.kesug.com/",
      "logo": "https://raw.githubusercontent.com/waseempathan501/Photo-link-/refs/heads/main/IMG-20260625-WA0003.jpg",
      "sameAs": [
        "https://whatsapp.com/channel/0029VbD4m3ZFCCoWbOzY3x2S",
        "https://tiktok.com/@waseempathan902"
      ]
    }
    </script>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      "name": "Waseem Hosting",
      "url": "https://waseemkhan.kesug.com/"
    }
    </script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Animated Waves Background (Three.js + Vanta) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.waves.min.js"></script>
    
    <style>
        /* Prevent Zooming and Overflow */
        html {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            text-size-adjust: 100%;
            touch-action: manipulation;
            overflow-x: hidden;
            width: 100%;
            max-width: 100%;
        }

        body {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            touch-action: pan-y;
            overflow-x: hidden;
            width: 100%;
            max-width: 100%;
            position: relative;
            margin: 0;
            padding: 0;
        }

        /* Allow text selection in form fields */
        input, textarea {
            -webkit-user-select: text;
            -moz-user-select: text;
            -ms-user-select: text;
            user-select: text;
        }

        :root {
            /* Aurora Cyber Theme — cyan / violet / magenta over deep indigo-black */
            --bg-primary: #05060f;
            --bg-secondary: #0b0d1e;
            --bg-tertiary: #12142b;
            
            --primary: #00e5ff;
            --primary-dark: #00b8d4;
            --secondary: #a855f7;
            --accent: #ec4899;
            --success: #4caf50;
            --warning: #ffb300;
            --danger: #f44336;
            
            --text-primary: #f1f3ff;
            --text-secondary: #c9cdf0;
            --text-muted: #8286ab;
            
            --border-color: #1e2140;
            --border-light: rgba(0, 229, 255, 0.2);
            
            --radius-lg: 12px;
            --radius-md: 8px;
            --radius-sm: 4px;
            
            --shadow-lg: 0 20px 40px rgba(0, 229, 255, 0.2);
            --shadow-md: 0 10px 20px rgba(0, 229, 255, 0.15);
            --shadow-sm: 0 4px 12px rgba(0, 229, 255, 0.1);
            
            --glow-primary: 0 0 15px rgba(0, 229, 255, 0.5);
            --glow-secondary: 0 0 25px rgba(168, 85, 247, 0.3);
            
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
            -webkit-tap-highlight-color: transparent;
        }

        /* Animated Waves Background (Three.js + Vanta) */
        #vanta-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
            max-width: 100vw;
            overflow: hidden;
        }

        /* Loader */
        .loader-overlay {
            position: fixed;
            inset: 0;
            background: var(--bg-primary);
            z-index: 10000;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            transition: opacity 0.8s ease;
        }

        .loader-text {
            margin-top: 30px;
            font-weight: 600;
            color: var(--text-secondary);
            letter-spacing: 1px;
            text-shadow: 0 0 10px rgba(0, 229, 255, 0.5);
            font-size: 1.2rem;
        }

        @keyframes spin { 
            100% { 
                transform: rotate(360deg); 
            } 
        }

        /* Circle Loader with Image */
        .loader-circle {
            width: 150px;
            height: 150px;
            position: relative;
        }

        .loader-circle::before {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: var(--primary);
            border-right-color: var(--secondary);
            animation: spin 2s linear infinite;
            box-shadow: var(--glow-primary);
        }

        .loader-circle::after {
            content: '';
            position: absolute;
            top: -20px;
            left: -20px;
            right: -20px;
            bottom: -20px;
            border-radius: 50%;
            border: 2px solid transparent;
            border-bottom-color: var(--accent);
            border-left-color: rgba(236, 72, 153, 0.3);
            animation: spinReverse 3s linear infinite;
        }

        .loader-image {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 
                0 0 30px rgba(0, 229, 255, 0.5),
                inset 0 0 20px rgba(255, 255, 255, 0.1);
            overflow: hidden;
            position: relative;
            z-index: 2;
        }

        .loader-image::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: conic-gradient(
                from 0deg,
                transparent,
                rgba(255, 255, 255, 0.3),
                transparent
            );
            animation: rotate360 2s linear infinite;
            z-index: 1;
        }

        .loader-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center 15%;
            z-index: 3;
            border-radius: 50%;
            filter: brightness(1.1) contrast(1.1);
            border: 3px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }

        @keyframes spinReverse {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(-360deg);
            }
        }

        @keyframes rotate360 {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        /* Pulse animation for loader */
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 0 30px rgba(0, 229, 255, 0.5);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 0 40px rgba(168, 85, 247, 0.7);
            }
        }

        .loader-image {
            animation: pulse 2s infinite ease-in-out;
        }

        /* Container - Prevent Horizontal Scroll */
        .container {
            max-width: 100%;
            width: 100%;
            margin: 0 auto;
            padding: 15px;
            overflow-x: hidden;
            box-sizing: border-box;
        }

        @media (min-width: 768px) {
            .container {
                max-width: 1280px;
                padding: 20px;
            }
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
            width: 100%;
            box-sizing: border-box;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: inherit;
            min-width: 0;
        }

        .brand-logo {
            width: 45px;
            height: 45px;
            min-width: 45px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: var(--radius-md);
            display: grid;
            place-items: center;
            font-size: 22px;
            color: white;
            box-shadow: var(--glow-primary);
            animation: pulseGlow 2s infinite alternate;
        }

        @keyframes pulseGlow {
            0% {
                box-shadow: var(--glow-primary);
            }
            100% {
                box-shadow: 0 0 25px rgba(0, 229, 255, 0.7), var(--glow-primary);
            }
        }

        .brand-text {
            min-width: 0;
            overflow: hidden;
        }

        .brand-text h1 {
            font-size: 20px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px;
            text-shadow: 0 0 20px rgba(0, 229, 255, 0.3);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .brand-text span {
            color: var(--text-muted);
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            white-space: nowrap;
        }

        /* Social Links */
        .social-links {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
        }

        .social-btn {
            width: 40px;
            height: 40px;
            min-width: 40px;
            border-radius: var(--radius-md);
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            display: grid;
            place-items: center;
            color: var(--text-secondary);
            text-decoration: none;
            transition: var(--transition);
            flex-shrink: 0;
        }

        .social-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
            border-color: var(--primary);
        }

        .social-btn.whatsapp:hover {
            background: #25D366;
            color: white;
            border-color: #25D366;
            box-shadow: 0 0 15px rgba(37, 211, 102, 0.4);
        }

        .social-btn.tiktok:hover {
            background: #000000;
            color: #25F4EE;
            border-color: #000000;
            box-shadow: 0 0 15px rgba(37, 244, 238, 0.4);
        }

        /* Hero */
        .hero {
            text-align: center;
            margin-bottom: 40px;
            width: 100%;
            box-sizing: border-box;
        }

        .hero h2 {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 15px;
            line-height: 1.2;
            min-height: 2.6em;
            text-shadow: 0 0 30px rgba(0, 229, 255, 0.3);
            animation: textGlow 3s infinite alternate;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        @keyframes textGlow {
            0% {
                text-shadow: 0 0 30px rgba(0, 229, 255, 0.3);
            }
            100% {
                text-shadow: 0 0 40px rgba(168, 85, 247, 0.4);
            }
        }

        /* Typewriter caret used on auto-typing brand / hero text */
        .typewriter-cursor::after {
            content: '';
            display: inline-block;
            width: 3px;
            height: 0.9em;
            margin-left: 4px;
            vertical-align: -0.12em;
            background: var(--primary);
            -webkit-text-fill-color: var(--primary);
            box-shadow: 0 0 8px var(--primary), 0 0 16px rgba(0, 229, 255, 0.5);
            animation: blinkCursor 0.85s steps(1) infinite;
        }

        @keyframes blinkCursor {
            0%, 50% { opacity: 1; }
            50.01%, 100% { opacity: 0; }
        }

        .hero p {
            font-size: 1rem;
            color: var(--text-secondary);
            max-width: 100%;
            margin: 0 auto 30px;
            line-height: 1.5;
            padding: 0 10px;
            box-sizing: border-box;
        }

        /* Stats Bar */
        .stats-bar {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
            width: 100%;
        }

        .stat-item {
            text-align: center;
            padding: 15px;
            background: rgba(0, 229, 255, 0.05);
            border-radius: var(--radius-lg);
            border: 1px solid rgba(0, 229, 255, 0.1);
            backdrop-filter: blur(10px);
            transition: var(--transition);
            flex: 1;
            min-width: 120px;
            max-width: 200px;
        }

        .stat-item:hover {
            border-color: var(--primary);
            box-shadow: var(--shadow-md);
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 5px;
            text-shadow: 0 0 10px rgba(0, 229, 255, 0.3);
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        /* Dashboard */
        .dashboard {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            margin-bottom: 40px;
            width: 100%;
            box-sizing: border-box;
        }

        @media (min-width: 968px) { 
            .dashboard { 
                grid-template-columns: 1fr 1fr; 
                gap: 30px;
            } 
        }

        /* Cards */
        .card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 20px;
            transition: var(--transition);
            box-shadow: var(--shadow-md);
            backdrop-filter: blur(10px);
            width: 100%;
            box-sizing: border-box;
            overflow: hidden;
        }

        .card:hover {
            box-shadow: var(--shadow-lg);
            border-color: var(--primary);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
            width: 100%;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .card-title i {
            color: var(--primary);
            text-shadow: 0 0 10px rgba(0, 229, 255, 0.5);
            flex-shrink: 0;
        }

        /* Tabs */
        .tabs {
            display: flex;
            background: var(--bg-tertiary);
            border-radius: var(--radius-md);
            padding: 4px;
            margin-bottom: 20px;
            border: 1px solid var(--border-color);
            width: 100%;
        }

        .tab {
            flex: 1;
            padding: 10px 8px;
            text-align: center;
            cursor: pointer;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-muted);
            transition: var(--transition);
            white-space: nowrap;
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .tab:hover {
            color: var(--text-primary);
            background: rgba(0, 229, 255, 0.1);
        }

        .tab.active {
            background: linear-gradient(135deg, rgba(0, 229, 255, 0.2), rgba(168, 85, 247, 0.1));
            color: var(--text-primary);
            box-shadow: var(--shadow-sm);
        }

        .tab-content {
            display: none;
            animation: fadeIn 0.3s ease;
            width: 100%;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Forms */
        .form-group {
            margin-bottom: 20px;
            width: 100%;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            width: 100%;
        }

        input, textarea {
            width: 100%;
            padding: 12px 14px;
            background: var(--bg-tertiary);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            color: var(--text-primary);
            font-family: inherit;
            font-size: 0.9rem;
            transition: var(--transition);
            box-sizing: border-box;
            -webkit-appearance: none;
            appearance: none;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 229, 255, 0.2), var(--glow-primary);
        }

        textarea {
            min-height: 150px;
            resize: vertical;
            font-family: 'Consolas', 'Monaco', monospace;
            font-size: 0.85rem;
        }

        /* URL Preview */
        .url-box {
            margin-top: 8px;
            padding: 10px;
            background: var(--bg-tertiary);
            border-radius: var(--radius-md);
            border: 1px solid var(--border-color);
            font-family: 'Consolas', 'Monaco', monospace;
            font-size: 0.8rem;
            color: var(--accent);
            border-left: 3px solid var(--primary);
            word-break: break-all;
            width: 100%;
            box-sizing: border-box;
        }

        /* File Upload */
        .upload-zone {
            border: 2px dashed var(--border-color);
            border-radius: var(--radius-lg);
            padding: 30px 20px;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            background: var(--bg-tertiary);
            width: 100%;
            box-sizing: border-box;
        }

        .upload-zone:hover {
            border-color: var(--primary);
            background: rgba(0, 229, 255, 0.05);
            box-shadow: var(--shadow-sm);
        }

        .upload-icon {
            font-size: 40px;
            margin-bottom: 15px;
            color: var(--primary);
            text-shadow: 0 0 15px rgba(0, 229, 255, 0.3);
        }

        /* Buttons */
        .btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: var(--radius-md);
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: var(--transition);
            text-decoration: none;
            position: relative;
            overflow: hidden;
            box-sizing: border-box;
            -webkit-appearance: none;
            appearance: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md), var(--glow-primary);
        }

        .btn-primary::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: rotate(45deg);
            transition: var(--transition);
            opacity: 0;
        }

        .btn-primary:hover::after {
            opacity: 1;
            animation: shine 1.5s ease;
        }

        @keyframes shine {
            0% {
                transform: translateX(-100%) translateY(-100%) rotate(45deg);
            }
            100% {
                transform: translateX(100%) translateY(100%) rotate(45deg);
            }
        }

        .btn-icon {
            padding: 6px;
            width: 34px;
            height: 34px;
            min-width: 34px;
            border-radius: var(--radius-md);
            background: var(--bg-tertiary);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            cursor: pointer;
            display: grid;
            place-items: center;
            transition: var(--transition);
            flex-shrink: 0;
        }

        .btn-icon:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            box-shadow: var(--glow-primary);
        }

        .btn-icon.danger:hover {
            background: var(--danger);
            color: white;
            border-color: var(--danger);
            box-shadow: 0 0 15px rgba(244, 67, 54, 0.4);
        }

        /* Site List */
        .site-list {
            max-height: 400px;
            overflow-y: auto;
            padding-right: 5px;
            width: 100%;
        }

        .site-list::-webkit-scrollbar {
            width: 4px;
        }

        .site-list::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: var(--radius-md);
        }

        .site-item {
            display: flex;
            align-items: center;
            padding: 15px;
            background: var(--bg-tertiary);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            margin-bottom: 10px;
            transition: var(--transition);
            width: 100%;
            box-sizing: border-box;
        }

        .site-item:hover {
            border-color: var(--primary);
            transform: translateX(4px);
            box-shadow: var(--shadow-sm);
        }

        .file-icon {
            width: 45px;
            height: 45px;
            min-width: 45px;
            border-radius: var(--radius-md);
            display: grid;
            place-items: center;
            font-size: 1.3rem;
            margin-right: 12px;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            flex-shrink: 0;
        }

        .icon-html { 
            color: #00e5ff; 
            text-shadow: 0 0 10px rgba(0, 229, 255, 0.3);
        }
        .icon-css { 
            color: #a855f7; 
            text-shadow: 0 0 10px rgba(168, 85, 247, 0.3);
        }
        .icon-js { 
            color: #ec4899; 
            text-shadow: 0 0 10px rgba(236, 72, 153, 0.3);
        }
        .icon-zip { 
            color: var(--text-muted); 
        }
        .icon-audio { 
            color: #22d3ee; 
            text-shadow: 0 0 10px rgba(34, 211, 238, 0.3);
        }
        .icon-video { 
            color: #f97316; 
            text-shadow: 0 0 10px rgba(249, 115, 22, 0.3);
        }
        .icon-photo { 
            color: #4ade80; 
            text-shadow: 0 0 10px rgba(74, 222, 128, 0.3);
        }

        .site-info {
            flex: 1;
            min-width: 0;
            overflow: hidden;
        }

        .site-name {
            font-weight: 700;
            color: var(--text-primary);
            display: block;
            margin-bottom: 3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .site-link {
            font-size: 0.8rem;
            color: var(--primary);
            text-decoration: none;
            display: block;
            margin-bottom: 3px;
            transition: var(--transition);
            word-break: break-all;
            overflow-wrap: break-word;
        }

        .site-link:hover {
            text-decoration: underline;
            text-shadow: 0 0 10px rgba(0, 229, 255, 0.3);
        }

        .site-meta {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 25px;
            width: 100%;
        }

        .stat-card {
            background: var(--bg-tertiary);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 15px;
            text-align: center;
            transition: var(--transition);
            box-sizing: border-box;
        }

        .stat-card:hover {
            border-color: var(--primary);
            box-shadow: var(--shadow-sm);
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 5px;
            text-shadow: 0 0 10px rgba(0, 229, 255, 0.3);
        }

        .stat-label {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        /* Alerts */
        .alert {
            padding: 15px 20px;
            border-radius: var(--radius-md);
            margin-bottom: 25px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            animation: slideDown 0.4s ease;
            border-left: 4px solid;
            backdrop-filter: blur(10px);
            width: 100%;
            box-sizing: border-box;
        }

        .alert-success {
            background: rgba(76, 175, 80, 0.1);
            border-color: var(--success);
            color: var(--success);
        }

        .alert-error {
            background: rgba(244, 67, 54, 0.1);
            border-color: var(--danger);
            color: var(--danger);
        }

        .alert i {
            font-size: 1.1rem;
            margin-top: 2px;
            flex-shrink: 0;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Toast */
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--bg-secondary);
            border: 1px solid var(--primary);
            color: var(--text-primary);
            padding: 14px 20px;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-lg), var(--glow-primary);
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 1000;
            transform: translateY(100px);
            opacity: 0;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.4s;
            backdrop-filter: blur(10px);
            max-width: 90%;
            box-sizing: border-box;
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 30px 0;
            color: var(--text-muted);
            font-size: 0.85rem;
            border-top: 1px solid var(--border-color);
            margin-top: 30px;
            backdrop-filter: blur(10px);
            width: 100%;
            box-sizing: border-box;
        }

        footer p {
            margin-bottom: 8px;
        }

        /* Utility Classes */
        .text-gradient {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 20px rgba(0, 229, 255, 0.3);
        }

        .border-gradient {
            border: 2px solid transparent;
            background: linear-gradient(var(--bg-secondary), var(--bg-secondary)) padding-box,
                        linear-gradient(135deg, var(--primary), var(--secondary)) border-box;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .hero h2 {
                font-size: 1.8rem;
            }
            
            .hero p {
                font-size: 0.9rem;
            }
            
            .stats-bar {
                gap: 10px;
            }
            
            .stat-item {
                padding: 12px;
                min-width: 100px;
            }
            
            .stat-number {
                font-size: 1.2rem;
            }
            
            .card {
                padding: 15px;
            }
            
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .loader-circle {
                width: 120px;
                height: 120px;
            }
            
            .loader-text {
                font-size: 1rem;
            }
            
            .brand-logo {
                width: 40px;
                height: 40px;
                font-size: 20px;
            }
            
            .brand-text h1 {
                font-size: 18px;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 10px;
            }
            
            .hero h2 {
                font-size: 1.5rem;
            }
            
            .card-title {
                font-size: 1.1rem;
            }
            
            .tab {
                font-size: 0.8rem;
                padding: 8px 6px;
            }
            
            .site-item {
                flex-wrap: wrap;
                gap: 10px;
            }
            
            .site-info {
                min-width: 100%;
            }
            
            .file-icon {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }
        }

        /* Prevent iOS zoom on input focus */
        @media screen and (max-width: 768px) {
            input[type="text"],
            input[type="url"],
            textarea {
                font-size: 16px !important;
            }
        }

        /* Hide scrollbar but keep functionality */
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>
<body>

    <div id="vanta-bg"></div>

    <!-- Loader with Your Image -->
    <div class="loader-overlay" id="loader">
        <div class="loader-circle">
            <div class="loader-image">
                <img src="https://raw.githubusercontent.com/waseemkhan902/Photo-link-/refs/heads/main/1775290816704.jpg" alt="WASEEM MULTIPLE HOSTING Loading">
            </div>
        </div>
        <div class="loader-text">INITIALIZING WASEEM HOSTING</div>
    </div>

    <!-- Toast Notification -->
    <div class="toast" id="toast">
        <i class="fas fa-check-circle" style="color: var(--success)"></i>
        <span id="toast-msg">Action Successful</span>
    </div>

    <div class="container">
        <!-- Header -->
        <header class="header">
            <div>
                <a href="#" class="brand">
                    <div class="brand-logo"><i class="fas fa-fire"></i></div>
                    <div class="brand-text">
                        <h1 id="brandTypewriter" class="typewriter-cursor">WASEEM MULTIPLE HOSTING</h1>
                        <span>Secure. Swift. Reliable.</span>
                    </div>
                </a>
            </div>
            
            <div class="social-links">
                <a href="https://whatsapp.com/channel/0029VbD4m3ZFCCoWbOzY3x2S" target="_blank" class="social-btn whatsapp" title="WhatsApp Channel">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <a href="https://tiktok.com/@waseempathan902" target="_blank" class="social-btn tiktok" title="TikTok">
                    <i class="fab fa-tiktok"></i>
                </a>
            </div>
        </header>

        <!-- Hero -->
        <div class="hero">
            <h2 id="heroTypewriter" class="typewriter-cursor">Deploy Your Code in Seconds</h2>
            <p>Host your static websites, code, audio, video and photos on a secure, high-speed cloud network built for developers who demand speed, control and uptime.</p>
            
            <div class="stats-bar">
                <div class="stat-item">
                    <div class="stat-number"><?php echo count($uploaded_sites); ?></div>
                    <div class="stat-label">Active Sites</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number"><?php echo formatSize($total_size); ?></div>
                    <div class="stat-label">Storage Used</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">99.9%</div>
                    <div class="stat-label">Uptime</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">∞</div>
                    <div class="stat-label">Bandwidth</div>
                </div>
            </div>
        </div>

        <!-- System Messages -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-fire"></i>
                <div>
                    <?php echo $_SESSION['success']; ?>
                    <?php if (isset($_SESSION['file_url'])): ?>
                        <div style="margin-top: 8px; font-size: 0.85rem; word-break: break-all;">
                            Live URL: <a href="<?php echo $_SESSION['file_url']; ?>" target="_blank" style="color: inherit; text-decoration: underline;"><?php echo $_SESSION['file_url']; ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php unset($_SESSION['success'], $_SESSION['file_url'], $_SESSION['file_name']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i>
                <?php echo $_SESSION['error']; ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <!-- Dashboard -->
        <div class="dashboard">
            
            <!-- Deployment Panel -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><i class="fas fa-fire"></i> Launch New Project</div>
                </div>

                <div class="tabs">
                    <div class="tab active" onclick="switchTab('tab-upload')">Files</div>
                    <div class="tab" onclick="switchTab('tab-editor')">Code</div>
                    <div class="tab" onclick="switchTab('tab-audio')">Audio</div>
                    <div class="tab" onclick="switchTab('tab-video')">Video</div>
                    <div class="tab" onclick="switchTab('tab-photo')">Photo</div>
                </div>

                <!-- Upload Tab -->
                <div id="tab-upload" class="tab-content active">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Project Name</label>
                            <input type="text" name="custom_url" id="inp-url" placeholder="my-blazing-site" required>
                            <div class="url-box">
                                .../view.php?site=<span id="prev-url">my-blazing-site</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Upload Files</label>
                            <div class="upload-zone" onclick="document.getElementById('file-input').click()">
                                <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                <div style="font-weight: 700; font-size: 1rem; color: var(--text-primary); margin-bottom: 6px;">
                                    Drop or click to upload
                                </div>
                                <div style="color: var(--text-muted); font-size: 0.85rem;">
                                    HTML, CSS, JS or ZIP archives
                                </div>
                                <div id="file-name" style="margin-top: 12px; color: var(--primary); font-size: 0.85rem;"></div>
                            </div>
                            <input type="file" name="html_file" id="file-input" style="display: none;" onchange="updateFile(this)" required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> IGNITE DEPLOYMENT
                        </button>
                    </form>
                </div>

                <!-- Editor Tab -->
                <div id="tab-editor" class="tab-content">
                    <form method="POST">
                        <div class="form-group">
                            <label>Project Name</label>
                            <input type="text" name="code_custom_url" id="inp-code-url" placeholder="my-code-project" required>
                            <div class="url-box">
                                .../view.php?site=<span id="prev-code-url">my-code-project</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>HTML Source Code</label>
                            <textarea name="html_code" placeholder="<!DOCTYPE html>
<html>
<head>
    <title>My Blazing Project</title>
</head>
<body>
    <!-- Your code here -->
</body>
</html>" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-code"></i> BUILD & LAUNCH
                        </button>
                    </form>
                </div>

                <!-- Audio Tab -->
                <div id="tab-audio" class="tab-content">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Project Name</label>
                            <input type="text" name="audio_custom_url" id="inp-audio-url" placeholder="my-podcast-track" required>
                            <div class="url-box">
                                .../view.php?site=<span id="prev-audio-url">my-podcast-track</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Upload Audio</label>
                            <div class="upload-zone" onclick="document.getElementById('audio-input').click()">
                                <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                <div style="font-weight: 700; font-size: 1rem; color: var(--text-primary); margin-bottom: 6px;">
                                    Drop or click to upload
                                </div>
                                <div style="color: var(--text-muted); font-size: 0.85rem;">
                                    MP3, WAV, OGG, M4A, AAC or FLAC
                                </div>
                                <div id="audio-name" style="margin-top: 12px; color: var(--primary); font-size: 0.85rem;"></div>
                            </div>
                            <input type="file" name="audio_file" id="audio-input" accept="audio/*" style="display: none;" onchange="updateFile(this, 'audio-name', 'inp-audio-url', 'prev-audio-url')" required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> IGNITE DEPLOYMENT
                        </button>
                    </form>
                </div>

                <!-- Video Tab -->
                <div id="tab-video" class="tab-content">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Project Name</label>
                            <input type="text" name="video_custom_url" id="inp-video-url" placeholder="my-highlight-clip" required>
                            <div class="url-box">
                                .../view.php?site=<span id="prev-video-url">my-highlight-clip</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Upload Video</label>
                            <div class="upload-zone" onclick="document.getElementById('video-input').click()">
                                <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                <div style="font-weight: 700; font-size: 1rem; color: var(--text-primary); margin-bottom: 6px;">
                                    Drop or click to upload
                                </div>
                                <div style="color: var(--text-muted); font-size: 0.85rem;">
                                    MP4, WEBM, MOV, MKV, AVI or OGV
                                </div>
                                <div id="video-name" style="margin-top: 12px; color: var(--primary); font-size: 0.85rem;"></div>
                            </div>
                            <input type="file" name="video_file" id="video-input" accept="video/*" style="display: none;" onchange="updateFile(this, 'video-name', 'inp-video-url', 'prev-video-url')" required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> IGNITE DEPLOYMENT
                        </button>
                    </form>
                </div>

                <!-- Photo Tab -->
                <div id="tab-photo" class="tab-content">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Project Name</label>
                            <input type="text" name="photo_custom_url" id="inp-photo-url" placeholder="my-profile-picture" required>
                            <div class="url-box">
                                .../view.php?site=<span id="prev-photo-url">my-profile-picture</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Upload Photo</label>
                            <div class="upload-zone" onclick="document.getElementById('photo-input').click()">
                                <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                <div style="font-weight: 700; font-size: 1rem; color: var(--text-primary); margin-bottom: 6px;">
                                    Drop or click to upload
                                </div>
                                <div style="color: var(--text-muted); font-size: 0.85rem;">
                                    JPG, PNG, GIF, WEBP, SVG, BMP or ICO
                                </div>
                                <div id="photo-name" style="margin-top: 12px; color: var(--primary); font-size: 0.85rem;"></div>
                            </div>
                            <input type="file" name="photo_file" id="photo-input" accept="image/*" style="display: none;" onchange="updateFile(this, 'photo-name', 'inp-photo-url', 'prev-photo-url')" required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> IGNITE DEPLOYMENT
                        </button>
                    </form>
                </div>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-value"><?php echo count($uploaded_sites); ?></div>
                        <div class="stat-label">Live Projects</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value"><?php echo formatSize($total_size); ?></div>
                        <div class="stat-label">Storage Used</div>
                    </div>
                </div>
            </div>

            <!-- Projects Panel -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><i class="fas fa-layer-group"></i> Active Projects</div>
                </div>

                <div class="site-list">
                    <?php if(empty($uploaded_sites)): ?>
                        <div style="text-align: center; padding: 40px 20px; color: var(--text-muted);">
                            <i class="fas fa-fire" style="font-size: 2.5rem; margin-bottom: 15px; opacity: 0.5; color: var(--primary);"></i>
                            <p style="font-size: 1rem; margin-bottom: 8px;">No projects deployed yet</p>
                            <p style="font-size: 0.85rem;">Ignite your first project to get started</p>
                        </div>
                    <?php else: ?>
                        <?php foreach($uploaded_sites as $site): ?>
                            <div class="site-item">
                                <?php 
                                    $iconClass = 'icon-zip'; $faIcon = 'fa-file-archive'; $faFamily = 'fas';
                                    $audio_ext = ['mp3','wav','ogg','oga','m4a','aac','flac'];
                                    $video_ext = ['mp4','webm','mov','mkv','avi','ogv'];
                                    $photo_ext = ['jpg','jpeg','png','gif','webp','svg','bmp','ico'];
                                    if($site['type']=='html' || $site['type']=='htm') { $iconClass = 'icon-html'; $faIcon = 'fa-html5'; $faFamily = 'fab'; }
                                    elseif($site['type']=='css') { $iconClass = 'icon-css'; $faIcon = 'fa-css3-alt'; $faFamily = 'fab'; }
                                    elseif($site['type']=='js') { $iconClass = 'icon-js'; $faIcon = 'fa-js'; $faFamily = 'fab'; }
                                    elseif(in_array($site['type'], $audio_ext)) { $iconClass = 'icon-audio'; $faIcon = 'fa-file-audio'; $faFamily = 'fas'; }
                                    elseif(in_array($site['type'], $video_ext)) { $iconClass = 'icon-video'; $faIcon = 'fa-file-video'; $faFamily = 'fas'; }
                                    elseif(in_array($site['type'], $photo_ext)) { $iconClass = 'icon-photo'; $faIcon = 'fa-file-image'; $faFamily = 'fas'; }
                                ?>
                                <div class="file-icon <?php echo $iconClass; ?>">
                                    <i class="<?php echo $faFamily; ?> <?php echo $faIcon; ?>"></i>
                                </div>
                                <div class="site-info">
                                    <span class="site-name"><?php echo $site['name']; ?></span>
                                    <a href="<?php echo $site['url']; ?>" target="_blank" class="site-link">
                                        <?php echo substr($site['url'], 0, 35) . '...'; ?>
                                        <i class="fas fa-external-link-alt" style="font-size: 0.8em; margin-left: 5px;"></i>
                                    </a>
                                    <div class="site-meta">
                                        <?php echo formatSize($site['size']); ?> • <?php echo date('M j, Y - g:i A', $site['time']); ?>
                                    </div>
                                </div>
                                <div style="display: flex; gap: 6px; flex-shrink: 0;">
                                    <button class="btn-icon" onclick="copyLink('<?php echo $site['url']; ?>')" title="Copy URL">
                                        <i class="fas fa-link"></i>
                                    </button>
                                    <a href="<?php echo $site['url']; ?>" target="_blank" class="btn-icon" title="Open Site">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                    <button type="button" class="btn-icon danger" onclick="deleteProject('<?php echo htmlspecialchars($site['filename'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($site['name'], ENT_QUOTES); ?>')" title="Delete Project">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Hidden form used by deleteProject() to POST the delete request -->
        <form id="deleteForm" method="POST" style="display: none;">
            <input type="hidden" name="delete_project" id="deleteProjectInput" value="">
        </form>

        <footer>
            <p>&copy; <?php echo date('Y'); ?> <strong class="text-gradient">WASEEM MULTIPLE HOSTING</strong>. Powered by WASEEM PRO HACKER.</p>
            <p style="font-size: 0.75rem; margin-top: 8px;">
                <a href="https://whatsapp.com/channel/0029VbD4m3ZFCCoWbOzY3x2S" target="_blank" style="color: var(--text-muted); text-decoration: none; margin: 0 8px;">
                    <i class="fab fa-whatsapp"></i> WhatsApp Channel
                </a>
                |
                <a href="https://tiktok.com/@waseempathan902" target="_blank" style="color: var(--text-muted); text-decoration: none; margin: 0 8px;">
                    <i class="fab fa-tiktok"></i> TikTok
                </a>
            </p>
        </footer>
    </div>

    <script>
        // Initialize loader
        window.onload = function() {
            setTimeout(() => {
                const loader = document.getElementById('loader');
                loader.style.opacity = '0';
                setTimeout(() => {
                    loader.style.display = 'none';
                }, 800);
            }, 1500);
        };

        // Prevent zoom on double-tap
        document.addEventListener('touchstart', function(event) {
            if (event.touches.length > 1) {
                event.preventDefault();
            }
        }, { passive: false });

        // Prevent zoom on wheel
        document.addEventListener('wheel', function(event) {
            if (event.ctrlKey) {
                event.preventDefault();
            }
        }, { passive: false });

        // Tab switching
        function switchTab(tabId) {
            // Remove active class from all tabs
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Remove active class from all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // Add active class to clicked tab
            event.currentTarget.classList.add('active');
            
            // Show corresponding content
            document.getElementById(tabId).classList.add('active');
        }

        // URL preview binding
        function setupUrlBinding(inputId, spanId) {
            const input = document.getElementById(inputId);
            const span = document.getElementById(spanId);
            
            input.addEventListener('input', function() {
                let value = this.value.toLowerCase()
                    .replace(/[^a-z0-9-]/g, '-')  // Replace non-alphanumeric with dash
                    .replace(/-+/g, '-')          // Replace multiple dashes with single
                    .replace(/^-|-$/g, '');       // Remove leading/trailing dashes
                
                span.textContent = value || 'project-name';
            });
        }

        // Initialize URL previews
        setupUrlBinding('inp-url', 'prev-url');
        setupUrlBinding('inp-code-url', 'prev-code-url');
        setupUrlBinding('inp-audio-url', 'prev-audio-url');
        setupUrlBinding('inp-video-url', 'prev-video-url');
        setupUrlBinding('inp-photo-url', 'prev-photo-url');

        // File upload handling (shared by File/Audio/Video/Photo tabs)
        function updateFile(input, nameElId, urlInputId, urlPreviewId) {
            nameElId = nameElId || 'file-name';
            urlInputId = urlInputId || 'inp-url';
            urlPreviewId = urlPreviewId || 'prev-url';

            if (input.files && input.files[0]) {
                const fileName = input.files[0].name;
                const fileNameElement = document.getElementById(nameElId);
                fileNameElement.innerHTML = `<i class="fas fa-fire" style="color: var(--primary); margin-right: 8px;"></i> ${fileName}`;
                
                // Auto-generate slug from filename
                const slug = fileName
                    .split('.')[0]
                    .toLowerCase()
                    .replace(/[^a-z0-9]/g, '-')
                    .replace(/-+/g, '-')
                    .replace(/^-|-$/g, '');
                
                const urlInput = document.getElementById(urlInputId);
                const urlPreview = document.getElementById(urlPreviewId);
                
                if (urlInput.value === '') {
                    urlInput.value = slug;
                    urlPreview.textContent = slug;
                }
            }
        }

        // Copy link with toast notification
        function copyLink(url) {
            navigator.clipboard.writeText(url).then(() => {
                const toast = document.getElementById('toast');
                const toastMsg = document.getElementById('toast-msg');
                
                toastMsg.textContent = 'URL copied to clipboard!';
                toast.classList.add('show');
                
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 2500);
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        }

        // Delete a deployed project after user confirmation
        function deleteProject(filename, displayName) {
            const confirmed = confirm('Delete "' + displayName + '"? This cannot be undone.');
            if (!confirmed) return;

            document.getElementById('deleteProjectInput').value = filename;
            document.getElementById('deleteForm').submit();
        }

        // Add animation to cards on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.transform = 'translateY(0)';
                        entry.target.style.opacity = '1';
                    }
                });
            }, {
                threshold: 0.1
            });
            
            cards.forEach(card => {
                card.style.transform = 'translateY(20px)';
                card.style.opacity = '0';
                card.style.transition = 'transform 0.5s ease, opacity 0.5s ease';
                observer.observe(card);
            });
        });

        // Prevent iOS zoom on input focus
        document.addEventListener('focus', function(event) {
            if (event.target.tagName === 'INPUT' || event.target.tagName === 'TEXTAREA') {
                event.target.style.fontSize = '16px';
            }
        }, true);

        document.addEventListener('blur', function(event) {
            if (event.target.tagName === 'INPUT' || event.target.tagName === 'TEXTAREA') {
                event.target.style.fontSize = '';
            }
        }, true);

        // Auto-typing loop effect (types out, pauses, erases, retypes forever)
        function startTypewriter(elementId, text, opts) {
            const el = document.getElementById(elementId);
            if (!el) return;
            const settings = Object.assign({
                typeSpeed: 110,
                eraseSpeed: 55,
                holdFull: 2200,
                holdEmpty: 500
            }, opts || {});

            let charIndex = 0;
            let deleting = false;

            function tick() {
                if (!deleting) {
                    charIndex++;
                    el.textContent = text.substring(0, charIndex);
                    if (charIndex === text.length) {
                        deleting = true;
                        setTimeout(tick, settings.holdFull);
                        return;
                    }
                    setTimeout(tick, settings.typeSpeed);
                } else {
                    charIndex--;
                    el.textContent = text.substring(0, charIndex);
                    if (charIndex === 0) {
                        deleting = false;
                        setTimeout(tick, settings.holdEmpty);
                        return;
                    }
                    setTimeout(tick, settings.eraseSpeed);
                }
            }
            el.textContent = '';
            tick();
        }

        // Types out once and stays put — only the blinking cursor keeps animating after
        function typeOnce(elementId, text, opts) {
            const el = document.getElementById(elementId);
            if (!el) return;
            const settings = Object.assign({ typeSpeed: 120 }, opts || {});
            let charIndex = 0;

            function tick() {
                charIndex++;
                el.textContent = text.substring(0, charIndex);
                if (charIndex < text.length) {
                    setTimeout(tick, settings.typeSpeed);
                }
            }
            el.textContent = '';
            tick();
        }

        document.addEventListener('DOMContentLoaded', function() {
            typeOnce('brandTypewriter', 'WASEEM MULTIPLE HOSTING', { typeSpeed: 120 });
            startTypewriter('heroTypewriter', 'Deploy Your Code in Seconds', { typeSpeed: 65, eraseSpeed: 30, holdFull: 2600, holdEmpty: 600 });

            // Animated Waves Background
            try {
                VANTA.WAVES({
                    el: "#vanta-bg",
                    mouseControls: true,
                    touchControls: true,
                    gyroControls: false,
                    minHeight: 200.00,
                    minWidth: 200.00,
                    scale: 1.00,
                    scaleMobile: 1.00,
                    color: 0x20023,
                    shininess: 25.00,
                    waveHeight: 15.00,
                    waveSpeed: 0.75,
                    zoom: 0.85
                });
            } catch(e) {}
        });
    </script>
</body>
</html>