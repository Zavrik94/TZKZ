<?php

namespace app\models;

use Yii;
use yii\httpclient\Client;
use app\models\AntiCaptcha\ImageToText;

class Info
{
    /**
     * @var string
     */
    private $iin;

    /**
     * @var string
     */
    private $captcha_id;

    /**
     * @var array
     */
    private $json;

    /**
     * @var Request
     */
    private $request;

    /**
     * Info constructor.
     *
     * @param string $iin
     * @param string $captcha_id
     */
    public function __construct(string $iin, string $captcha_id)
    {
        $this->iin = $iin;
        $this->captcha_id = $captcha_id;

        if (Yii::$app->params['toLogRequsts']) {
            $this->request = new Request();
        }
    }

    public function saveAllInfo()
    {
        $captcha = $this->resolveCaptcha();
        if (!$captcha) {
            throw new \Exception('Fuck off!');
        }

        $our_request = json_encode([
                'iinBin' => $this->iin,
                'captcha-user-value' => $captcha,
                'captcha-id' => $this->captcha_id]
        );
        $this->request and $this->request->our_request = $our_request;
        $this->request and $this->request->save();

        $response = (new Client)->createRequest()
            ->setMethod('post')
            ->setUrl(Yii::$app->params['govDomen'] . '/apps/services/culs-taxarrear-search-web/rest/search')
            ->addHeaders(['content-type' => 'application/json'])
            ->setContent($our_request)
            ->send();

        $this->request and $this->request->is_ok = $response->isOk;
        $this->request and $this->request->gov_response = (string)$response;
        $this->request and $this->request->save();

        if (!$response->isOk) {
            throw new \Exception('Fuck off!');
        }

        $this->json = json_decode($response->content, true);

        var_dump($this->json);
        die;

        $this->saveInfo();
    }

    private function resolveCaptcha()
    {
        $img =
            $this->getCapthaImg(Yii::$app->params['govDomen']
                                . "/apps/services/CaptchaWeb/generate?uid={$this->captcha_id}");

        $antiCaptcha = new ImageToText();
        // $antiCaptcha->setVerboseMode(true);
        $antiCaptcha->setKey(Yii::$app->params['captchaKey']);
        $antiCaptcha->setFile($img);
        if (!$antiCaptcha->createTask()) {
            unlink($img);

            throw new \Exception('Fuck off!');
        }

        $this->request and $this->request->anti_capcha_task_id = $antiCaptcha->getTaskId();
        $this->request and $this->request->save();
        if (!$antiCaptcha->waitForResult()) {
            unlink($img);

            throw new \Exception('Fuck off!');
        }

        $captchaText = $antiCaptcha->getTaskSolution();
        unlink($img);

        return ($captchaText);
    }

    private function getCapthaImg($url)
    {
        $img = 'tmp/captcha.jpg';
        file_put_contents($img, file_get_contents($url));

        return $img;
    }

    public function saveInfo()
    {
        foreach ($this->json as $key => $val) {
            $user = new User();
            $user->iin_bin = $val['iinBin'];
            $user->name_ru = $val['nameRu'];
            $user->name_kk = $val['nameKk'];
            $user->total_arrear = $val['total_arrear'];
            $user->total_tax_arrear = $val['total_tax_arrear'];
            $user->pension_contribution_arrear = $val['pension_contribution_arrear'];
            $user->social_contribution_arrear = $val['social_contribution_arrear'];
            $user->social_health_insurance_arrear = $val['social_health_insurance_arrear'];
            $user->save();

            $this->request and $this->request->send_time = $val['sendTime'];
            $this->request and $this->request->user_iin_bin = $user->iin_bin;
            $this->request and $this->request->save();

            foreach ($val['taxOrgInfo'] as $org) {
                $org = new Organisation();
                $org->char_code = $org['charCode'];
                $org->name_ru = $org['nameRu'];
                $org->name_kk = $org['nameKk'];
                $org->report_acrual_date = $org['reportAcrualDate'];
                $org->save();

                foreach ($org['taxPayerInfo'] as $payer) {
                    foreach ($payer['bccArrearsInfo'] as $arr) {
                        $arrear = new Arrear();
                        $arrear->bcc = $arr['bcc'];
                        $arrear->user_iin_bin = $user->iin_bin;
                        $arrear->organisation_char_code = $org->char_code;
                        $arrear->bcc_name_ru = $arr['bccNameRu'];
                        $arrear->bcc_name_kz = $arr['bccNameKz'];
                        $arrear->tax_arrear = $arr['taxArrear'];
                        $arrear->poena_arrear = $arr['poenaArrear'];
                        $arrear->percent_arrear = $arr['percentArrear'];
                        $arrear->fine_arrear = $arr['fineArrear'];
                        $arrear->total_arrear = $arr['totalArrear'];
                        $arrear->save();
                    }
                }
            }
        }
    }
}