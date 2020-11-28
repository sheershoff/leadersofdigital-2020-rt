<?php

namespace frontend\controllers;

use common\helpers\PersonalityForgeHelper;
use yii\web\Controller;

/**
 * Site controller
 */
class ChatController extends Controller
{
    public function actionPhrase()
    {
        $phrase = \Yii::$app->request->post('phrase');
        return json_encode([
            'answer' => PersonalityForgeHelper::sendReceive($phrase),
            'status' => 1,
        ]);
    }
}