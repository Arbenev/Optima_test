<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class UserController extends Controller
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    public function __construct($id, $module = null)
    {
        parent::__construct($id, $module);
        $this->setPageTitle('Optima - test task | Users');
    }

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return [
            ['allow', // allow all users to perform 'index' and 'view' actions
                'actions' => ['index', 'view'],
                'users' => ['*'],
            ],
            ['allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => ['create', 'update'],
                'users' => ['@'],
            ],
            ['allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => ['admin', 'delete', 'send'],
                'users' => ['admin'],
            ],
            ['deny', // deny all users
                'users' => ['*'],
            ],
        ];
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new User;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('User');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User'])) {
            $model->attributes = $_GET['User'];
        }
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionSend($id)
    {

        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end('Must be only AJAX request', 400);
        }

        $user = User::model()->findByPk($id);
        if (!$user) {
            echo json_encode(['error' => 'User not found']);
            return;
        }
        $settings = Yii::app()->params['mail'];
        $r = $this->sendMail($settings, [$user->email], 'Добро пожаловать', 'Добро пожаловать к нам');
        if ($r) {
            echo json_encode(['result' => 'OK']);
        } else {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['result' => 'Failed to send email']);
            exit;
        }
    }

    private function sendMail(array $settings, array $to, string $subject, string $body)
    {
        $mail = new PHPMailer(true);
        try {
//            $mail->SMTPDebug = SMTP::DEBUG_CLIENT;
            $mail->isSMTP();
            $mail->Host = $settings['host'];
            $mail->SMTPAuth = $settings['auth'];
            $mail->Username = $settings['username'];
            $mail->Password = $settings['password'];
            $mail->SMTPSecure = $settings['secure'];
            $mail->Port = $settings['port'];
            $mail->CharSet = $settings['charset'];
            $mail->setFrom($settings['from'], $settings['fromName']);
            foreach ($to as $email) {
                $mail->addAddress($email);
            }
            $mail->isHTML($settings['is_html']);
            $mail->Subject = $subject;
            $mail->Body = $body;
            return $mail->send();
        } catch (\PHPMailer\PHPMailer\Exception $e) {
            Yii::log($e->errorMessage(), CLogger::LEVEL_ERROR, 'application');
            return false;
        } catch (\Exception $e) {
            Yii::log($e->errorMessage(), CLogger::LEVEL_ERROR, 'application');
            return false;
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = User::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param User $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
