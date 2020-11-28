<?php


namespace common\helpers;


class PersonalityForgeHelper
{
    public function sendReceive($msg, $botid = 2)
    {
        $apiKey = \Yii::$app->params['personalityforge']['apiKey'];
        $apiSecret = \Yii::$app->params['personalityforge']['apiSecret'];

        $message = array(
            'message' => array(
                'message' => $msg,
                'chatBotID' => $botid,
                'timestamp' => time()
            ),
            'user' => array(
                'firstName' => 'Tugger',
                'lastName' => 'Sufani',
                'gender' => 'm',
                'externalID' => 'user_id_0'
            )
        );

// construct the data
        $host = "https://www.personalityforge.com/api/chat/";
        $messageJSON = json_encode($message);
        $hash = hash_hmac('sha256', $messageJSON, $apiSecret);

        $url = $host . "?apiKey=" . $apiKey . "&hash=" . $hash . "&message=" . urlencode($messageJSON);

// Make the call using cURL
        $ch = curl_init();

// set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// make the call
        $response = curl_exec($ch);
        curl_close($ch);

//        echo 'Response JSON: '.$response.'<br>';

        $responseObject = json_decode($response);

        if (!$responseObject->success) {
            return 'Chatbot is frustrated: ' . $responseObject->errorType . ' : ' . $responseObject->errorMessage;
        } else {
            return $responseObject->message->message;
        }

    }
}