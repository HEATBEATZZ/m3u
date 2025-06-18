<?php
// Timezone just for logging consistency
date_default_timezone_set('Asia/Kolkata');

// Target protected .m3u8 URL
$url = "https://play.denver1769.fun/Play/hls/T1Mssa/Playlist.m3u";

// You can pass URL dynamically too
// $url = $_GET['url'] ?? 'https://...';

// Use a non-browser User-Agent (to avoid redirection)
$ua = $_GET['ua'] ?? "VLC/3.0.11 LibVLC/3.0.11";

// Custom headers
$headers = [
    "User-Agent: $ua",
    "Accept: */*",
    "Connection: keep-alive"
];

// Create context for GET request
$context = stream_context_create([
    "http" => [
        "method" => "GET",
        "header" => implode("\r\n", $headers),
        "ignore_errors" => true
    ]
]);

// Attempt to fetch M3U8 content
$response = @file_get_contents($url, false, $context);

// Serve the result
if ($response !== false) {
    header("Content-Type: application/vnd.apple.mpegurl");
    echo $response;
} else {
    http_response_code(403);
    echo "# Error: Playlist not accessible. Try a different User-Agent or check IP restriction.\n";
}
