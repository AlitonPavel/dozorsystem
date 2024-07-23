<?php

namespace app\controllers;

use app\models\Demand;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\ForbiddenHttpException;


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
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'only'  => ['create'],
            'rules' => [
                [
                    'allow' => true,
                    'ips' => ['127.0.0.1', '104.155.28.6'],
                ],
            ],
            'denyCallback' => function ($rule, $action) {
                throw new ForbiddenHttpException('You are not allowed to access this page');
            }
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

        $request = $requestData['request_form'];

        $demandText = $request['subject'];
        $demandText .= $request['additional_info'] ? "Информация: " . $request['additional_info'] : '';
        $demandText .= $requestData['last_phrase'] ? "Последний комментарий: " . $requestData['last_phrase'] : '';

        $demand->setScenario(Demand::SCENARIO_CREATE);

        $demand->setAttributes(
            [
                'date' => (new \DateTimeImmutable())->format(DATE_ATOM),
                'status' => Demand::STATUS_NEW,
                'type_id' => 4,
                'prior_id' => 2,
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
        if (!isset($requestData['request_form'])) {
            $errors[] = [
                'message' => 'Не передан обязательный параметр "request_form"'
            ];
            return $errors;
        }
        if (!isset($requestData['request_form']['subject'])) {
            $errors[] = [
                'message' => 'Не передан обязательный параметр "subject"'
            ];
            return $errors;
        }
        if (!isset($requestData['request_form']['name'])) {
            $errors[] = [
                'message' => 'Не передан обязательный параметр "name"'
            ];
            return $errors;
        }
        if (!isset($requestData['request_form']['address'])) {
            $errors[] = [
                'message' => 'Не передан обязательный параметр "address"'
            ];
            return $errors;
        }
        return $errors;
    }
}
