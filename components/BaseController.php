<?php

namespace app\components;

use app\assets\AppAsset;
use yii\db\ActiveQuery;
use yii\web\Controller;
use Yii;
use app\models\User;
use yii\web\Request;

class BaseController extends Controller
{
    /** @var Request */
    public $request;
    /** @var ActiveQuery */
    public $source;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub

        $this->readRequest();
    }

    public function logoutAndGoHome()
    {
        Yii::$app->user->logout();
        $this->redirect('/');
    }

    public function beforeAction($action)
    {
        if (!Yii::$app->user->isGuest)
        {
            $session = Yii::$app->session;

            $user = User::findOne(Yii::$app->user->id);

            if ($session->has('secretcode'))
            {
                $code = $session->get('secretcode');

                if ($code != $user->secretcode)
                {
                    $this->logoutAndGoHome();
                }
            }
            else
            {
                $this->logoutAndGoHome();
            }
        }
        return parent::beforeAction($action);
    }

    public function readRequest()
    {
        $this->request = Yii::$app->request;
    }

    public function selectData()
    {

    }
}