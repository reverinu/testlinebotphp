<?php

$accessToken = getenv('LINE_CHANNEL_ACCESS_TOKEN');


$json_string = file_get_contents('php://input');
$jsonObj = json_decode($json_string);

$type = $jsonObj->{"events"}[0]->{"message"}->{"type"};
$text = $jsonObj->{"events"}[0]->{"message"}->{"text"};
$replyToken = $jsonObj->{"events"}[0]->{"replyToken"};

if ($type != "text") {
    exit;
}


if ($text == '@help') {
    $response_format_text = [
        "type" => "text",
        "text" => "ヘルプだよ！"
    ];
} else if ($text == '@join') {
    $response_format_text = [
        "type" => "text",
        "text" => "参加受け付けたよ！"
    ];
} else if ($text == '@start') {
    $response_format_text = [
        "type" => "text",
        "text" => "始まるよ！"
    ];
} else if ($text == '@bye') {
    $response_format_text = [
        "type" => "text",
        "text" => "さよなら！"
    ];
}

$post_data = [
    "replyToken" => $replyToken,
    "messages" => [$response_format_text]
];

$ch = curl_init("https://api.line.me/v2/bot/message/reply");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json; charser=UTF-8',
    'Authorization: Bearer ' . $accessToken
));
$result = curl_exec($ch);
curl_close($ch);
