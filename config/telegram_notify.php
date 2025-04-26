<?php

function sendTelegramMessage($message) {
    $botToken = "TU_BOT_TOKEN";
    $chatId = "TU_CHAT_ID";

    $url = "https://api.telegram.org/bot$botToken/sendMessage";

    $data = [
        'chat_id' => $chatId,
        'text' => $message,
    ];

    $options = [
        "http" => [
            "header" => "Content-Type: application/x-www-form-urlencoded\r\n",
            "method" => "POST",
            "content" => http_build_query($data),
        ],
    ];

    $context = stream_context_create($options);
    file_get_contents($url, false, $context);
}
?>
