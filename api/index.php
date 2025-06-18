<?php
date_default_timezone_set('Asia/Kolkata');

$url = $_GET['url'] ?? 'https://play.denver1769.fun/Play/hls/T1Mssa/Playlist.m3u';

$uas = [
    "VLC/3.0.11 LibVLC/3.0.11",
    "Lavf/58.45.100",
    "AppleCoreMedia/1.0.0.18E212"
];
$ua = $_GET['ua'] ?? $uas[array_rand($uas)];

$opts = [
    "http" => [
        "method" => "GET",
        "header" => "User-Agent: $ua\r\nAccept: */*\r\n"
    ]
];
$context = stream_context_create($opts);
$response = @file_get_contents($url, false, $context);

if ($response && str_starts_with($response, '#EXTM3U')) {
    header("Content-Type: application/vnd.apple.mpegurl");
    echo $response;
} else {
    http_response_code(403);
    header("Content-Type: text/plain");
    echo "# ❌ Failed. Try another UA.\n";
}
