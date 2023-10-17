<?php


namespace app\controllers;

use app\components\BaseActiveRecord;
use app\components\BaseController;
use app\models\Bank;
use app\models\Client;
use app\models\Demand;
use app\models\DemandType;
use app\models\Equip;
use app\models\Street;
use yii\filters\AccessControl;
use Yii;
use app\models\User;
use app\components\Utils;
use app\models\Objects;
use app\models\DemandPrior;

class SuggestController extends BaseController
{
    const reqModel = 'm';
    const reqSearch = 'term';

    public $modelName;
    public $searchText;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $results = [];

        $this->modelName = Yii::$app->request->get(self::reqModel);
        $this->searchText = Yii::$app->request->get(self::reqSearch);

        switch ($this->modelName) {
            case 's':
                $streets = Street::find()
                    ->joinWith('region')
                    ->addOrderBy('streets.name')
                    ->andFilterWhere(['like', 'CONCAT(regions.name, \', \', streets.name)', $this->searchText])->limit(10)->all();

                $results = array_map(function(Street $street) {
                    return ['id' => $street->id, 'value' => $street->getFullName()];
                }, $streets);
                break;
            case 'c':
                $clients = Client::find()
                    ->addOrderBy('name')
                    ->andFilterWhere(['like', 'name', $this->searchText])->limit(10)->all();

                $results = array_map(function(Client $client) {
                    return ['id' => $client->id, 'value' => $client->name];
                }, $clients);

                break;
            case 'u':
                $users = User::find()
                    ->addOrderBy('surname')
                    ->andFilterWhere(['like', 'surname', $this->searchText])->limit(10)->all();

                $results = array_map(function(User $user) {
                    return ['id' => $user->id, 'value' => $user->getFIO()];
                }, $users);

                break;

            case 'o':
                $objects = Objects::find()
                    ->joinWith('street')
                    ->addOrderBy('streets.name')
                    ->addOrderBy('CAST(objects.corp as SIGNED)')
                    ->addOrderBy('CAST(objects.house as SIGNED)')
                    ->andFilterWhere(['like', "CONCAT(regions.name, ', ', streets.name, ' ', streets.type, '., д.', objects.house, ', корп.', objects.corp)", $this->searchText])->limit(10)->all();

                $results = array_map(function(Objects $object) {
                    return ['id' => $object->id, 'value' => $object->getAddress()];
                }, $objects);

                break;
            case 'b':
                $banks = Bank::find()
                    ->addOrderBy('name')
                    ->andFilterWhere(['like', 'name', $this->searchText])->limit(10)->all();

                $results = array_map(function(Bank $bank) {
                    return ['id' => $bank->id, 'value' => $bank->name];
                }, $banks);

                break;
            case 'e':
                $equips = Equip::find()
                    ->addOrderBy('name')
                    ->andFilterWhere(['like', 'name', $this->searchText])->limit(10)->all();

                $results = array_map(function(Equip $equip) {
                    return [
                        'id'        => $equip->id,
                        'value'     => $equip->name,
                        'priceLow'  => Utils::formatBaseToFormatMoney($equip->pricelow),
                        'priceHigh' =>  Utils::formatBaseToFormatMoney($equip->pricehigh)
                    ];
                }, $equips);

                break;
        }

        return json_encode($results);
    }

    public static function getRangeForSelectInput(int $from, int $to, int $step = 1)
    {
        return array_map(function($v) {
            return ['id' => $v, 'name' => $v];
        }, Utils::getRange($from, $to, $step));
    }

    /**
     * @param BaseActiveRecord[] $items
     * @param string $fieldValue
     * @param string $fieldTitle
     * @return array
     */
    public static function getModelForSelectInput(array $items, string $fieldValue, string $fieldTitle) : array
    {
        return array_map(function(BaseActiveRecord $item) use ($fieldValue, $fieldTitle) {
            if ($item->hasAttribute($fieldTitle)) {
                return ['id' => $item->getAttribute($fieldValue), 'name' => $item->getAttribute($fieldTitle)];
            }
            else
            {
                return ['id' => $item->getAttribute($fieldValue), 'name' => $item->{$fieldTitle}()];
            }
        }, $items);
    }

    public static function getDemandTypesForSelectInput()
    {
        return self::getModelForSelectInput(DemandType::find()->andWhere('deldate is null')->all(), 'id', 'name');
    }

    public static function getDemandPriorsForSelectInput()
    {
        return self::getModelForSelectInput(DemandPrior::find()->andWhere('deldate is null')->all(), 'id', 'name');
    }

    public static function getUsersForSelectInput()
    {
        return self::getModelForSelectInput(User::find()->andWhere('deldate is null')->addOrderBy('surname')->all(), 'id', 'getFIO');
    }

    public static function getStatusesForSelectInput()
    {
        return array_map(
            function ($key, $value) {
                return ['id' => $key, 'name' => $value];
            },
            array_keys(Demand::statuses),
            Demand::statuses
        );
    }

    public static function getTypePaySelectInput()
    {
        return [
            ['id' => 'БН', 'name' => 'БН'],
            ['id' => 'Наличные', 'name' => 'Наличные']
        ];
    }
}