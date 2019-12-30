<?php


namespace app\models;


use Yii;
use yii\httpclient\Client;
use app\models\AntiCaptcha\ImageToText;

class Info
{
    public static function getInfo() {
        $captcha_id =  Yii::$app->request->post('captcha_id');
        $captcha = self::resolveCaptcha($captcha_id);
        if (!$captcha)
            return false;
        $inn = Yii::$app->request->post('User')['iin_bin'];
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('post')
            ->setUrl('http://kgd.gov.kz/apps/services/culs-taxarrear-search-web/rest/search')
            ->addHeaders(['content-type' => 'application/json'])
            ->setContent(json_encode(['iinBin' => $inn, 'captcha-user-value' => $captcha, 'captcha-id' => $captcha_id]))
            ->send();
        if (!$response->isOk)
            return false;
        return json_decode($response->content);
    }


    private static function resolveCaptcha($captcha_id) {
        $img = self::getCapthaImg('http://kgd.gov.kz/apps/services/CaptchaWeb/generate?uid=' . $captcha_id);
        $antiCaptcha = new ImageToText();
        //$antiCaptcha->setVerboseMode(true);
        $antiCaptcha->setKey(Yii::$app->params['captchaKey']);
        $antiCaptcha->setFile($img);
        if (!$antiCaptcha->createTask()) {
            unlink($img);
            return false;
        }
        $taskId = $antiCaptcha->getTaskId();
        if (!$antiCaptcha->waitForResult()) {
            unlink($img);
            return false;
        } else {
            $captchaText = $antiCaptcha->getTaskSolution();
        }
        unlink($img);
        return ($captchaText);
    }

    private static function getCapthaImg($url) {
        $img = 'tmp/captcha.jpg';
        file_put_contents($img, file_get_contents($url));
        return $img;
    }

    public static function saveInfo($info) {
        $user = new User();
        $user->iin_bin = $info['iinBin'];
        $user->save();
        foreach ($info['taxOrgInfo'] as $org) {
            $org = new Organisation();
            $org->char_code = $org['charCode'];
            foreach ($org['taxPayerInfo'] as $payer) {
                foreach ($payer['bccArrearsInfo'] as $arrear) {
                    $arrear = new Arrear();
                    $arrear->bcc = $arrear['bcc'];
                    $arrear->save();
                }
            }
            $org->save();
        }
    }
}
