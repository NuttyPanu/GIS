<?php
header('Content-Type: text/html; charset=utf-8');
//----------function-Curl------------//
function get_url($urllink) 
{
  $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $urllink);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)');
    //curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)');
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $data = curl_exec($curl);
    curl_close($curl);
    return $data;
}
//---------------------------------//


//ใส่Token ที่ได้จาก Line Messaging API https://developers.line.me
$channelAccessToken = 'ncKZlLqlmBLx+7l0l7WYgS3eGffeiCOcBUePETpd4qAjWFpjMiakXLA4oMcH0LeWKtbc9ML8vM8b8aSw7guFdkGiEY2z8q6mhacKzJb03GBYs8+Tpmq7lq/KKTsx3HsulZ4+rxiily83SV36x6DCUQdB04t89/1O/w1cDnyilFU=';
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data--------replymessage----------//
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format >>กำหนดให้มีการตอบข้อความกลับเมื่อสิ่งที่ user ส่งมาเป็นข้อความ
		if ($event['type'] == 'message' && $event['message']['type'] == 'video') {		
			$recive_vdo_url = $event['message']['originalContentUrl'];// ข้อความที่เข้ามา
			$recive_uid = $event['source']['userId'];//userId ของ user ที่ส่งข้อความา
			$recive_gid = $event['source']['groupId'];// groupId ของ user group ที่ส่งข้อความา			
			$replyToken = $event['replyToken'];// ค่ารหัส replyToken
			$messages = ['type' => 'text','text' => $recive_vdo_url];
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
				//'messages' => ["https://gispwaai.herokuapp.com/golf.jpg"],
			];
			$send_data = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $channelAccessToken);			
			// Make a POST Request to Messaging API to reply to sender
			$reply = curl_init('https://api.line.me/v2/bot/message/reply');
			curl_setopt($reply, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($reply, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($reply, CURLOPT_POSTFIELDS, $send_data);
			curl_setopt($reply, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($reply, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($reply);
			curl_close($reply);
			echo $result . "\r\n";
		}
	}
}
?>