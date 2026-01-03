<?php
set_time_limit(60);
error_reporting(0);
header("Content-Type: application/json; charset=UTF-8");

/* ===== API KEY ===== */
$OPENROUTER_API_KEY = "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"; 
if (!$OPENROUTER_API_KEY) {
    echo json_encode(["error" => "API KEY MISSING"]);
    exit;
}

/* ===== INPUT ===== */
$model  = $_GET['model'] ?? '';
$prompt = trim($_GET['prompt'] ?? '');

if (!$model || !$prompt) {
    echo json_encode(["error" => "INVALID INPUT"]);
    exit;
}

/* ===== MODEL TYPE ===== */
$isChatModel = !str_starts_with($model, "nvidia/");

/* ===== PAYLOAD ===== */
$payload = [
    "model" => $model,
    "temperature" => 0.7
];

if ($isChatModel) {
    $payload["messages"] = [
        ["role" => "user", "content" => $prompt]
    ];
} else {
    $payload["prompt"] = $prompt;
}

/* ===== ENDPOINT ===== */
$endpoint = $isChatModel
    ? "https://openrouter.ai/api/v1/chat/completions"
    : "https://openrouter.ai/api/v1/completions";

/* ===== CURL ===== */
$ch = curl_init($endpoint);
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer {$OPENROUTER_API_KEY}",
        "Content-Type: application/json",
        "HTTP-Referer: http://localhost",
        "X-Title: AI Compare"
    ],
    CURLOPT_POSTFIELDS => json_encode($payload),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 60
]);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

$text =
    $data['choices'][0]['message']['content']
    ?? $data['choices'][0]['text']
    ?? '';

if (!$text) {
    echo json_encode(["error" => "EMPTY RESPONSE"]);
    exit;
}

/* ===== RETURN JSON ===== */
echo json_encode([
    "text" => $text
]);
exit;
