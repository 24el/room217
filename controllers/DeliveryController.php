<?php

namespace app\controllers;

use app\models\Comment;
use app\models\DeliveryOrders;
use app\models\Order;
use app\models\Orders;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\EntryForm;
use app\models\Registration;
use yii\web\NotFoundHttpException;
use yii\web\User;

class DeliveryController extends Controller
{
    /**
     * @inheritdoc
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
                    [
                        'actions' => ['registration'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],

        ];
    }

    /**
     * @inheritdoc
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
        return $this->render('index');
    }

    public function actionEntry(){
        $model = new EntryForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // данные в $model удачно проверены

            // делаем что-то полезное с $model ...

            return $this->render('entry-confirm', ['model' => $model]);
        } else {
            // либо страница отображается первый раз, либо есть ошибка в данных
            return $this->render('entry', ['model' => $model]);
        }
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('index.php?r=delivery/index');

        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionCity_change($city){
        if(\app\models\User::cityChange(Yii::$app->user->identity->id, $city)){
            Yii::$app->user->identity->city = $city;
            return $this->redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function actionRegistration(){
        $model = new Registration();

        if($model->load(Yii::$app->request->post()) && $model->registrationUser()){
            return $this->render('successRegistration');
        }
        return $this->render('registration', ['model' => $model]);
    }

    public function actionRegistrationConfirm($regCode){
        $model = new Registration();
        if($model->registrationConfirm($regCode)){
            $this->goHome();
        }else{
            throw new NotFoundHttpException;
        }

    }
    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect('index.php?r=delivery/index');
    }

    public function actionProfile($id){
        $userModel = new \app\models\User();
        $user = $userModel->findIdentity($id);
        if($user){
            $commentModel = new Comment();
            $userEmplComments = $commentModel->getUserEmplComments($id);
            $userCustComments = $commentModel->getUserCustComments($id);
            return $this->render('profile', [
                'user' => $user,
                'userEmplComm' => $userEmplComments,
                'userCustComm' => $userCustComments,
                'countUserOrd' => Order::countUserDoneOrders($id),
                'countEmplOrd' => Order::countEmplUserOrders($id)
            ]);
        }
    }

    public function actionMy_profile(){
        $deliveryModel = new DeliveryOrders();
        $commentModel = new Comment();
        $userId = Yii::$app->user->identity->id;
        $doneOrders = $deliveryModel->getHistoryOrders();
        $userOrders = $deliveryModel->getUserHistoryOrders();
        $userEmplComments = $commentModel->getUserEmplComments($userId);
        $userCustComments = $commentModel->getUserCustComments($userId);
        $sendEmplComments = $commentModel->getSendEmplComments($userId);
        $sendCustComments = $commentModel->getSendCustComment($userId);
        return $this->render('myProfile.php', [
                'doneOrders' => $doneOrders,
                'userEmplComm' => $userEmplComments,
                'userCustComm' => $userCustComments,
                'sendEmplComm' => $sendEmplComments,
                'sendCustComm' => $sendCustComments,
                'userOrders' => $userOrders,
                'deliveryModel' => $model
            ]);
    }
    /**
     * Displays contact page.
     *
     * @return string
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
}