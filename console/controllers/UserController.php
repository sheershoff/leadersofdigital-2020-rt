<?php


namespace console\controllers;


use common\models\User;
use yii\console\ExitCode;

/**
 * Console command for user manupulations
 * @package console\controllers
 */
class UserController extends \yii\console\Controller
{
    /**
     * Resets admin user password, auth_key and activates the user. Creates user if not exists.
     * @param string $user
     * @param string $password Password to set for admin
     * @return int
     * @throws \Exception
     */
    public function actionUserPassword(string $username, string $password)
    {
        $user = User::findByUsername($username);
        if (!$user) {
            $user = new User();
            $user->username = $username;
            $user->email = $username . '@example.com';
        }
        $user->status = User::STATUS_ACTIVE;
        $user->auth_key = bin2hex(random_bytes(16));
        $user->setPassword($password);
        $user->save();
        return ExitCode::OK;
    }
}