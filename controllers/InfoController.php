<?php

namespace app\controllers;


use Yii;
use app\models\Info;
use app\models\InfoSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InfoController implements the CRUD actions for Info model.
 */
class InfoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Info models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Info model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Info model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Info();




        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Info model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Info model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Info model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Info the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Info::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private static function getInfo() {
        $captcha_id =  Yii::$app->request->post('captcha_id');
        var_export($captcha_id);
        die();
        $captcha = self::resolveCaptcha($captcha_id);
        $inn = Yii::$app->request->post('Info')['inn'];
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('post')
            ->setUrl('http://kgd.gov.kz/apps/services/culs-taxarrear-search-web/rest/search')
            ->addHeaders(['content-type' => 'application/json'])
            ->setContent(json_encode(['iinBin' => $inn, 'captcha-user-value' => $captcha, 'captcha-id' => $captcha_id]))
            ->send();
        return json_decode($response->content);
    }


    private static function resolveCaptcha($captcha_id) {
        $img = self::getCapthaImg('http://kgd.gov.kz/apps/services/CaptchaWeb/generate?uid=' . $captcha_id);
        $antiCaptcha = new ImageToText();
        //$antiCaptcha->setVerboseMode(true);
        $antiCaptcha->setKey('66f5fa58da14ec11bf8082004e0a82e4');
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

