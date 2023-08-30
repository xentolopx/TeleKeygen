<?php

require_once __DIR__.'/src/PHPTelebot.php';
$bot = new PHPTelebot('5563451786:AAGLDRQdliu2f8qP0fCs5N5sLyUhNYBLVQQ', 'KangMutePPBot');


function customEncode($value) {
    $timestamp = time();
    $encodedValue = "";

    // Convert the value to a string if it's an integer
    if (!is_string($value)) {
        $value = (string)$value;
    }

    for ($i = 0; $i < strlen($value); $i++) {
        $char = $value[$i];
        $shift = ord($char) + $timestamp % 10;
        $encodedValue .= chr($shift);
    }

    return base64_encode($encodedValue . $timestamp);
}


function customDecode($encodedValue) {
    $decoded = base64_decode($encodedValue);
    $timestamp = substr($decoded, -10);
    $decodedValue = "";

    for ($i = 0; $i < strlen($decoded) - 10; $i++) {
        $char = $decoded[$i];
        $shift = ord($char) - $timestamp % 10;
        $decodedValue .= chr($shift);
    }

    return $decodedValue;
}
//////////////////////////////////////////////

$bot->cmd('.encode', function ($input) {
return Bot::sendMessage(customEncode($input), ['parse_mode' => 'html', 'reply' => true]);
});

$bot->cmd('.decode', function ($input) {
    return Bot::sendMessage(customDecode($input), ['parse_mode' => 'html', 'reply' => true]);
});

$bot->cmd('.paste', function ($input) {
    $response = createPasteUsingCurl($input);
    return Bot::sendMessage("[Gaskan🦊]($response)", ['parse_mode' => 'MarkdownV2', 'reply' => true]);
});

// $bot->cmd('.keygen', function ($input) {
//     $msg = Bot::message();
//     $chatid = $msg['chat']['id'];
//     $decodedValue = customDecode($input);

//     // Check if the decoded value is a photo or document file ID
//     if (strpos($decodedValue, 'AgAC') === 0) { // Check if it starts with 'AgAC'
//         $xx = ['file_id' => $decodedValue];
//         Bot::sendPhoto($xx);
//     } elseif (strpos($decodedValue, 'BQAC') === 0) { // Check if it starts with 'BQAC'
//         $xx = ['file_id' => $decodedValue];
//         Bot::sendDocument($xx);
//     } else {
//         // Unknown file type, handle accordingly
//         return;
//     }
// });


// Define your customEncode function here
$bot->on('photo|document|video', function() {
    $msg = Bot::message();
    $chatid = $msg['chat']['id'];
    if ($chatid == 283993474) {
        $messageId = $msg['message_id'];
        $encodedMessageId = customEncode($messageId);
        $response = createPasteUsingCurl($encodedMessageId);
        $caption = $msg['caption'];
        Bot::sendMessage("`Penyegar Recehan`", ['protect_content' => true,'disable_web_page_preview' => true,'chat_id' => -1001425009358,'message_thread_id' => 128351,'parse_mode' => 'MarkdownV2', 'reply' => true]);
        Bot::sendMessage("[$caption x Gaskan🦊]($response)", ['protect_content' => true,'disable_web_page_preview' => true,'chat_id' => -1001425009358,'message_thread_id' => 128351,'parse_mode' => 'MarkdownV2', 'reply' => true]);
        Bot::sendMessage($encodedMessageId, ['parse_mode' => 'html', 'reply' => true]);
    }
    
});

$bot->cmd('.keygen', function ($input) {
    $msg = Bot::message();
    $chatid = $msg['chat']['id'];
    $decodedMessageId = customDecode($input);

    $xx = ['chat_id' => $chatid, 'from_chat_id' => $chatid, 'message_id' => $decodedMessageId];
    Bot::forwardMessage($xx);
});


function seeURL($url){
    $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
}


function createPasteUsingCurl($input) {
    $api_dev_key = 'a11358d63416e063df6f902b07363a34';
    $api_paste_code = " Copas Keygen lalu kirim ke https://t.me/xcsniperbot '.keygen $input'";
    $api_option = 'paste';

    $postData = [
        'api_dev_key' => $api_dev_key,
        'api_paste_code' => $api_paste_code,
        'api_option' => $api_option,
    ];

    $url = 'https://pastebin.com/api/api_post.php';
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);
    curl_close($ch);
    $final = "https://semawur.com/st/?api=8f786ab65d9431f0cacf0fd5a662699b7f1a50c5&url=$response";
    return $final;
}



//////////////////
$bot->run();
//////////////////


