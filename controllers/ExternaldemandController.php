<?php

namespace app\controllers;

use app\models\Demand;
use app\models\User;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\VerbFilter;
use yii\rest\Controller;


class ExternaldemandController extends Controller
{
    public const LOGIN = 'tomoru';
    public const PASS = 'XkddeTYFF2K3';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON,
            ]
        ];
        $behaviors['basicAuth'] = [
            'class' => HttpBasicAuth::class,
            'auth' => function ($username, $password) {
                if ($this->validate($username, $password)) {
                    $user = User::findOne(['login' => 'tomoru']);
                    return $user;
                }
                return null;
            },
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'create' => ['POST'],
            ],
        ];
        return $behaviors;
    }

    public function actionCreate()
    {
        try {
            $errors = [];

            $response = \Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;

            $data = \Yii::$app->getRequest()->getBodyParams();

            $errors = $this->checkData($data);
            if ($errors !== []) {
                throw new \Exception("Ошибка");
            }

            $demand = $this->createDemand($data);

            if ($demand) {
                $response->data = [
                    'success' => true,
                    'type' => 'demand',
                    'id' => $demand->id,
                ];
            } else {
                throw new \Exception("Не удалось создать заявку");
            }
        } catch (\Throwable $e) {
            $response->statusCode = 400;
            $response->data = [
                'success' => false,
                'errors' => $errors,
            ];
        }
    }

    private function validate(string $login, string $pass): bool
    {
        if ($login === self::LOGIN && $pass === self::PASS) {
            return true;
        }
        return false;
    }

    private function createDemand(array $requestData)
    {
        $demand = new Demand();

        $request = $requestData['request_from'];

        $demandText = $request['subject'];
        $demandText .= $request['additional_info'] ? "Информация: " . $request['additional_info'] : '';
        $demandText .= $requestData['last_phrase'] ? "Последний комментарий: " . $requestData['last_phrase'] : '';

        $demand->setScenario(Demand::SCENARIO_CREATE);

        $demand->setAttributes(
            [
                'date' => (new \DateTimeImmutable())->format(DATE_ATOM),
                'status' => Demand::STATUS_NEW,
                'type_id' => 4,
                'prior_id' => 3,
                'master' => 41,
                'contact' => $request['phone'] ?? $requestData['telephone'] ?? 'Нет номера',
                'creator' => $request['name'],
                'demandtext' => $demandText,
                'address' => $request['address'],
            ]
        );

        if ($demand->save(false)) {
            return $demand;
        }
        return false;
    }

    private function checkData(array $requestData): array
    {
        $errors = [];
        if (!isset($requestData['telephone'])) {
            $errors[] = [
                'message' => 'Не передан обязательный параметр "telephone"'
            ];
            return $errors;
        }
        if (!isset($requestData['request_from'])) {
            $errors[] = [
                'message' => 'Не передан обязательный параметр "request_from"'
            ];
            return $errors;
        }
        if (!isset($requestData['request_from']['subject'])) {
            $errors[] = [
                'message' => 'Не передан обязательный параметр "subject"'
            ];
            return $errors;
        }
        if (!isset($requestData['request_from']['name'])) {
            $errors[] = [
                'message' => 'Не передан обязательный параметр "name"'
            ];
            return $errors;
        }
        if (!isset($requestData['request_from']['address'])) {
            $errors[] = [
                'message' => 'Не передан обязательный параметр "address"'
            ];
            return $errors;
        }
        return $errors;
    }
}