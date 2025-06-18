<?php
date_default_timezone_set('Asia/Kolkata');

// Step 1: Get URL
$url = $_GET['url'] ?? 'https://play.denver1769.fun/Play/hls/T1Mssa/Playlist.m3u';

// Step 2: Get or randomize User-Agent
$uas = [
    "VLC/3.0.11 LibVLC/3.0.11",
    "Lavf/58.45.100",
    "AppleCoreMedia/1.0.0.18E212 (iPhone; U; CPU OS 13_3_1 like Mac OS X; en_us)"
];
$ua = $_GET['ua'] ?? $uas[array_rand($uas)];

// Step 3: Setup request
$opts = [
    "http" => [
        "method" => "GET",
        "header" => "User-Agent: $ua\r\nAccept: */*\r\n",
        "ignore_errors" => true
    ]
];
$context = stream_context_create($opts);
$response = @file_get_contents($url, false, $context);

// Step 4: Send as M3U8
if ($response && str_starts_with($response, '#EXTM3U')) {
    header("Content-Type: application/vnd.apple.mpegurl");
    echo $response;
} else {
    http_response_code(403);
    header("Content-Type: text/plain");
    echo "# Failed to fetch valid stream.\n";
    echo "# Try with ?ua=AppleCoreMedia...\n";
}
