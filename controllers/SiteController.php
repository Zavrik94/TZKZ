<?php

namespace app\controllers;

use app\models\Info;
use app\models\InfoSearch;
use yii\httpclient\Client;
use app\models\AntiCaptcha\ImageToText;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new InfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Info();

        if ($model->load(Yii::$app->request->post())) {
            $info = self::getInfo();
            if (!$info)
                return false;
            //save to BD
            $model = new Info();
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    private static function getInfo() {
        $captcha_id =  Yii::$app->request->post('captcha_id');
        $captcha = self::resolveCaptcha($captcha_id);
        if (!$captcha)
            return false;
        $inn = Yii::$app->request->post('Info')['inn'];
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
}
