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
            throw new \Exception('Can`t resolve captcha');
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
            throw new \Exception('Server does not response');
        }

        $this->json = json_decode($response->content, true);

        //var_dump($this->json);
        //die;
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

            throw new \Exception('Can`t create captcha task');
        }

        $this->request and $this->request->anti_capcha_task_id = $antiCaptcha->getTaskId();
        $this->request and $this->request->save();
        if (!$antiCaptcha->waitForResult()) {
            unlink($img);

            throw new \Exception('Captcha does not answer');
        }

        $captchaText = $antiCaptcha->getTaskSolution();
        unlink($img);

        return ($captchaText);
    }

    private function getCapthaImg($url)
    {
        $img = 'tmp/captcha.jpg';
        if (!is_dir("tmp"))
            mkdir("tmp");
        file_put_contents($img, file_get_contents($url));

        return $img;
    }

    public function saveInfo()
    {
        //foreach ($this->json as $key => $val) {
            if (isset($this->json['captchaError']))
                throw new \Exception($this->json['captchaError']);
            $user = new User();
            $user->iin_bin = $this->json['iinBin'];
            $user->name_ru = $this->json['nameRu'];
            $user->name_kk = $this->json['nameKk'];
            $user->total_arrear = $this->json['totalArrear'];
            $user->total_tax_arrear = $this->json['totalTaxArrear'];
            $user->pension_contribution_arrear = $this->json['pensionContributionArrear'];
            $user->social_contribution_arrear = $this->json['socialContributionArrear'];
            $user->social_health_insurance_arrear = $this->json['socialHealthInsuranceArrear'];
            $user->save();

            $this->request and $this->request->send_time = date("Y-m-d H:s:i", $this->json['sendTime']/1000);
            $this->request and $this->request->user_iin_bin = $user->iin_bin;
            $this->request and $this->request->save();
            $tax_org_info = $this->json['taxOrgInfo'];
            if (is_array($tax_org_info)) {
                foreach ($tax_org_info as $org) {
                    $organisation = new Organisation();
                    $organisation->char_code = $org['charCode'];
                    $organisation->name_ru = $org['nameRu'];
                    $organisation->name_kk = $org['nameKk'];
                    $organisation->report_acrual_date =  date("Y-m-d H:s:i", $org['reportAcrualDate']/1000);
                    $organisation->save();

                    foreach ($org['taxPayerInfo'] as $payer) {
                        foreach ($payer['bccArrearsInfo'] as $arr) {
                            $arrear = new Arrear();
                            $arrear->bcc = $arr['bcc'];
                            $arrear->user_iin_bin = $user->iin_bin;
                            $arrear->organisation_char_code = $organisation->char_code;
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
            else {
                throw new \Exception('Wrong input data');
            }
        }
    //}
}
