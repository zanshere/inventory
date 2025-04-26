<?php
// Menangani kesalahan dengan pengaturan default
function handle_error($error_code) {
    // Daftar kode error yang valid
    $valid_codes = [400, 401, 402, 403, 404, 405, 406, 407, 408, 409, 410, 429, 500, 501, 502, 503, 504, 508];

    if (!in_array($error_code, $valid_codes)) {
        $error_code = 404;
    }

    // Set status HTTP sesuai dengan kode error
    http_response_code($error_code);

    // Konfigurasi pesan error untuk setiap kode
    $error_config = [
        // 4xx Client Errors
        400 => ['title' => 'Bad Request', 'message' => 'Server cannot process the request due to client error', 'colors' => ['#ff6b6b', '#ff9f43']],
        401 => ['title' => 'Unauthorized', 'message' => 'Authentication required to access this resource', 'colors' => ['#4b7bec', '#45aaf2']],
        402 => ['title' => 'Payment Required', 'message' => 'Payment is needed to fulfill the request', 'colors' => ['#ffd93d', '#ff6b6b']],
        403 => ['title' => 'Forbidden', 'message' => "You don't have permission to access this content", 'colors' => ['#ff7f50', '#ff6b6b']],
        404 => ['title' => 'Not Found', 'message' => 'The requested resource could not be found. It may have been moved or permanently deleted by the developer', 'colors' => ['#a55eea', '#778beb']],
        405 => ['title' => 'Method Not Allowed', 'message' => 'The request method is not supported for this resource', 'colors' => ['#6c5ce7', '#a55eea']],
        406 => ['title' => 'Not Acceptable', 'message' => 'Server cannot produce response matching accept headers', 'colors' => ['#00b894', '#55efc4']],
        407 => ['title' => 'Proxy Auth Required', 'message' => 'Proxy authentication is needed to access this resource', 'colors' => ['#fdcb6e', '#e17055']],
        408 => ['title' => 'Request Timeout', 'message' => 'Server timed out waiting for the request', 'colors' => ['#ffeaa7', '#fab1a0']],
        409 => ['title' => 'Conflict', 'message' => 'Request conflicts with current server state', 'colors' => ['#ff7675', '#d63031']],
        410 => ['title' => 'Gone', 'message' => 'Requested content has been permanently removed', 'colors' => ['#636e72', '#2d3436']],
        429 => ['title' => 'Too Many Requests', 'message' => 'You have exceeded the request rate limit', 'colors' => ['#ff7675', '#e84393']],
        // 5xx Server Errors
        500 => ['title' => 'Internal Server Error', 'message' => 'Server encountered an unexpected condition', 'colors' => ['#ff4757', '#ff6b81']],
        501 => ['title' => 'Not Implemented', 'message' => 'Server does not support the requested functionality', 'colors' => ['#70a1ff', '#1e90ff']],
        502 => ['title' => 'Bad Gateway', 'message' => 'Invalid response received from upstream server', 'colors' => ['#ff6348', '#ff4757']],
        503 => ['title' => 'Service Unavailable', 'message' => 'Server is currently unable to handle the request', 'colors' => ['#6366f1', '#8b5cf6']],
        504 => ['title' => 'Gateway Timeout', 'message' => 'Upstream server failed to respond in time', 'colors' => ['#ffa502', '#ff7f50']],
        508 => ['title' => 'Loop Detected', 'message' => 'Server terminated request due to infinite loop', 'colors' => ['#cd84f1', '#c56cf0']]
    ];

    // Ambil konfigurasi error dari array yang sesuai dengan error_code
    return $error_config[$error_code] ?? $error_config[404]; // default to 404 if not found
}

$error_code = isset($_GET['code']) ? (int)$_GET['code'] : 404;
$error = handle_error($error_code);

$colorsString = implode(', ', $error['colors']);

// Base URL untuk memastikan path konsisten
define('BASE_URL', 'https://localhost/git-project/inventory'); // Sesuaikan dengan base URL 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="<?= BASE_URL ?>/">
    <title>Error <?= $error_code ?> - <?= htmlspecialchars($error['title']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="assets/Images/box_icon_126533.ico" type="image/x-icon">
    <style>
        /* Reset dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
        }

        /* Animasi background gradient */
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 90%; }
            100% { background-position: 0% 50%; }
        }

        .gradient-bg {
            background-size: 400% 400%;
            animation: gradient 5s ease infinite;
        }

        /* Animasi untuk card entrance */
        @keyframes cardEntrance {
            0% { transform: translateY(50px) scale(0.95); opacity: 0; }
            100% { transform: translateY(0) scale(1); opacity: 1; }
        }

        .error-card {
            animation: cardEntrance 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
    </style>
</head>
<body data-colors="<?= htmlspecialchars($colorsString) ?>" class="min-h-screen flex items-center justify-center gradient-bg">
    <div class="max-w-2xl w-full p-6">
        <div class="bg-white/90 backdrop-blur-lg rounded-3xl shadow-2xl p-8 error-card">
            <div class="text-center space-y-6">
                <div class="error-code text-9xl font-bold text-transparent bg-clip-text" 
                     style="background-image: linear-gradient(45deg, <?= $colorsString ?>)">
                    <?= $error_code ?>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($error['title']) ?></h1>
                    <p class="text-gray-600 text-lg"><?= htmlspecialchars($error['message']) ?></p>
                </div>
                <div class="mt-6">
                    <a href="./index.php" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all duration-300 inline-block">
                        ← Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Efek animasi untuk error code
        document.addEventListener('DOMContentLoaded', function() {
            const bodyElement = document.body;
            const colors = bodyElement.getAttribute('data-colors');
            bodyElement.style.backgroundImage = `linear-gradient(-45deg, ${colors})`;

            const errorCodeEl = document.querySelector('.error-code');
            const swingDuration = 3000;
            const amplitudePx = 10;
            const amplitudeDeg = 3;
            let startTime;

            function animateErrorCode(timestamp) {
                if (!startTime) startTime = timestamp;
                const elapsed = timestamp - startTime;
                const progress = (elapsed % swingDuration) / swingDuration;
                const offsetY = amplitudePx * Math.sin(2 * Math.PI * progress);
                const angle = amplitudeDeg * Math.sin(2 * Math.PI * progress);
                errorCodeEl.style.transform = `translateY(${-offsetY}px) rotate(${angle}deg)`;
                requestAnimationFrame(animateErrorCode);
            }

            requestAnimationFrame(animateErrorCode);
        });
    </script>
</body>
</html>
