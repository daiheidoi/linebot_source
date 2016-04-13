<?php
error_log("callback start.");

// アカウント情報設定
$channel_id = "1461716189";
$channel_secret = "a1c0a8a95a5c88c0444bad85a82fe0d4";
$mid = "u72e361d4b846000f48c81f9dd04a538f";

// リソースURL設定

// メッセージ受信

// ユーザ情報取得
api_get_user_profile_request("u812ac4fb09db6b65fa8c2328c13849e6");

$content = <<< EOM
        "contentType":1,
        "text":"ハゲ"
EOM;

$post = <<< EOM
{
    "to":["u72e361d4b846000f48c81f9dd04a538f"],
    "toChannel":1383378250,
    "eventType":"138311608800106203",
    "content":{
        "toType":1,
        {$content}
    }
}
EOM;
api_post_request($post);

//sendMessage(["Content-Type: application/json; charser=UTF-8", "X-Line-ChannelID:" . $channel_id, "X-Line-ChannelSecret:" . $channel_secret, "X-Line-Trusted-User-With-ACL:" . $mid], $mid, "はげ");

error_log("callback end.");

function api_post_request($post) {
     $url = "https://trialbot-api.line.me/v1/events";
     $headers = array(
     	"Content-Type: application/json",
        "X-Line-ChannelID: {$GLOBALS['channel_id']}",
        "X-Line-ChannelSecret: {$GLOBALS['channel_secret']}",
        "X-Line-Trusted-User-With-ACL: {$GLOBALS['mid']}"
     );
     $curl = curl_init($url);
     curl_setopt($curl, CURLOPT_POST, true);
     curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
     curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
     // 保存するファイル
     // 詳細な情報を出力する
     // STDERR の代わりにエラーを出力するファイルポインタ
     var_dump(curl_getinfo($curl));
     try{
        $output = curl_exec($curl);
        error_log($output);
     } catch (Exception $e){
        error_log($e);
     }

     curl_close($curl);    
}

/* メッセージを送る */
function sendMessage($header, $to, $message) {
 
     $url = "https://trialbot-api.line.me/v1/events";
     $data = ["to" => [$to], "toChannel" => 1383378250, "eventType" => "138311608800106203", "content" => ["contentType" => 1, "toType" => 1, "text" => $message]];
     $context = stream_context_create(array(
     "http" => array("method" => "POST", "header" => implode(PHP_EOL, $header), "content" => json_encode($data), "ignore_errors" => true)
     ));

     error_log(var_dump($context));
     file_get_contents($url, false, $context);
}
 
function api_get_user_profile_request($mid) {
     $url = "https://trialbot-api.line.me/v1/profiles?mids={$mid}";
     $headers = array(
         "X-Line-ChannelID: {$GLOBALS['channel_id']}",
         "X-Line-ChannelSecret: {$GLOBALS['channel_secret']}",
         "X-Line-Trusted-User-With-ACL: {$GLOBALS['mid']}"
     ); 
 
     $curl = curl_init($url);
     curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
     $output = curl_exec($curl);
     error_log($output);
}
 
function api_get_message_content_request($message_id) {
     $url = "https://trialbot-api.line.me/v1/bot/message/{$message_id}/content";
     $headers = array(
         "X-Line-ChannelID: {$GLOBALS['channel_id']}",
         "X-Line-ChannelSecret: {$GLOBALS['channel_secret']}",
         "X-Line-Trusted-User-With-ACL: {$GLOBALS['mid']}"
     ); 
 
     $curl = curl_init($url);
     curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
     $output = curl_exec($curl);
     file_put_contents("/tmp/{$message_id}", $output);
}
?>
