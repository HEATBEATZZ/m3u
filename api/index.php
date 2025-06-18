<?php
date_default_timezone_set('Asia/Kolkata');

// Get target m3u URL (can be fixed or passed via ?url=)
$url = $_GET['url'] ?? 'https://play.denver1769.fun/Play/hls/T1Mssa/Playlist.m3u';

// Spoof User-Agent (can be customized via ?ua=)
$ua = $_GET['ua'] ?? 'VLC/3.0.11 LibVLC/3.0.11';

// Set headers to bypass browser detection
$headers = [
    "User-Agent: $ua",
    "Accept: */*",
    "Connection: keep-alive",
];

// Create HTTP context
$context = stream_context_create([
    'http' => [
        'method' => 'GET',
        'header' => implode("\r\n", $headers),
        'ignore_errors' => true
    ]
]);

// Try fetching the playlist
$response = @file_get_contents($url, false, $context);

// Check and respond
if ($response !== false && str_starts_with($response, '#EXTM3U')) {
    header("Content-Type: application/vnd.apple.mpegurl");
    echo $response;
} else {
    http_response_code(403);
    echo "# ❌ Failed to fetch or invalid playlist.\n";
    echo "# 🔁 Try a different UA: ?ua=Lavf/58.45.100\n";
}
